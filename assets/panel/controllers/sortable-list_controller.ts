// @ts-ignore
import { Controller } from '@hotwired/stimulus';
// @ts-ignore
import Sortable from 'sortablejs';

export default class extends Controller {
    static values = {
        url: String,
    };

    declare readonly urlValue: string;

    private sortable?: Sortable;
    private snapshot: string[] = [];

    connect(): void {
        this.sortable = Sortable.create(this.element as HTMLElement, {
            handle: '[data-sortable-list-target="handle"]',
            animation: 150,
            ghostClass: 'opacity-50',
            onStart: () => {
                this.snapshot = this.currentIds();
            },
            onEnd: () => {
                const ids = this.currentIds();
                if (this.sameOrder(ids, this.snapshot)) {
                    return;
                }
                void this.persist(ids);
            },
        });
    }

    disconnect(): void {
        this.sortable?.destroy();
        this.sortable = undefined;
    }

    private currentIds(): string[] {
        return Array.from(this.element.querySelectorAll<HTMLTableRowElement>('tr[data-id]'))
            .map((row) => row.dataset.id ?? '')
            .filter((id) => id !== '');
    }

    private sameOrder(a: string[], b: string[]): boolean {
        if (a.length !== b.length) return false;
        return a.every((value, index) => value === b[index]);
    }

    private async persist(ids: string[]): Promise<void> {
        const tbody = this.element as HTMLElement;
        tbody.classList.add('opacity-50');

        try {
            const response = await fetch(this.urlValue, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids: ids.map((id) => Number(id)) }),
            });

            if (!response.ok) {
                throw new Error(`Reorder failed with status ${response.status}`);
            }
        } catch (error) {
            console.error('[sortable-list] reorder failed', error);
            this.sortable?.sort(this.snapshot, true);
        } finally {
            tbody.classList.remove('opacity-50');
        }
    }
}
