<?php
session_start();
if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    
    header("location: http://localhost/coin/index.php");
    exit;
}

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: http://localhost/coin/sign_up.php");
    exit;
}
include "includes/db_connection.php";


if ($_SESSION["loggedin"] === true) {
    $mobile = $_SESSION["mobile"];
    $stmt = $conn->prepare("SELECT full_name, email, phone_num, coin_id, smartwalletactive FROM users WHERE phone_num = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST["new_password"];
    $new_email = $_POST['new_email'];
    $new_full_name = $_POST['new_name'];
    $hashed_new_password = hash("sha512", $new_password);
$new_smartwalletactive = isset($_POST['smartwalletactive']) ? 1 : 0;

    $update_query = "UPDATE `users` SET ";
if (!empty($new_full_name)) {
    $update_query .= "`full_name` = '$new_full_name', ";
}
if (!empty($new_email)) {
    $update_query .= "`email` = '$new_email', ";
}
if (!empty($new_password)) {
    $update_query .= "`password` = '$hashed_new_password', ";
}
$update_query .= "`smartwalletactive` = '$new_smartwalletactive' ";

    $update_query = rtrim($update_query, ", ");
    $update_query .= " WHERE `phone_num` = '$mobile'";
    if ($conn->query($update_query) === TRUE) {
        echo "<script>alert('Profile updated successfully.');</script>";
        $_SESSION["feedback"] = [
                    "type" => "success",
                    "message" => "Profile Updated Successfully."
                ];
                header("Location: profile.php");
                exit;
    } else {
        $_SESSION["feedback"] = [
                    "type" => "error",
                    "message" => "Error In Updating Profile. Please Try Again."
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
                            <i class="fas fa-user me-2"></i> My Profile
                        </h4>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Profile Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="new_name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" name="new_name"
                                            value="<?php echo $user_data['full_name']; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="new_email" class="form-label">Change Email</label>
                                        <input type="email" class="form-control" name="new_email"
                                            value="<?php echo $user_data['email']; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Contact</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo $user_data['phone_num']; ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Your COIN ID</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo $user_data['coin_id']; ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="new_password" class="form-label">Change Password</label>
                                        <input type="password" class="form-control" name="new_password"
                                            placeholder="*****" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="smartwalletactive"
                                        name="smartwalletactive" value="1"
                                        <?php if ($user_data['smartwalletactive'] == 1) echo 'checked'; ?>>
                                    <label class="form-check-label" for="smartwalletactive">Activate Smart
                                        Wallet</label>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div>
                                        <button type="submit" class="btn btn-primary me-2">Update</button>
                                        <button type="button" class="btn btn-secondary"
                                            onclick="window.history.back();">Cancel</button>
                                    </div>
                                    <a href="?logout=true" class="btn btn-danger">Logout</a>
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
</body>

</html>