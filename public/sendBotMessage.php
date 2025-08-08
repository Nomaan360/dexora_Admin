<?php
// Replace with your bot token
$BOT_TOKEN = '7991662609:AAHbPYzh8s-6Zcqui3-m-eQsQ6CwcnvatbA';
$TELEGRAM_API_URL = "https://api.telegram.org/bot$BOT_TOKEN";

// Read the incoming request body
$update = json_decode(file_get_contents('php://input'), TRUE);

// Check if the message contains the '/start' command
if (isset($update['message']) && $update['message']['text'] === '/start') {
    $chatId = $update['message']['chat']['id'];

    // Send a welcome message back to the user
    $message = "🌾 Welcome to AgriXon B.O.T!Tap the soil 👆, harvest SFA Tokens 💰, and power up your eco-farming empire 🌱!
🚜 Build your land, upgrade biomech allies 🤖, and unlock nature-tech synergies 🔋🌿.
💸 Boost your passive yield while defending the future of farming 🌍.
🌱 Custom strategies. Epic guardians 🛡️. Real token rewards 🎯.
🎁 Airdrop Alert - Details dropping soon 📢.
Now's your time to tap, grow, and earn with AgriXon B.O.T! 🌍";

    // Inline keyboard with buttons
    $replyMarkup = [
        'inline_keyboard' => [
            [
                ['text' => 'Tap to Play 🎮', 'url' => 'http://t.me/agrixon_bot/Agrixon?start'], // Replace with actual play URL
                // ['text' => 'Follow our Channel', 'url' => 'https://t.me/nineinc'], // Replace with your Telegram channel URL
            ],
            [
                ['text' => 'How to Earn?', 'callback_data' => 'how_to_earn'] // Replace with your "How to Earn?" URL
            ]
        ]
    ];

    sendMessage($chatId, $message, $replyMarkup);
}

if (isset($update['callback_query'])) {
    $callbackQuery = $update['callback_query'];
    $chatId = $callbackQuery['message']['chat']['id'];
    $callbackData = $callbackQuery['data']; // This will contain the value set in 'callback_data'

    if ($callbackData === 'how_to_earn') {
        // Send message when "How to Earn?" button is clicked
        $earnMessage = "🌿 How to Play AgriXon B.O.T Game 👣Full Guide to Growing & Earning
💰 Tap to Earn - Tap the screen to gather Seeds 🌱 and grow your farming power 🌾!
⛏️ Boost Your Harvest - Upgrade your characters 👨‍🌾 and enhance their abilities ⚡ to multiply your passive seed income 🌻.
⏰ Profit per Hour - Your land works while you rest 😴! Earn Seeds even when offline (up to 3 hours) 🌙. Check back often to keep the yield flowing 🚿.
📈 Level Up - The more Seeds you collect, the higher your level 🆙. Leveling up unlocks powerful boosts 💪 and exciting new features 🧩.
👥 Invite Friends - Invite your friends 👩‍🌾👨‍🌾 to the SFAGRO world and earn bonus Seeds 🎉. Help them grow, and you both reap the rewards 🎊!
🏆 Seasonal Rewards - At the end of each season 📆, top farmers receive exclusive prizes 🎁! Stay tuned on our channel 📲 for airdrop and event announcements 📢.
🌱 Unleash your inner cultivator with AgriXon B.O.T! 🎮";
        sendMessageCallback($chatId, $earnMessage);
    }
}

// Function to send a message back to the user
function sendMessage($chatId, $message, $replyMarkup) {
    global $TELEGRAM_API_URL;

    $url = $TELEGRAM_API_URL . "/sendPhoto";

    // Data to send in the request
    $data = [
        'chat_id' => $chatId,
        'photo' => "https://admin.sfagro.club/storage/sf-splashscreen.webp",
        'caption' => $message,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode($replyMarkup, true),
    ];

    // Initialize cURL session to send the request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (not recommended for production)

    // Execute the cURL request
    $response = curl_exec($ch);
    curl_close($ch);
}

// Function to send a message back to the user
function sendMessageCallback($chatId, $message) {
    global $TELEGRAM_API_URL;

    $url = $TELEGRAM_API_URL . "/sendMessage";

    // Data to send in the request
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'HTML',
    ];

    // Initialize cURL session to send the request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (not recommended for production)

    // Execute the cURL request
    $response = curl_exec($ch);
    curl_close($ch);
}

?>
