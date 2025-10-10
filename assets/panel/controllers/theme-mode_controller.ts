import { Controller } from "@hotwired/stimulus";

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static targets = ["body"];

  declare readonly bodyTarget: HTMLInputElement;

  connect() {
    this.detectThemeChange();
  }

  public switchToLightMode(): void {
    this.bodyTarget.setAttribute('data-bs-theme', 'light')
  }

  public switchToDarkMode(): void {
    this.bodyTarget.setAttribute('data-bs-theme', 'dark')
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
