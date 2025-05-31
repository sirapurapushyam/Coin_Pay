<?php
session_start();

include "includes/db_connection.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    exit("Unauthorized access");
}

if (!isset($_POST['coinId']) || !isset($_POST['message'])) {
    exit("Invalid request");
}

$coinId = $_POST['coinId'];
$message = $_POST['message'];

$stmt = $conn->prepare("INSERT INTO coin_chat (sender_coin, reciver_coin, message, timestamp) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sss", $_SESSION['coin_id'], $coinId, $message);
if ($stmt->execute()) {
    echo "Message sent successfully";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
