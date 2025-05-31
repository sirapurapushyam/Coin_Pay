
<?php
session_start();

include 'includes/db_connection.php'; 

$alert_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $transaction_id = $_POST["transaction_id"];
    $ticket_query = $_POST["ticket_query"];

    if (isset($_SESSION["coin_id"])) {
        $sender_coin_id = $_SESSION["coin_id"];

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM transactions WHERE transaction_ID = ? AND sender_coin_id = ?");
            $stmt->bind_param("ss", $transaction_id, $sender_coin_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $qq = "INSERT INTO queries (coin_id,transaction_ID,ticket_query) VALUES (?, ?, ?)";

            if ($stmt = $conn->prepare($qq)) {
                $stmt->bind_param("sss",$sender_coin_id,$transaction_id,$ticket_query);
        
                if ($stmt->execute()) {
                    $_SESSION["feedback"] = [
                    "type" => "success",
                    "message" => "Query raised successfully!"
                ];
                header("Location: ticket.php");
                exit;

                } else {
                    header("location: ");
                    exit();
                }
                $stmt->close();
            }

            
        } else {
            $alert_message = '<div class="alert alert-danger" role="alert">Database connection error</div>';
        }
    } else {
        $alert_message = '<div class="alert alert-danger" role="alert">Coin ID not set in session</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>

<style>
    .form-group {
        margin-bottom: 1rem;
    }
</style>

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
                            <i class="fas fa-money-bill-alt me-2"></i> Raise A Ticket (Only For Sending Transactions)
                        </h4>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-10 col-sm-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Enter Your Transaction ID</h5>
                        </div>
                        <div class="card-body">
                            <?php echo $alert_message; ?>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="needs-validation" novalidate>
                                <div class="form-group">
                                    <label for="transaction_id" class="form-label">Transaction ID</label>
                                    <input type="text" class="form-control" id="transaction_id" name="transaction_id" placeholder="Enter Transaction ID" required>
                                    <div class="invalid-feedback">Please enter a valid transaction ID.</div>
                                </div>
                                <div class="form-group">
                                    <label for="ticket_query" class="form-label">Your Query</label>
                                    <textarea class="form-control" id="ticket_query" name="ticket_query" placeholder="Enter your query" rows="4" required></textarea>
                                    <div class="invalid-feedback">Please enter your query.</div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" name="submit">
                                        Raise Query
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
