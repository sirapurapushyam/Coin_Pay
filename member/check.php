<!-- member/check.php -->
<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: http://localhost/coin/sign_up.php");
    exit;
}

include "includes/db_connection.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_password = $_POST["password"];
    $mobile = $_SESSION["mobile"];
    $stmt = $conn->prepare("SELECT password FROM users WHERE phone_num = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $hashed_password = $user_data["password"];

    if (hash("sha512", $input_password) === $hashed_password) {
        $coin_id = $_SESSION['coin_id'];

        if (!empty($coin_id)) {
            $stmt = $conn->prepare("SELECT total_amount FROM added_money WHERE coin_id = ? ORDER BY id DESC LIMIT 1");
            $stmt->bind_param("s", $coin_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $balance_data = $result->fetch_assoc();
        }
    } else {
    $_SESSION["feedback"] = [
                "type" => "error",
                "message" => "Incorrect password. Please try again."
            ];
            header("Location: check .php");
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
                            <i class="fa fa-money-bill-alt me-2"></i> Check Balance
                        </h4>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Enter Your Password</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div class="invalid-feedback">Password is required.</div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-unlock me-1"></i> Submit
                                    </button>
                                </div>
                            </form>

                            <?php if (isset($error_message)): ?>
                                <div class="alert alert-danger mt-4" role="alert">
                                    <?php echo $error_message; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($coin_id)): ?>
                                <div class="alert alert-success mt-4" role="alert">
                                    <h5 class="alert-heading">Your Balance</h5>
                                    <p>
                                        <strong>Balance:</strong>
                                        <?php echo isset($balance_data['total_amount']) ? $balance_data['total_amount'] . " INR" : "N/A"; ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <?php include 'toggle.php'; ?>
    <?php include 'modelcode.php'; ?>
    <?php include 'validate.php'; ?>
</body>

</html>