// @ts-ignore
import { Controller } from '@hotwired/stimulus';
// @ts-ignore
import { Popover } from 'bootstrap';

export default class extends Controller {
    static targets = ['trigger', 'content'];
    static values = {
        placement: { type: String, default: 'top' },
        title: { type: String, default: '' },
    };

    declare readonly triggerTarget: HTMLElement;
    declare readonly contentTarget: HTMLElement;
    declare readonly placementValue: string;
    declare readonly titleValue: string;

    private popover?: Popover;

    connect(): void {
        this.popover = new Popover(this.triggerTarget, {
            html: true,
            sanitize: false,
            trigger: 'click',
            placement: this.placementValue as any,
            title: this.titleValue,
            content: this.contentTarget.innerHTML,
        });

        document.addEventListener('click', this.handleCopy);
    }

    disconnect(): void {
        document.removeEventListener('click', this.handleCopy);
        this.popover?.dispose();
        this.popover = undefined;
    }

    private handleCopy = async (event: Event): Promise<void> => {
        const target = event.target as HTMLElement | null;
        const btn = target?.closest<HTMLElement>('[data-popover-copy]');
        if (!btn) return;

        event.preventDefault();

        const text = btn.dataset.popoverCopy ?? '';
        try {
            await navigator.clipboard.writeText(text);
        } catch {
            return;
        }

        const label = btn.querySelector<HTMLElement>('[data-popover-copy-label]') ?? btn;
        const original = label.textContent;
        label.textContent = 'Copié !';
        setTimeout(() => { label.textContent = original; }, 1500);
    };
}
