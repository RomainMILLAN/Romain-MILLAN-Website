// @ts-ignore
import { Controller } from '@hotwired/stimulus';
// @ts-ignore
import { useClickOutside, useDebounce } from 'stimulus-use';

// Contrat partagé avec le userscript Tampermonkey (assets/panel/userscripts/
// panel-search-shortcut.user.js). Version de PROTOCOLE, découplée de la version
// applicative : ne l'incrémenter que si la forme du message change. Doit rester
// identique des deux côtés.
const OPEN_SEARCH_MESSAGE = 'panel:open-search:v1';

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

        document.addEventListener('keydown', this.handleGlobalKeyDown);
        window.addEventListener('message', this.handleIframeMessage);
        this.inputTarget.addEventListener('keydown', this.handleKeyDown);

        this.formTarget.addEventListener('submit', (event: Event) => {
            event.preventDefault();
            this.onSearchInput();
        });
    }

    disconnect(): void {
        document.removeEventListener('keydown', this.handleGlobalKeyDown);
        window.removeEventListener('message', this.handleIframeMessage);
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

    private handleGlobalKeyDown = (event: KeyboardEvent): void => {
        if (
            event.target instanceof HTMLInputElement ||
            event.target instanceof HTMLTextAreaElement
        ) {
            if (event.key === 'Escape') {
                this.closeDropdown();
                this.inputTarget.blur();
            }

            return;
        }

        if ((event.ctrlKey || event.metaKey) && event.shiftKey && event.key.toLowerCase() === 'k') {
            event.preventDefault();

            this.openSearch();
        }
    };

    // Quand le focus est dans l'iframe d'une application (cross-origin), le navigateur
    // livre le keydown au document de l'iframe : handleGlobalKeyDown ne le voit jamais.
    // Le userscript injecté dans l'iframe relaie alors le raccourci via postMessage.
    private handleIframeMessage = (event: MessageEvent): void => {
        // Ne parler qu'à nos amis : le message doit venir de NOTRE iframe enfant,
        // pas d'un onglet ou d'une frame quelconque. On ne peut pas whitelister
        // event.origin (apps d'origines arbitraires) ; on valide donc la source.
        const iframe = document.getElementById('myIframe') as HTMLIFrameElement | null;
        if (!iframe || event.source !== iframe.contentWindow) return;

        if (event.data?.type !== OPEN_SEARCH_MESSAGE) return;

        this.openSearch();
    };

    private openSearch(): void {
        this.inputTarget.focus();
        this.inputTarget.select();

        this.openDropdown();
    }


}
