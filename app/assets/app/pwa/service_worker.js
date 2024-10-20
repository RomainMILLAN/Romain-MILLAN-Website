const VERSION = 'V2.0';

self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    self.clients.claim();
    console.log(`${VERSION} Running`)
});

self.addEventListener('fetch', (event) => {
});
