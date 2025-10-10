import { Controller } from "@hotwired/stimulus";

/* stimulusFetch: 'eager' */
export default class extends Controller {
  static targets = ["light", "dark", "body"];

  declare readonly lightTarget: HTMLElement;
  declare readonly darkTarget: HTMLElement;
  declare readonly bodyTarget: HTMLElement;

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

    this.darkTarget.style.display = isDark ? "none" : "flex";
    this.lightTarget.style.display = isDark ? "flex" : "none";

    this.bodyTarget.classList.toggle("dark-mode", isDark);

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
