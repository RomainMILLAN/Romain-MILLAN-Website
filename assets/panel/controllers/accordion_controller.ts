// @ts-ignore
import { Controller } from '@hotwired/stimulus';

declare const bootstrap: any;

export default class extends Controller {
    static targets = ["item"];

    declare readonly itemTargets: HTMLElement[];

    public collapseAll(): void {
        this.itemTargets.forEach((item) => {
            const instance = bootstrap.Collapse.getInstance(item);
            if (instance) {
                instance.hide();
            }
        });
    }
}
