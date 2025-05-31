<?php
function isTransactionValid($conn, $transactionId) {
    $stmt = $conn->prepare("SELECT * FROM transactions WHERE transaction_ID = ?");
    $stmt->bind_param("s", $transactionId);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaction = $result->fetch_assoc();

    if (!$transaction) {
        return false;
    }

    $storedHash = $transaction['trans_hash'];

    $calculatedData = $transaction['block_id'] . $transaction['transaction_ID'] . $transaction['sender_coin_id'] . $transaction['reciever_coin_id'] . $transaction['amount'] . $transaction['timestamp'] . $transaction['status'];
    $calculatedHash = hash('sha256', $calculatedData);

    return $calculatedHash === $storedHash;
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "wallet";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT transaction_ID FROM transactions");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $transactionId = $row['transaction_ID'];
    if (isTransactionValid($conn, $transactionId)) {
        echo "Transaction $transactionId is valid.<br>";
    } else {
        echo "Transaction $transactionId has been tampered with.<br>";
    }
}

$conn->close();
?>
