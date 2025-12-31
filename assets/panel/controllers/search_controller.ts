// @ts-ignore
import { Controller } from '@hotwired/stimulus';
// @ts-ignore
import { useClickOutside, useDebounce } from 'stimulus-use';

export default class extends Controller {
    static values = {
        searchUrl: String,
    }

    static targets = ["dropdown", "form", "input", "resultContainer"];
    static debounces = ['onSearchInput'];

    declare readonly dropdownTarget: HTMLDivElement;
    declare readonly formTarget: HTMLFormElement;
    declare readonly inputTarget: HTMLInputElement;
    declare readonly resultContainerTarget: HTMLDivElement;
    declare readonly searchUrlValue: string;
    defaultEmptyResult!: string;

    connect(): void {
        this.inputTarget.value = '';
        this.defaultEmptyResult = `<p class="fst-italic text-center">Rechercher ...</p>`;

        useClickOutside(this);
        useDebounce(this);

        this.inputTarget.addEventListener('keydown', this.handleKeyDown);
        this.formTarget.addEventListener('submit', function (event: any) {
            event.preventDefault();
            this.onSearchInput();
        })
    }

    disconnect(): void {
        this.inputTarget.removeEventListener('keydown', this.handleKeyDown);
    }

    public openDropdown(): void
    {
        this.dropdownTarget.classList.add('show');
        this.dropdownTarget.setAttribute('data-bs-popper', 'static');
    }
    
    private closeDropdown(resetInput: Boolean = true): void
    {
        this.dropdownTarget.classList.remove('show');
        this.dropdownTarget.removeAttribute('data-bs-popper');
        this.resultContainerTarget.innerHTML = this.defaultEmptyResult;

        if (resetInput) {
            this.inputTarget.value = '';
        }
    }

    private handleKeyDown = (event: KeyboardEvent): void => {
        if (event.key === 'Enter') {
            event.preventDefault();
            this.onSearchInput();
        }
    }

    public onSearchInput() {
        this.search(this.inputTarget.value);
    }

    public async search(query: any): Promise<void> {
        if (this.inputTarget.value.length < 3) {
            this.closeDropdown(false)
            return;
        }

        try {
            const url = new URL(this.searchUrlValue.toString());
            url.searchParams.set("query", query);

            const response = await fetch(url.toString(), {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });

            if (!response.ok) throw new Error('Failed to search api');

            this.openDropdown();
            this.resultContainerTarget.innerHTML = await response.text();

        } catch (error) {
            console.error("❌ Failed to search :", error);
            this.resultContainerTarget.innerHTML = this.defaultEmptyResult;
        }
    }

    public clickOutside() {
        this.closeDropdown();
    }

}
