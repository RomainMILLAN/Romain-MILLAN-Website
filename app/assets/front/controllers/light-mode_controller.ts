import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static targets = ["light", "dark", "body"];

  declare readonly lightTarget: HTMLInputElement;
  declare readonly darkTarget: HTMLInputElement;
  declare readonly bodyTarget: HTMLInputElement;

  connect() {
    console.log("LightMode controller connected 💡");
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

}
