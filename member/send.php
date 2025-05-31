<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: http://localhost/coin/sign_up.php");
    exit;
}

include "includes/db_connection.php";

function roundSmartWalletAmount($amount)
{
    if ($amount > 1000) {
        $rounded = ceil($amount / 10) * 10;
    } elseif ($amount > 100) {
        $rounded = ceil($amount / 5) * 5;
    } else {
        return 0.00;
    }
    return round($rounded - $amount, 2);
}

$coin_id = $_SESSION['coin_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "hello";
    $password = $_POST["password"];
    $mobile = $_SESSION["mobile"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE phone_num = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (hash('sha512', $password) == $user['password']) {
        $sender_coin_id = $user['coin_id'];
        $amount_sent = $_POST["amount_sent"];
        $transaction_date = date("Y-m-d H:i:s");
        $upi_number = "TRANSACTION AMOUNT";
        $remarks = "Sent to ";

        $receiver_coin_ids_raw = $_POST["receiver_coin_id"];
        $receiver_coin_ids_cleaned = str_replace(' ', '', $receiver_coin_ids_raw);
        $receiver_coin_ids = explode(",", $receiver_coin_ids_cleaned);
        $num_receivers = count($receiver_coin_ids);
        foreach ($receiver_coin_ids as $receiver_coin_id) {
            $stmt_check_receiver = $conn->prepare("SELECT coin_id FROM users WHERE coin_id = ?");
            $stmt_check_receiver->bind_param("s", $receiver_coin_id);
            $stmt_check_receiver->execute();
            $result_check_receiver = $stmt_check_receiver->get_result();
            if ($result_check_receiver->num_rows === 0) {
                $_SESSION["feedback"] = [
                    "type" => "error",
                    "message" => "Receiver coin ID $receiver_coin_id does not exist. Please check the user ID again."
                ];
                header("Location: send.php");
                exit;

                exit;
            }
        }

        $success = true;

        $stmt_last_block = $conn->prepare("SELECT id, total_hash FROM blocks ORDER BY id DESC LIMIT 1");
        $stmt_last_block->execute();
        $result_last_block = $stmt_last_block->get_result();
        $last_block = $result_last_block->fetch_assoc();

        if ($last_block) {
            $last_block_id = $last_block['id'];
            $prev_total_hash = $last_block['total_hash'];
        } else {
            $last_block_id = 0;
            $prev_total_hash = "";
        }
        $block_id = $last_block_id + 1;

        $stmt_total_amount = $conn->prepare("SELECT total_amount FROM added_money WHERE coin_id = ? ORDER BY id DESC LIMIT 1");
        $stmt_total_amount->bind_param("s", $sender_coin_id);
        $stmt_total_amount->execute();
        $result_total_amount = $stmt_total_amount->get_result();
        $sender_total_amount_row = $result_total_amount->fetch_assoc();
        $sender_total_amount = $sender_total_amount_row['total_amount'];

        if ($sender_total_amount >= $amount_sent) {
            $prev_trans_hash = "";

            foreach ($receiver_coin_ids as $receiver_coin_id) {

                $stmt_last_block = $conn->prepare("SELECT id, total_hash FROM blocks ORDER BY id DESC LIMIT 1");
                $stmt_last_block->execute();
                $result_last_block = $stmt_last_block->get_result();
                $last_block = $result_last_block->fetch_assoc();

                if ($last_block) {
                    $last_block_id = $last_block['id'];
                    $prev_total_hash = $last_block['total_hash'];
                } else {
                    $last_block_id = 0;
                    $prev_total_hash = "";
                }
                $block_id = $last_block_id + 1;

                $stmt = $conn->prepare("SELECT * FROM users WHERE coin_id = ?");
                $stmt->bind_param("s", $receiver_coin_id);
                $stmt->execute();
                $result = $stmt->get_result();

                $stmt_total_amount = $conn->prepare("SELECT total_amount FROM added_money WHERE coin_id = ? ORDER BY id DESC LIMIT 1");
                $stmt_total_amount->bind_param("s", $sender_coin_id);
                $stmt_total_amount->execute();
                $result_total_amount = $stmt_total_amount->get_result();
                $sender_total_amount_row = $result_total_amount->fetch_assoc();
                $sender_total_amount = $sender_total_amount_row['total_amount'];

                if ($result->num_rows > 0) {
                    $receiver_row = $result->fetch_assoc();
                    $receiver_coin_id_db = $receiver_row["coin_id"];
                    $transaction_id = "TRANS" . uniqid();

                    $stmt_transaction = $conn->prepare("INSERT INTO transactions (block_id, transaction_ID, sender_coin_id, reciever_coin_id, amount, timestamp, status) VALUES (?, ?, ?, ?, ?, ?, 1)");
                    $stmt_transaction->bind_param("ssssss", $block_id, $transaction_id, $sender_coin_id, $receiver_coin_id, $amount_sent, $transaction_date);
                    $stmt_transaction->execute();

                    $new_sender_total_amount = $sender_total_amount - $amount_sent;

                    $stmt_sender_query = "INSERT INTO added_money (transaction_id, coin_id, upi_number, amount_added, total_amount, remarks, timestamp, status) VALUES ('$transaction_id', '$sender_coin_id', '$upi_number', '-$amount_sent', '$new_sender_total_amount', '$remarks $receiver_coin_id', '$transaction_date', 1)";

                    $success &= $conn->query($stmt_sender_query);


                    $stmt_receiver_total_amount = $conn->prepare("SELECT total_amount FROM added_money WHERE coin_id = ? ORDER BY id DESC LIMIT 1");
                    $stmt_receiver_total_amount->bind_param("s", $receiver_coin_id);
                    $stmt_receiver_total_amount->execute();
                    $result_receiver_total_amount = $stmt_receiver_total_amount->get_result();
                    $receiver_total_amount_row = $result_receiver_total_amount->fetch_assoc();
                    $receiver_total_amount = $receiver_total_amount_row['total_amount'];

                    $stmt_receiver_query = "INSERT INTO added_money (transaction_id, coin_id, upi_number, amount_added, total_amount, remarks, timestamp, status) VALUES ('$transaction_id', '$receiver_coin_id', '$upi_number', '$amount_sent', $receiver_total_amount + $amount_sent, 'Received from $sender_coin_id', '$transaction_date', 1)";
                    $success &= $conn->query($stmt_receiver_query);

                    $sender_receiver_query = "INSERT INTO friends (`$sender_coin_id`) VALUES ('$receiver_coin_id')";
                    $receiver_sender_query = "INSERT INTO friends (`$receiver_coin_id`) VALUES ('$sender_coin_id')";

                    $conn->query($sender_receiver_query);
                    $conn->query($receiver_sender_query);

                    $transaction_data = $block_id . $transaction_id . $sender_coin_id . $receiver_coin_id . $amount_sent . $transaction_date . "1";
                    $trans_hash = hash('sha256', $transaction_data);

                    $prev_trans_hash = $trans_hash;

                    $stmt_update_trans_hash = $conn->prepare("UPDATE transactions SET trans_hash = ? WHERE transaction_ID = ?");
                    $stmt_update_trans_hash->bind_param("ss", $trans_hash, $transaction_id);
                    $stmt_update_trans_hash->execute();
                } else {
                    $success = false;

                    $_SESSION["feedback"] = [
                        "type" => "error",
                        "message" => "Receiver with coin ID $receiver_coin_id does not exist."
                    ];
                    header("Location: send.php");
                    exit;


                }
            }

            $total_data = $block_id . $last_block_id . $prev_total_hash . $prev_trans_hash . $transaction_date;
            $total_hash = hash('sha256', $total_data);

            $stmt_insert_block = $conn->prepare("INSERT INTO blocks (previous_block_id, prev_total_hash, timestamp, trans_hash, total_hash) VALUES (?, ?, ?, ?, ?)");
            $stmt_insert_block->bind_param("issss", $last_block_id, $prev_total_hash, $transaction_date, $prev_trans_hash, $total_hash);
            $stmt_insert_block->execute();
            $stmt_insert_block->close();

            if ($success) {
                $_SESSION["transaction_success"] = true;
                $_SESSION["transaction_id"] = $transaction_id;
                $mobile = $_SESSION["mobile"];
                $stmt = $conn->prepare("SELECT smartwalletactive FROM users WHERE phone_num = ?");
                $stmt->bind_param("s", $mobile);
                $stmt->execute();
                $result = $stmt->get_result();
                $user_data = $result->fetch_assoc();
                $stmt->close();
                echo $user_data['smartwalletactive'];
                if ($user_data['smartwalletactive'] == 1) {
                    $amount_sent = $num_receivers * $amount_sent;
                    $smart_amount = roundSmartWalletAmount($amount_sent);

                    if ($smart_amount > 0) {
                        $sendto = implode(',', $receiver_coin_ids);

                        $stmt_check_smart = $conn->prepare("SELECT total_smart_amount FROM smartwallet WHERE coni_id = ? ORDER BY id DESC LIMIT 1");
                        $stmt_check_smart->bind_param("s", $sender_coin_id);
                        echo "$sender_coin_id";
                        $stmt_check_smart->execute();
                        $result_check_smart = $stmt_check_smart->get_result();

                        if ($result_check_smart->num_rows > 0) {
                            $row = $result_check_smart->fetch_assoc();
                            $existing_total = $row['total_smart_amount'];
                            $new_total = $existing_total + $smart_amount;
                            $stmt_smart = $conn->prepare("INSERT INTO smartwallet (coni_id, total_smart_amount, added_smart_amount, sendto) VALUES (?, ?, ?, ?)");
                            $stmt_smart->bind_param("sdds", $sender_coin_id, $new_total, $smart_amount, $sendto);
                            $stmt_smart->execute();

                            $_SESSION["feedback"] = [
                                "type" => "success",
                                "message" => "Payment SuccessFull<br> $smart_amount rs: Super Money added to your SmartWallet successfully<br>If have any queries,Please raise a ticket using your Transaction ID: $transaction_id"
                            ];
                            header("Location: send.php");
                            exit;


                        } else {
                            $stmt_smart = $conn->prepare("INSERT INTO smartwallet (coni_id, total_smart_amount, added_smart_amount, sendto) VALUES (?, ?, ?, ?)");
                            $stmt_smart->bind_param("sdds", $sender_coin_id, $smart_amount, $smart_amount, $sendto);
                            $stmt_smart->execute();

                            $_SESSION["feedback"] = [
                                "type" => "success",
                                "message" => "Payment SuccessFull<br> $smart_amount rs: Super Money added to your SmartWallet successfully<br>If have any queries,Please raise a ticket using your Transaction ID: $transaction_id"
                            ];
                            header("Location: send.php");
                            exit;



                        }
                    }
                }
                $_SESSION["feedback"] = [
                    "type" => "success",
                    "message" => "Transaction completed successfully.<br>If have any queries,Please raise a ticket using your Transaction ID: $transaction_id"
                ];
                header("Location: send.php");
                exit;


            } else {
                $_SESSION["feedback"] = [
                    "type" => "error",
                    "message" => "One or more Transactions failed. Please try again."
                ];
                header("Location: send.php");
                exit;


            }
        } else {
            $_SESSION["feedback"] = [
                "type" => "error",
                "message" => "Transaction failed.Insufficient balance to perform transaction Please try again."
            ];
            header("Location: send.php");
            exit;


        }
    } else {
        $password_err = "Incorrect password";
        $_SESSION["feedback"] = [
            "type" => "error",
            "message" => "Incorrect password. Transaction failed. Please try again."
        ];
        header("Location: send.php");
        exit;

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>

<body>

    <?php include 'includes/navbar.php'; ?>

    <div id="sidebar">
        <?php include 'includes/sidebar.php' ?>
    </div>

    <div class="main-content" id="mainContent">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fa fa-money-bill-alt me-2"></i> Send Money
                        </h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Transfer Details</h5>
                        </div>
                        <div class="card-body">
                            <?php if (isset($user_data) && isset($user_data['smartwalletactive'])): ?>
                                <?php if ($user_data['smartwalletactive'] == 1): ?>
                                    <div class="alert alert-success" role="alert">
                                        Smart Wallet is <strong>Active</strong>.
                                        To <strong>disable</strong> Smart Wallet, go to your <a href="profile.php"
                                            class="text-decoration-none text-primary">Profile</a>.
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning" role="alert">
                                        Smart Wallet is <strong>Inactive</strong>. To <strong>enable</strong> it, please go to
                                        your <a href="profile.php" class="text-decoration-none text-primary">Profile</a>.
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <form id="sendForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                method="post" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="receiver_coin_id" class="form-label">Receiver's Coin IDs <small
                                            class="text-muted">(separate with commas)</small></label>
                                    <input type="text" class="form-control" id="receiver_coin_id"
                                        name="receiver_coin_id" placeholder="Enter Coin IDs" required>
                                    <div class="invalid-feedback">Please enter at least one Coin ID.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="amount_sent" class="form-label">Amount to Send</label>
                                    <input type="number" class="form-control" id="amount_sent" name="amount_sent"
                                        placeholder="Enter Amount" required>
                                    <div class="invalid-feedback">Enter the amount you wish to send.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Your Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="*****" required>
                                    <div class="invalid-feedback">Password is required to authorize the transaction.
                                    </div>
                                    <?php if (isset($password_err)): ?>
                                        <div class="text-danger mt-1"><?php echo $password_err; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-1"></i> Send Money
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'modelcode.php'; ?>
<?php include 'toggle.php'; ?>
<?php include 'validate.php'; ?>
</body>

</html>