// @ts-ignore
import { Controller } from '@hotwired/stimulus';
// @ts-ignore
import Editor from '@toast-ui/editor';
// @ts-ignore
import TomSelect from 'tom-select';

export default class extends Controller {
    static targets = ['editor', 'title', 'tags', 'status'];
    static values = {
        pageId: Number,
        saveUrl: String,
        initialContent: String,
        csrfToken: String,
    };

    declare readonly editorTarget: HTMLElement;
    declare readonly titleTarget: HTMLInputElement;
    declare readonly tagsTarget: HTMLSelectElement;
    declare readonly hasStatusTarget: boolean;
    declare readonly statusTarget: HTMLElement;
    declare readonly saveUrlValue: string;
    declare readonly initialContentValue: string;
    declare readonly csrfTokenValue: string;

    private editor: any;
    private tomSelect: any;
    private saveTimer: number | null = null;
    private readonly saveDelayMs = 1500;

    connect(): void {
        this.editor = new Editor({
            el: this.editorTarget,
            previewStyle: 'tab',
            initialEditType: 'markdown',
            height: '60vh',
            initialValue: this.initialContentValue ?? '',
            usageStatistics: false,
            events: {
                change: () => this.scheduleSave(),
            },
        });

        this.tomSelect = new TomSelect(this.tagsTarget, {
            persist: false,
            create: true,
            createOnBlur: true,
            plugins: ['remove_button'],
            onChange: () => this.scheduleSave(),
        });
    }

    disconnect(): void {
        if (this.saveTimer !== null) {
            window.clearTimeout(this.saveTimer);
            this.saveTimer = null;
        }
        this.tomSelect?.destroy();
        this.editor?.destroy();
    }

    public titleChanged(): void {
        this.scheduleSave();
    }

    private scheduleSave(): void {
        this.setStatus('Modifications…', 'bg-warning-lt');

        if (this.saveTimer !== null) {
            window.clearTimeout(this.saveTimer);
        }
        this.saveTimer = window.setTimeout(() => this.save(), this.saveDelayMs);
    }

    private async save(): Promise<void> {
        const payload = {
            title: this.titleTarget.value,
            content: this.editor.getMarkdown(),
            tagNames: Array.from(this.tagsTarget.selectedOptions).map((o) => o.value),
        };

        try {
            const response = await fetch(this.saveUrlValue, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': this.csrfTokenValue,
                },
                body: JSON.stringify(payload),
            });

            if (!response.ok) throw new Error(`Save failed (${response.status})`);

            this.setStatus('Enregistré', 'bg-success-lt');
        } catch (error) {
            console.error('❌ Auto-save failed:', error);
            this.setStatus('Échec', 'bg-danger-lt');
        }
    }

    private setStatus(label: string, bgClass: string): void {
        if (!this.hasStatusTarget) return;
        this.statusTarget.className = `badge ${bgClass}`;
        this.statusTarget.textContent = label;
    }
}
