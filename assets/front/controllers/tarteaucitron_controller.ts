import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static values = {
    logoUrl: String,
    matomoSiteId: String,
    matomoHostValue: String,
  }

  declare readonly logoUrlValue: string|null;
  declare readonly matomoSiteIdValue: string|null;
  declare readonly matomoHostValue: string|null;

  connect() {
    console.log("tarteaucitron controller connected 📝")
    this.initialize();

    if(this.matomoSiteIdValue != null && this.matomoHostValue != null) {
      this.matomo();
    }
  }

  initialize(): void
  {
    // eslint-disable-next-line no-undef
    // @ts-ignore
    tarteaucitron.init({
      privacyUrl: '', /* Privacy policy url */
      hashtag: '#tarteaucitron', /* Open the panel with this hashtag */
      cookieName: 'tarteaucitron', /* Cookie name */
      orientation: 'middle', /* Banner position (top - bottom) */
      groupServices: true, /* Group services by category */
      showAlertSmall: true, /* Show the small banner on bottom right */
      cookieslist: false, /* Show the cookie list */
      closePopup: true, /* Show a close X on the banner */
      showIcon: true, /* Show cookie icon to manage cookies */
      iconSrc: this.logoUrlValue, /* Optionnal: URL or base64 encoded image */
      iconPosition: 'BottomLeft', /* BottomRight, BottomLeft, TopRight and TopLeft */
      adblocker: false, /* Show a Warning if an adblocker is detected */
      DenyAllCta: true, /* Show the deny all button */
      AcceptAllCta: true, /* Show the accept all button when highPrivacy on */
      highPrivacy: true, /* HIGHLY RECOMMANDED Disable auto consent */
      handleBrowserDNTRequest: false, /* If Do Not Track == 1, disallow all */
      removeCredit: false, /* Remove credit link */
      moreInfoLink: true, /* Show more info link */
      useExternalCss: false, /* If false, the tarteaucitron.css file will be loaded */
      useExternalJs: false, /* If false, the tarteaucitron.js file will be loaded */
      // "cookieDomain": ".my-multisite-domaine.fr", /* Shared cookie for multisite */
      readmoreLink: '', /* Change the default readmore link */
      mandatory: true /* Show a message about mandatory cookies */
    })
  }

  private matomo(): void
  {
    // eslint-disable-next-line no-undef
    // @ts-ignore
    tarteaucitron.user.matomoId = this.matomoSiteIdValue;

    // eslint-disable-next-line no-undef
    // @ts-ignore
    tarteaucitron.user.matomoHost = this.matomoHostValue;

    // eslint-disable-next-line no-undef
    // @ts-ignore
    (tarteaucitron.job = tarteaucitron.job || []).push('matomo');
  }
}
