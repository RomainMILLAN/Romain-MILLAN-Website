import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static targets = ["select", "preview"];

  declare readonly selectTarget: HTMLSelectElement;
  declare readonly previewTarget: HTMLImageElement;

  connect(): void {
    this.update();
  }

  public update(): void {
    const selected = this.selectTarget.options[this.selectTarget.selectedIndex];
    const src = selected?.dataset.src;

    if (!src) {
      this.previewTarget.classList.add("d-none");
      this.previewTarget.removeAttribute("src");
      return;
    }

    this.previewTarget.src = src;
    this.previewTarget.classList.remove("d-none");
  }
}
