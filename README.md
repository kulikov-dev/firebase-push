Test Firebase Cloud Messaging
-----------------------------

Small scripts for working with Firebase Cloud Messaging (FCM) web push notifications. Based on [quickstart-js](https://github.com/firebase/quickstart-js)

* Clean scripts without excess code. Ready to use;
* Added opportunity to work and test on [github pages](https://kulikov-dev.github.io/firebase-push/);
* Added possibility to process click on a notification: open or focus a linked page.

There are four scripts here:
* firebase_client.js - which used on a client side for subscription for notifications;
* firebase-messaging-sw.js - is the ServiceWorker;
* firebase_webhook.php - which process users token on a server side and save it to storage for future usage;
* firebase_notifications_sender.php - sample script for sending notifications.

The best way to test client side is use Postman with sending POST messages with:
* This auth info: Authorization - Key=your-server-key
* To this address: https://fcm.googleapis.com/fcm/send 
* With this data (you can send up to 500 user tokens in one message):
```json
{
    "data": {
    "title": "Title",
    "body": "Notification message",
    "icon": "https://kulikov-dev.github.io/firebase-push/notification_logo.jpg",
    "click_action": "https://kulikov-dev.github.io/firebase-push/"
  },
  "to": "user-token-id" 
}
```
* To get 'Server key' you need to enable 'Cloud Messaging API (Legacy)'.

