import { Controller } from "@hotwired/stimulus";

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static targets = ["body"];

  declare readonly bodyTarget: HTMLInputElement;

  connect() {
    this.applySavedTheme();
    this.observeSystemPreference();
  }

  public switchToLightMode(): void {
    this.setTheme("light");
  }

  public switchToDarkMode(): void {
    this.setTheme("dark");
  }

  private setTheme(theme: "light" | "dark"): void {
    const isDark = theme === "dark";

    this.bodyTarget.classList.toggle("dark-mode", isDark);
    document.documentElement.setAttribute("data-bs-theme", theme);

    localStorage.setItem("theme", theme);
  }

  private applySavedTheme(): void {
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "dark") {
      this.switchToDarkMode();
    } else if (savedTheme === "light") {
      this.switchToLightMode();
    } else {
      this.applySystemPreference();
    }
  }

  private applySystemPreference(): void {
    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

    if (prefersDark) {
      this.switchToDarkMode();
    } else {
      this.switchToLightMode();
    }
  }

  private observeSystemPreference(): void {
    const darkModeMediaQuery = window.matchMedia("(prefers-color-scheme: dark)");

    darkModeMediaQuery.addEventListener("change", (event: MediaQueryListEvent): void => {
      if (!localStorage.getItem("theme")) {
        if (event.matches) {
          this.switchToDarkMode();
        } else {
          this.switchToLightMode();
        }
      }
    });
  }

}
