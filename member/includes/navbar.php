
<?php
if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    
    header("location: http://localhost/coin/index.php?message=logout");
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
?>

<nav class="navbar navbar-expand-lg navbar-main">
    <div class="container-fluid">
        <button id="sidebarToggle" class="btn btn-link me-2">
            <i class="fas fa-bars fa-lg" style="color:var(--primary)"></i>
        </button>
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-coins me-2"></i> COIN-PAY
        </a>
        <div class="d-flex align-items-center ms-auto">
            <div class="d-none d-lg-block me-3">
                <div id="search-container" class="input-group top-search-bar">
                    <input type="search" id="search" name="q" class="form-control form-control-sm" placeholder="Search...">
                    
                <button id="microphone-icon" class="btn btn-sm btn-outline-secondary" aria-label="Start voice recognition">🎤</button>
                </div>
            </div>
            
            <div class="dropdown me-3">
                <a href="#" class="nav-link position-relative" id="notificationsDropdown" data-bs-toggle="dropdown">
                    <i class="fas fa-bell" style="color:var(--primary)"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow" style="width: 320px;">
                    <div class="dropdown-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Notifications</h6>
                        <small><a href="#" class="text-primary">Clear All</a></small>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="me-3 text-success">
                                <i class="fas fa-check-circle fa-lg" style="color:var(--primary)"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Payment Received</div>
                                <small class="text-muted">From: 8125903558@coin (₹1,500)</small>
                                <div class="text-muted small">10 minutes ago</div>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-center text-primary">View All Notifications</a>
                </div>
            </div>
            
            <div class="dropdown">
                <a href="#" class="nav-link" id="userDropdown" data-bs-toggle="dropdown">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="fas fa-user-circle fa-2x" style="color:var(--primary)"></i>
                        </div>
                        <div class="d-none d-md-block">
                            <div class="fw-bold" style="color:var(--primary)"><?php echo $user_data['full_name']; ?></div>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow">
                    <div class="dropdown-header">
                        <h6 class="mb-0"><?php echo $user_data['full_name']; ?></h6>
                        <small class="text-muted"><?php echo $user_data['email']; ?></small>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="profile.php" class="dropdown-item">
                        <i class="fas fa-user me-2"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="profile.php?logout=true" class="dropdown-item">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="overlay" id="sidebarOverlay"></div>

