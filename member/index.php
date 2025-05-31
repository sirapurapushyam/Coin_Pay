<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: http://localhost/coin/sign_up.php");
    exit;
}
if (isset($_SESSION['wallet_verified'])) {
    unset($_SESSION['wallet_verified']);
}
include "includes/db_connection.php";

$coin_id = $_SESSION['coin_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wallet_password'])) {
    $entered_password = $_POST['wallet_password'];
    $mobile = $_SESSION["mobile"];

    $stmt = $conn->prepare("SELECT password FROM users WHERE phone_num = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $hashed_entered = hash('sha512', $entered_password);

    if ($hashed_entered === $row['password']) {
        $_SESSION['wallet_verified'] = true;
    } else {
        $_SESSION["feedback"] = [
                "type" => "error",
                "message" => "Incorrect password. Please try again."
            ];
            header("Location: index.php");
            exit;
    }
}
$response = [
    'totalBalance' => 0,
    'totalSent' => 0,
    'totalReceived' => 0,
    'walletAdditions' => 0,
    'topReceiver' => '',
    'topReceiverAmount' => 0,
    'mostFrequentReceiver' => '',
    'topSender' => '',
    'topSenderAmount' => 0,
    'mostFrequentReceiverCount' => 0,

];

$stmt = $conn->prepare("SELECT total_amount FROM added_money WHERE coin_id = ? ORDER BY id DESC LIMIT 1");
$stmt->bind_param("s", $coin_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $response['totalBalance'] = $row['total_amount'];
}

$stmt = $conn->prepare("SELECT * FROM added_money WHERE coin_id = ?");
$stmt->bind_param("s", $coin_id);
$stmt->execute();
$transactions = $stmt->get_result();

$receiverAmounts = [];
$receiverCounts = [];
$senderAmounts = [];

while ($row = $transactions->fetch_assoc()) {
    $amount = (float) $row['amount_added'];
    $remarks = $row['remarks'];
    $from = $row['coin_id'];

    if (stripos($remarks, 'Sent to') !== false) {
        preg_match('/Sent to (.+@coin)/i', $remarks, $match);
        $receiver = isset($match[1]) ? trim($match[1]) : 'Unknown';

        $response['totalSent'] += abs($amount);
        $receiverAmounts[$receiver] = ($receiverAmounts[$receiver] ?? 0) + abs($amount);
        $receiverCounts[$receiver] = ($receiverCounts[$receiver] ?? 0) + 1;

    } elseif (stripos($remarks, 'Received from') !== false) {
        preg_match('/Received from (.+@coin)/i', $remarks, $match);
        $sender = isset($match[1]) ? trim($match[1]) : 'Unknown';

        $response['totalReceived'] += $amount;
        $senderAmounts[$sender] = ($senderAmounts[$sender] ?? 0) + $amount;
    } else {
        $response['walletAdditions'] += $amount;
    }
}

arsort($receiverAmounts);
$response['topReceiver'] = key($receiverAmounts);
$response['topReceiverAmount'] = current($receiverAmounts);

arsort($receiverCounts);
$response['mostFrequentReceiver'] = key($receiverCounts);
$response['mostFrequentReceiverCount'] = current($receiverCounts);

arsort($senderAmounts);
$response['topSender'] = key($senderAmounts);
$response['topSenderAmount'] = current($senderAmounts);
$coin_id = $_SESSION['coin_id'];

$stmt = $conn->prepare("SELECT total_smart_amount FROM smartwallet WHERE coni_id = ? ORDER BY id DESC LIMIT 1");
$stmt->bind_param("s", $coin_id);
$stmt->execute();
$result = $stmt->get_result();

$response['SmartWallet'] = 0;
if ($row = $result->fetch_assoc()) {
    $response['SmartWallet'] = $row['total_smart_amount'];
}





$stmt = $conn->prepare("SELECT * FROM added_money WHERE coin_id = ? ORDER BY id DESC LIMIT 5");
$stmt->bind_param("s", $coin_id);
$stmt->execute();
$recentTransactions = $stmt->get_result();


?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php' ?>

<>
    <?php include 'includes/navbar.php' ?>

    <div id="sidebar">
        <?php include 'includes/sidebar.php' ?>
    </div>

    <div class="main-content" id="mainContent">
        <div class="container py-4">
            <h2 class="mb-4">Welcome, <?php echo $user_data['full_name']; ?> 👋</h2>

            <div class="row g-4">
    <?php if (!isset($_SESSION['wallet_verified']) || $_SESSION['wallet_verified'] !== true): ?>
        <div class="col-12">
            <div class="card border-warning">
                <div class="card-body">
                    <h5 class="text-warning">Enter your password to view Account balances</h5>
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="wallet_password" placeholder="Enter password" required>
                            <div class="invalid-feedback">Please enter your password.</div>
                        </div>
                        <?php if (isset($wallet_error)): ?>
                            <div class="text-danger mb-2"><?php echo $wallet_error; ?></div>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary">Verify</button>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="col-md-12">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <h5>Total Balance</h5>
                    <h3 class="text-primary">₹<?php echo number_format($response['totalBalance'], 2); ?></h3>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="row g-4">
         <div class="col-md-12">
            <div class="card border-primary bg-light">
                <div class="card-body text-center">
                    <h5>Smart Wallet</h5>
                    <h3 class="text-primary">₹<?php echo number_format($response['SmartWallet'], 2); ?></h3>
                </div>
            </div>
        </div>
</div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-info">
                        <div class="card-body">
                            <h6>Wallet Additions</h6>
                            <h3 class="text-success">₹<?php echo number_format($response['walletAdditions'], 2); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-body">
                            <h5>Total Received</h5>
                            <h3 class="text-success">₹<?php echo number_format($response['totalReceived'], 2); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-danger">
                        <div class="card-body">
                            <h5>Total Sent</h5>
                            <h3 class="text-danger">₹<?php echo number_format($response['totalSent'], 2); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <div class="card border-dark">
                        <div class="card-body">
                            <h6>Most Frequent Receiver</h6>
                            <p><?php echo $response['mostFrequentReceiver']; ?> <br>Count:
                                <?php echo $response['mostFrequentReceiverCount']; ?></p>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-warning">
                        <div class="card-body">
                            <h6>Top Receiver (Amount)</h6>
                            <p><?php echo $response['topReceiver']; ?>
                                <br>₹<?php echo number_format($response['topReceiverAmount'], 2); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <h6>Top Sender</h6>
                            <p><?php echo $response['topSender']; ?>
                                <br>₹<?php echo number_format($response['topSenderAmount'], 2); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="mt-5">Recent Transactions</h4>
            <table class="table table-bordered table-striped mt-3">
                <thead class="table-light">
                    <tr>
                        <th>Timestamp</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $recentTransactions->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date("d M Y, h:i A", strtotime($row['timestamp'])); ?></td>
                            <td class="<?php echo $row['amount_added'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                ₹<?php echo number_format($row['amount_added'], 2); ?>
                            </td>
                            <td>
                                <?php
                                if (stripos($row['remarks'], 'Sent to') !== false) {
                                    echo 'Sent';
                                } elseif (stripos($row['remarks'], 'Received from') !== false) {
                                    echo 'Received';
                                } else {
                                    echo 'Wallet Add';
                                }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['remarks']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="row mt-5">
            <div class="col-md-4">
                <canvas id="walletChart"></canvas>
            </div>
            <div class="col-md-7">
                <canvas id="topRecipientsChart"></canvas>
            </div>
        </div>
    </div>
    <?php include 'chat_component.php'; ?>
    <?php include 'toggle.php'; ?>
    <?php include 'modelcode.php'; ?>
    <?php include 'validate.php'; ?>

    <script>
        const walletData = {
            sent: <?php echo $response['totalSent']; ?>,
            received: <?php echo $response['totalReceived']; ?>,
            walletAdditions: <?php echo $response['walletAdditions']; ?>,
            smartWallet: <?php echo 25; ?>
        };

        const topRecipients = <?php echo json_encode(array_slice($receiverAmounts, 0, 5)); ?>;
    </script>
    <script>
        const ctx1 = document.getElementById('walletChart').getContext('2d');
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: ['Sent', 'Received', 'Wallet Additions', 'Smart Wallet'],
                datasets: [{
                    label: 'Wallet Distribution',
                    data: [walletData.sent, walletData.received, walletData.walletAdditions, walletData.smartWallet],
                    backgroundColor: ['#dc3545', '#28a745', '#007bff', '#2622c2'],
                }]
            }
        });

        const ctx2 = document.getElementById('topRecipientsChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: Object.keys(topRecipients),
                datasets: [{
                    label: 'Amount Sent',
                    data: Object.values(topRecipients),
                    backgroundColor: '#6c757d'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>