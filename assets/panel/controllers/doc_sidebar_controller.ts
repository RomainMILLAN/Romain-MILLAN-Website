// @ts-ignore
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input', 'list', 'item', 'counter'];

    declare readonly inputTarget: HTMLInputElement;
    declare readonly itemTargets: HTMLElement[];
    declare readonly counterTarget: HTMLElement;
    declare readonly hasCounterTarget: boolean;

    public filter(): void {
        const needle = this.inputTarget.value.trim().toLowerCase();
        let visible = 0;

        this.itemTargets.forEach((item) => {
            const haystack = (item.dataset.name ?? '').toLowerCase();
            const match = needle === '' || haystack.includes(needle);
            item.classList.toggle('d-none', !match);
            if (match) visible++;
        });

        if (this.hasCounterTarget) {
            this.counterTarget.textContent = `${visible} page(s)`;
        }
    }
}
