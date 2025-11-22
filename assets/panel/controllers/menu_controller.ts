// @ts-ignore
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["container", "actionButton", "dropdownToggle", "dropdownMenu"];

    declare readonly containerTarget: HTMLDivElement;
    declare readonly actionButtonTarget: HTMLButtonElement;
    declare readonly dropdownToggleTargets: HTMLElement[];
    declare readonly dropdownMenuTargets: HTMLElement[];

    /*
     * MAIN NAV COLLAPSE
     */
    public toggle(): void {
        const isOpened = this.containerTarget.classList.contains('show');

        if (isOpened) {
            this.close();
        } else {
            this.open();
        }
    }

    private close(): void {
        this.containerTarget.classList.remove('show');
        this.actionButtonTarget.classList.add('collapsed');
        this.actionButtonTarget.setAttribute('aria-expanded', 'false');
    }

    private open(): void {
        this.containerTarget.classList.add('show');
        this.actionButtonTarget.classList.remove('collapsed');
        this.actionButtonTarget.setAttribute('aria-expanded', 'true');
    }

    /*
     * DROPDOWN
     */
    public toggleDropdown(event: Event): void {
        event.preventDefault();
        event.stopPropagation();

        const toggle = event.currentTarget as HTMLElement;
        const menu = toggle.nextElementSibling as HTMLElement;

        const isOpen = toggle.classList.contains('show');

        // Close all other dropdowns first
        this.closeAllDropdowns();

        if (!isOpen) {
            toggle.classList.add('show');
            menu.classList.add('show');
            menu.setAttribute('data-bs-popper', 'static');
            toggle.setAttribute('aria-expanded', 'true');
        } else {
            toggle.classList.remove('show');
            menu.classList.remove('show');
            toggle.setAttribute('aria-expanded', 'false');
        }
    }

    private closeAllDropdowns(): void {
        this.dropdownToggleTargets.forEach(t => {
            t.classList.remove('show');
            t.setAttribute('aria-expanded', 'false');
        });

        this.dropdownMenuTargets.forEach(m => {
            m.classList.remove('show');
        });
    }

}
