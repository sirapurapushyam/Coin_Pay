<?php
session_start();

if (!isset($_POST['coinId'])) {
    exit("Invalid request");
}

include "includes/db_connection.php";

$coinId = $_POST['coinId'];

$stmt = $conn->prepare("SELECT sender_coin, reciver_coin, message, timestamp FROM coin_chat WHERE (sender_coin = ? AND reciver_coin = ?) OR (sender_coin = ? AND reciver_coin = ?) ORDER BY timestamp");
$stmt->bind_param("ssss", $_SESSION['coin_id'], $coinId, $coinId, $_SESSION['coin_id']);
if (!$stmt->execute()) {
    die("Execution failed: " . $stmt->error);
}

$result = $stmt->get_result();
if (!$result) {
    die("Failed to get result: " . $conn->error);
}

while ($row = $result->fetch_assoc()) {
    $sender = $row['sender_coin'];
    $receiver = $row['reciver_coin'];
    $message = $row['message'];
    $timestamp = $row['timestamp'];

    $messageClass = ($sender == $_SESSION['coin_id']) ? 'user-inbox' : 'bot-inbox';

    echo '<div class="' . $messageClass . ' inbox">
            <div class="icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="msg-header">
                <p>' . $message . '</p>
                <span class="time-right">' . $timestamp . '</span>
            </div>
          </div>';
}

$stmt->close();
$conn->close();
?>
