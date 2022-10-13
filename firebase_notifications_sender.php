<?php

class firebase_processor
{
    /**
     * Send notifications to all tokens from a storage
     */
    public function process_notifications()
    {
        // TODO Get tokens from your storage to send them notifications
        $records = [];
        $server_key = '';  // TODO Server key from FCN

        $limit = 500;  // https://firebase.google.com/docs/cloud-messaging/send-message
        $counter = 0;

        $registrationTokens = [$limit];
        foreach ($records as $record) {
            $registrationTokens[$counter] = $record["TOKEN"];
            $counter = $counter + 1;
            if ($counter == $limit) {
                self::send_notification($registrationTokens, $server_key);
                $counter = 0;
                $registrationTokens = [$limit];
            }
        }
    }

    /** Send notification
     * @param array $registrationTokens Array of subscribed user tokens
     * @param string $server_key Server key from FCM
     */
    private function send_notification($registrationTokens, $server_key)
    {
        $header = [
            'Content-Type: application/json',
            'Authorization: key=' . $server_key,
        ];

        $data = [
            "data" => [
                "title" => "Test",
                "body" => "small test",
                "click_action" => "https://kulikov-dev.github.io/firebase-push/",
                "icon" => "https://kulikov-dev.github.io/firebase-push/notification_logo.jpg"
            ],
            "to" => "\"" . implode("\",\"", $registrationTokens) . "\""
        ];

        $json_query = json_encode($data);
        self::send_request('https://fcm.googleapis.com/fcm/send', $header, $json_query);
    }

    /** Send request to the website
     * @param string $url . Url
     * @param array $header_params . Header params
     * @param string $post_fields . Request data
     * @return mixed|string. Request result
     */
    private function send_request($url, $header_params, $post_fields = '')
    {
        $command = curl_init();
        try {
            curl_setopt($command, CURLOPT_URL, $url);
            curl_setopt($command, CURLOPT_HTTPHEADER, $header_params);
            curl_setopt($command, CURLOPT_SSL_VERIFYPEER, false);
            if (isset($post_fields) && $post_fields != '') {
                curl_setopt($command, CURLOPT_POSTFIELDS, $post_fields);
            }

            curl_setopt($command, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($command);
            curl_close($command);
            return $result;
        } catch (Exception $exception) {
            curl_close($command);
            print($exception->getMessage());
            return '';
        }
    }
}

