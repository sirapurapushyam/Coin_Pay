<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: http://localhost/coin/sign_up.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "wallet";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SESSION["loggedin"] === true) {
    $mobile = $_SESSION["mobile"];
    $stmt = $conn->prepare("SELECT full_name, email, phone_num, coin_id FROM users WHERE phone_num = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $mobile = $_SESSION["mobile"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE phone_num = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (hash('sha512', $password) !== $user['password']) {
        $_SESSION["feedback"] = [
            "type" => "error",
            "message" => "Incorrect password.<br>Transaction failed. Please try again"
        ];
        header("Location: add.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT total_amount FROM added_money WHERE coin_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $user_data['coin_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $latest_record = $result->fetch_assoc();

    if ($latest_record) {
        $total_amount = intval($latest_record['total_amount']) + intval($_POST["deposit_amount"]);
    } else {
        $total_amount = $_POST["deposit_amount"];
    }

    $coin_id = $user_data['coin_id'];
    $payment_method = $_POST["upi"];
    $amount_added = $_POST["deposit_amount"];
    $remarks = isset($_POST["remarks"]) ? $_POST["remarks"] : "Added Money By You";
    $transaction_date = date("Y-m-d H:i:s");
    $transaction_id = "TRANSCOIN" . uniqid();

    $sql = "INSERT INTO added_money (transaction_id, coin_id, upi_number, amount_added, total_amount, remarks, timestamp,status) VALUES (?, ?, ?, ?, ?, ?, ?,1)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssss", $transaction_id, $coin_id, $payment_method, $amount_added, $total_amount, $remarks, $transaction_date);

        if ($stmt->execute()) {
            $_SESSION["transaction_id"] = $transaction_id;
            $_SESSION["feedback"] = [
                "type" => "success",
                "message" => "Transaction completed successfully.<br>Amount added: $amount_added.<br>If have any queries,Please raise a ticket using your Transaction ID: $transaction_id"
            ];
            header("Location: add.php");
            exit;


        } else {
            $_SESSION["feedback"] = [
                "type" => "error",
                "message" => "Transaction failed. Please try again."
            ];
            header("Location: add.php");
            exit;

        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>

<>
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
                            <i class="fa fa-file me-2"></i> Deposit Form
                        </h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Deposit Information</h5>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation"
                                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
                                <div class="mb-3">
                                    <label for="coin_id" class="form-label">Your Coin ID</label>
                                    <input type="text" class="form-control" id="coin_id" name="coin_id"
                                        value="<?php echo $user_data['coin_id']; ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="upi" class="form-label">UPI Number</label>
                                    <input type="text" class="form-control" id="upi" name="upi"
                                        placeholder="Enter UPI Number" required>
                                    <div class="invalid-feedback">Please enter your UPI number.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="deposit_amount" class="form-label">Deposit Amount</label>
                                    <input type="number" class="form-control" id="deposit_amount" name="deposit_amount"
                                        placeholder="Enter Deposit Amount" required>
                                    <div class="invalid-feedback">Please enter a deposit amount.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Enter Password to Confirm</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="*****" required>
                                    <div class="invalid-feedback">Password is required to authorize the transaction.
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <input type="text" class="form-control" id="remarks" name="remarks"
                                        placeholder="Enter Remarks" required>
                                    <div class="invalid-feedback">Please enter remarks.</div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-wallet me-1"></i> Add to Wallet
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="window.history.back();">
                                        Cancel
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