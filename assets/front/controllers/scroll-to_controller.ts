import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  connect() {
    console.log("ScrollTo controller connected 🔍️");
  }

  public scroll(event: any): void {
    // @ts-ignore
    document.getElementById(event.params.id).scrollIntoView({ behavior: 'smooth' })
  }
}
