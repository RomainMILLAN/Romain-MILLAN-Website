import { Controller } from "@hotwired/stimulus";

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static targets = ["iconeOpen", "iconeExit"];

  declare readonly iconeOpenTarget: HTMLElement;
  declare readonly iconeExitTarget: HTMLElement;

  declare isFullscreen: boolean;

  declare footerTarget: HTMLDivElement;
  declare pageHeaderTarget: HTMLDivElement;
  declare pageHeaderPretitleTarget: HTMLDivElement;
  declare pageBodyTarget: HTMLDivElement;

  connect() {
    this.footerTarget = document.getElementById('footer') as HTMLDivElement;
    this.pageHeaderTarget = document.getElementById('page-header') as HTMLDivElement;
    this.pageHeaderPretitleTarget = document.getElementById('page-pretitle') as HTMLDivElement;
    this.pageBodyTarget = document.getElementById('page-body') as HTMLDivElement;

    // Read fullscreen state from session storage
    const storedFullscreen = sessionStorage.getItem('fullscreen');
    this.isFullscreen = storedFullscreen === 'true';

    // Initialize icons based on state
    if (this.isFullscreen) {
      this.enable(false); // false to prevent double sessionStorage set
    } else {
      this.disable(false);
    }
  }

  public toggle(): void {
    this.isFullscreen ? this.disable() : this.enable();
  }

  public enable(store: boolean = true): void {
    this.isFullscreen = true;

    this.footerTarget?.classList.add('disappeared');
    this.pageHeaderPretitleTarget?.classList.add('disappeared');

    this.pageBodyTarget.style.setProperty("margin-top", "0px", "important");
    this.pageHeaderTarget.style.setProperty("margin-top", "0px", "important");

    this.iconeOpenTarget.classList.add('disappeared');
    this.iconeExitTarget.classList.remove('disappeared');

    if (store) sessionStorage.setItem('fullscreen', 'true');
  }

  public disable(store: boolean = true): void {
    this.isFullscreen = false;

    this.footerTarget?.classList.remove('disappeared');
    this.pageHeaderPretitleTarget?.classList.remove('disappeared');

    this.pageBodyTarget.style.removeProperty("margin-top");
    this.pageHeaderTarget.style.removeProperty("margin-top");

    this.iconeExitTarget.classList.add('disappeared');
    this.iconeOpenTarget.classList.remove('disappeared');

    if (store) sessionStorage.setItem('fullscreen', 'false');
  }
}
