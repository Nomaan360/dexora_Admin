<?php

// Telegram Bot Token
$botToken = '8253996558:AAFdEyoPgVehXCPFDzwB4SJ0FSRcRMvVzFY'; // Replace with your bot token
$apiUrl = "https://api.telegram.org/bot$botToken/getChatMember";

// Channel or Group ID (e.g., @channelusername or -1001234567890)
$chatId = "@dexorainc"; // Use @ for public channels or -100... for private channels

// User ID to check
$userId = "7152144610"; // Replace with the user ID you want to check

// API URL with parameters
$url = "$apiUrl?chat_id=$chatId&user_id=$userId";

// Send a GET request to Telegram API
$response = file_get_contents($url);

// Decode the JSON response
$responseData = json_decode($response, true);

echo "<pre>";
print_r($responseData);

if (!$responseData['ok']) {
    echo "Error: ";
    print_r($responseData);
    exit;
}

$status = $responseData['result']['status'];

if ($status == "left" || $status == "kicked") {
    echo "User is not a member of the channel or group.";
} else {
    echo "User is a member of the channel or group. Status: $status";
}

?>
