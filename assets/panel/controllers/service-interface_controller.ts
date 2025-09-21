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

    this.isFullscreen = false;
    this.iconeExitTarget.classList.add('disappeared');
  }

  public toggle(): void
  {
    this.isFullscreen ? this.disable() : this.enable();
  }

  public enable(): void
  {
    this.isFullscreen = true;

    this.footerTarget?.classList.add('disappeared');
    this.pageHeaderPretitleTarget?.classList.add('disappeared');

    this.pageBodyTarget.style.setProperty("margin-top", "0px", "important");
    this.pageHeaderTarget.style.setProperty("margin-top", "0px", "important");

    this.iconeOpenTarget.classList.add('disappeared');
    this.iconeExitTarget.classList.remove('disappeared');
  }

  public disable(): void
  {
    this.isFullscreen = false;

    this.footerTarget?.classList.remove('disappeared');
    this.pageHeaderPretitleTarget?.classList.remove('disappeared');

    this.pageBodyTarget.style.removeProperty("margin-top");
    this.pageHeaderTarget.style.removeProperty("margin-top");

    this.iconeExitTarget.classList.add('disappeared');
    this.iconeOpenTarget.classList.remove('disappeared');
  }

}
