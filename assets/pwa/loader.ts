if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/service_worker.js')
    .then((registration) => {
      console.log(`✅ Service worker registration succeeded:`, registration);
    })
    .catch((error) => {
      console.log(`🚨 Service worker registration failed:`, error);
    })
  ;
} else {
  console.log(`🔒️ Service workers are not supported.`);
}
