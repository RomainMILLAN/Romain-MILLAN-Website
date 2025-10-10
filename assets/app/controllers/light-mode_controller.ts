import { Controller } from "@hotwired/stimulus";

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static targets = ["light", "dark", "body"];

  declare readonly lightTarget: HTMLInputElement;
  declare readonly darkTarget: HTMLInputElement;
  declare readonly bodyTarget: HTMLInputElement;

  connect() {
    this.detectThemeChange();
  }

  public switchToLightMode(): void {
    this.darkTarget.style.display = 'flex';
    this.lightTarget.style.display = 'none';
    this.bodyTarget.classList.remove('dark-mode');
  }

  public switchToDarkMode(): void {
    this.darkTarget.style.display = 'none';
    this.lightTarget.style.display = 'flex';
    this.bodyTarget.classList.add('dark-mode');
  }

  public detectThemeChange(): void {
    const darkModeMediaQuery: MediaQueryList = window.matchMedia('(prefers-color-scheme: dark)');

    if (darkModeMediaQuery.matches) {
      this.switchToDarkMode();
    } else {
      this.switchToLightMode()
    }

    darkModeMediaQuery.addEventListener('change', (event: MediaQueryListEvent): void => {
      if (event.matches) {
        this.switchToDarkMode();
      } else {
        this.switchToLightMode()
      }
    });
  }

}
