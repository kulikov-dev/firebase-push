<?php

$contents = file_get_contents("php://input");
if (empty($contents)) {
    echo 'Empty contents';
    exit;
}

try {
    $webhook_details = json_decode($contents);
    $token = $webhook_details->token;

    $query_params["TOKEN"] = $token;

    $current_date = date("m-d-Y H:i:s", time());
    $query_params["TIMESTAMP"] = $current_date;

    // TODO SAVE TO STORAGE

} catch (Exception $exception) {
    $error_message = $exception->getMessage();
    echo $error_message;
    die($error_message);
}

exit;
