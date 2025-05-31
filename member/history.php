<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: http://localhost/coin/sign_up.php");
    exit;
}

include "includes/db_connection.php";

$mobile = $_SESSION["mobile"];

$stmt = $conn->prepare("SELECT coin_id FROM users WHERE phone_num = ?");
$stmt->bind_param("s", $mobile);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$coin_id = $user['coin_id'];

$stmt2 = $conn->prepare("SELECT * FROM added_money WHERE coin_id = ? ORDER BY timestamp DESC");
$stmt2->bind_param("i", $coin_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

$transactions = [];

while ($row = $result2->fetch_assoc()) {
    $transactions[] = $row;
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
                            <i class="fas fa-credit-card me-2"></i> Deposit Transactions
                        </h4>
                        <div>
                            <button class="btn btn-sm btn-outline-secondary me-2">
                                <i class="fas fa-download me-1"></i> Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">List of Deposit Transactions</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-bordered mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Transaction ID</th>
                                            <th>Coin ID</th>
                                            <th>UPI Number</th>
                                            <th>Amount Added</th>
                                            <th>Remarks</th>
                                            <th>Timestamp</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sno = 1;
                                        foreach ($transactions as $transaction) {
                                            $status = $transaction['status'] == 0 ? 'Failed' : ($transaction['status'] == 1 ? 'Success' : 'Pending');
                                            $statusClass = $transaction['status'] == 0 ? 'bg-danger' : ($transaction['status'] == 1 ? 'bg-success' : 'bg-warning');
                                            echo "<tr>";
                                            echo "<td>" . $sno . "</td>";
                                            echo "<td>" . $transaction['transaction_id'] . "</td>";
                                            echo "<td>" . $transaction['coin_id'] . "</td>";
                                            echo "<td>" . $transaction['upi_number'] . "</td>";
                                            echo "<td class='" . ($transaction['amount_added'] > 0 ? 'text-success' : 'text-danger') . "'>" . ($transaction['amount_added'] > 0 ? '+' : '') . $transaction['amount_added'] . "</td>";
                                            echo "<td>" . $transaction['remarks'] . "</td>";
                                            echo "<td>" . date('d M Y, h:i A', strtotime($transaction['timestamp'])) . "</td>";
                                            echo "<td><span class='badge " . $statusClass . "'>" . $status . "</span></td>";
                                            echo "</tr>";
                                            $sno++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'toggle.php'; ?>
</body>
</html>
