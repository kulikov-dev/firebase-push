
 // Give the service worker access to Firebase Messaging.
 importScripts('https://www.gstatic.com/firebasejs/9.11.0/firebase-app-compat.js');
 importScripts('https://www.gstatic.com/firebasejs/9.11.0/firebase-messaging-compat.js');

 // Web app's Firebase configuration
 const firebaseConfig = {
   apiKey: "AIzaSyD4kj2g3e_SOQTmzBUtDn2_vx6UvcdWiG8",
   authDomain: "kulikov-dev.firebaseapp.com",
   projectId: "kulikov-dev",
   storageBucket: "kulikov-dev.appspot.com",
   messagingSenderId: "441130914859",
   appId: "1:441130914859:web:2cb9c5736e4a595af0066e"
 };

 firebase.initializeApp(firebaseConfig);

 // Retrieve an instance of Firebase Messaging so that it can handle background messages.
 const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);

  // Copy data object to get parameters in the click handler
  payload.data.data = JSON.parse(JSON.stringify(payload.data));

  return self.registration.showNotification(payload.data.title, payload.data);
});

 self.addEventListener('notificationclick', function(event) {
     const target = event.notification.data.click_action || '/';
     event.notification.close();

     // This looks to see if the current is already open and focuses if it is
     event.waitUntil(clients.matchAll({
         type: 'window',
         includeUncontrolled: true
     }).then(function(clientList) {
         // clientList always is empty?!
         for (var i = 0; i < clientList.length; i++) {
             var client = clientList[i];
             if (client.url === target && 'focus' in client) {
                 return client.focus();
             }
         }

         return clients.openWindow(target);
     }));
 });