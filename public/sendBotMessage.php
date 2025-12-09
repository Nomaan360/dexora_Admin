<?php
// Replace with your bot token
$BOT_TOKEN = '8253996558:AAFdEyoPgVehXCPFDzwB4SJ0FSRcRMvVzFY';
$TELEGRAM_API_URL = "https://api.telegram.org/bot$BOT_TOKEN";

// Read the incoming request body
$update = json_decode(file_get_contents('php://input'), TRUE);

// Check if the message contains the '/start' command
if (isset($update['message']) && $update['message']['text'] === '/start') {
    $chatId = $update['message']['chat']['id'];

    // Send a welcome message back to the user
    $message = "🎉 Welcome to Tapora!
    Tap your way into the Dexora universe, collect $AURA Coins, and build your strategy to maximize rewards ⚡
🚀 Stay tuned for our token airdrop – official dates will be revealed soon.
    Join now and unleash your true power with Tapora! 💰";

    // Inline keyboard with buttons
    $replyMarkup = [
        'inline_keyboard' => [
            [
                ['text' => 'Tap to Play 🎮', 'url' => 'https://t.me/tapoora_bot/tapora?start'], // Replace with actual play URL
                ['text' => 'Follow our Channel', 'url' => 'https://t.me/DexoraFinanceAnn'], // Replace with your Telegram channel URL
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
        $earnMessage = "🎮 How to Play TAP AURA ?
        📖 Full Guide 💰 Tap to Earn-Tap the screen to collect $AURA Coins and boost your earnings.
        ⛏️ Boost Your Earnings -
           Upgrade Bitron, Shardius, and Dexiron to increase passive income opportunities.
        ⏰ Profit per Hour -
            Your coins grow even while you’re offline (up to 3 hours). Come back regularly to keep your profits flowing!
        📈 Level Up -
            The more $AURA Coins you gather, the higher your level. Unlock rare cards, power combos, and new features.
        👥 Invite Friends -
            Bring your friends into TAP AURA and earn bonuses when they play. Teamwork = bigger rewards!
        🏆 Seasonal Rewards -
            At the end of each season, players receive exclusive rewards. Stay updated through the official Dexora channels for announcements!";
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
        'photo' => "https://admin-tapaura.dexora.finance/storage/dexora_home.webp",
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
