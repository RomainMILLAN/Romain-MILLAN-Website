// @ts-ignore
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static values = {
      notificationVapidPublicKey: String,
      registerPushNotificationUrl: String,
  }

  declare readonly notificationVapidPublicKeyValue: string;
  declare readonly registerPushNotificationUrlValue: string;

  support(): boolean {
    return ('serviceWorker' in navigator) && ('PushManager' in window);
  }

  async register(): Promise<void> {
    console.log(this.support());
      if (!this.support()) {
          return;
      }

      await this.askPermission();
      const registration: ServiceWorkerRegistration = await this.getOrRegisterServiceWorker();
      const subscription: PushSubscription = await this.getOrSubscribeUser(registration);

      await this.registerPushNotification(subscription);
  }

  async getOrRegisterServiceWorker() {
      let registration = await navigator.serviceWorker.getRegistration();

      if (!registration) {
          registration = await navigator.serviceWorker.register('/service_worker.js');
          console.log('[Notification/SW] Registered');
      } else {
          console.log('[Notification/SW] Already registered');
      }

      return registration;
  }

  async askPermission(): Promise<void> {
      return new Promise(function(resolve, reject) {
          const permissionResult = Notification.requestPermission(function(result) {
              resolve(result);
          });

          if (permissionResult) {
              permissionResult.then(resolve, reject);
          }
      })
      .then(function(permissionResult) {
          if (permissionResult !== 'granted') {
              throw new Error('We weren\'t granted permission.');
          }
      });
  }

  async getOrSubscribeUser(registration: ServiceWorkerRegistration): Promise<PushSubscription> {
      const existingSubscription = await registration.pushManager.getSubscription();

      if (existingSubscription) {
          console.log('[Notification] Already subscribed');

          return existingSubscription;
      }

      const subscription = await registration.pushManager.subscribe({
          userVisibleOnly: true,
          applicationServerKey: this.notificationVapidPublicKeyValue,
      });

      console.log('[Notification] New subscription');

      return subscription;
  }

  async registerPushNotification(pushSubscription: PushSubscription): Promise<void> {
      const body = {
          endpoint: pushSubscription.endpoint,
          keys: {
              // @ts-ignore
              p256dh: pushSubscription.toJSON().keys.p256dh,
              // @ts-ignore
              auth: pushSubscription.toJSON().keys.auth,
          }
      };

      await fetch(this.registerPushNotificationUrlValue, {
          body: JSON.stringify(body),
          headers: {
              'content-type': 'application/json',
          },
          method: 'POST',
      })
  }

}
