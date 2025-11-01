self.addEventListener('install', (event) => {
  self.skipWaiting();

  console.log(`[PWA/ServiceWorker] Install`);
  console.log(event);
});

self.addEventListener('activate', (event) => {
  self.clients.claim();

  console.log(`[PWA/ServiceWorker] activate`);
  console.log(event);
});