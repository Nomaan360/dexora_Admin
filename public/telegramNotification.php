<?php

// Set the header to return JSON response
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');

// Initialize an array to collect debug messages
$debug_log = [];

// Check if the POST request contains the required parameters
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the posted data (JSON format)
    $data = file_get_contents("php://input");

    // Log the raw input data
    $debug_log[] = "Raw Input Data: " . $data;

    // Decode the JSON data
    $json = json_decode($data, true);

    // Check for JSON decoding errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        $debug_log[] = "JSON Decode Error: " . json_last_error_msg();
    }

    // Extract the required parameters
    $username = isset($json['username']) ? $json['username'] : 'Unknown';
    $datetime = isset($json['datetime']) ? $json['datetime'] : 'Unknown';
    $ip_address = isset($json['ip_address']) ? $json['ip_address'] : 'Unknown';
    $attempt_type = isset($json['attempt_type']) ? $json['attempt_type'] : '';

    // Build the error message
    $error = "360 Core Server (62.72.31.31)\n\n";
    $error .= "Username: " . $username . "\n";
    $error .= "Server Date-Time: " . $datetime . "\n";
    $error .= "Our Time: " . date('Y-m-d H:i:s') . "\n";
    $error .= "IP Address: " . $ip_address . "\n";

    if(!empty($attempt_type))
    {
        $error .= "Failed attempt on database";
    }
    // $error .= "Payload Received: " . json_encode($json) . "\n";
    // $error .= "Debug Log:\n" . implode("\n", $debug_log);

    // Send the error message to Telegram
    $telegram_data = [
        "chat_id" => "-1002465836927",
        "text" => $error,
        "disable_web_page_preview" => false,
        "disable_notification" => false
    ];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.telegram.org/bot7166602360:AAE02eLdWcAUUkPmdukfNepIgKQ9hHlOyjg/sendMessage",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($telegram_data),
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "content-type: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    // Optionally, log the response and errors
    file_put_contents("php_error.log", "Response: $response\nError: $err\n", FILE_APPEND);

} else {
    // Handle non-POST requests if necessary
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

?>
