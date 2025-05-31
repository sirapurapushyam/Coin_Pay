<div class="sidebar" id="sidebar">
    <div class="sidebar-menu">
        <ul class="nav flex-column">
            <li class="nav-item" id="dashboard">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"
                    href="index.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item" id="add money">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'add.php' ? 'active' : ''; ?>"
                    href="add.php">
                    <i class="fas fa-wallet"></i>
                    <span>Add Money</span>
                </a>
            </li>
            <li class="nav-item" id="send money">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'send.php' ? 'active' : ''; ?>"
                    href="send.php">
                    <i class="fas fa-paper-plane"></i>
                    <span>Send Money</span>
                </a>
            </li>
            <li class="nav-item" id="check balance">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'check.php' ? 'active' : ''; ?>"
                    href="check.php">
                    <i class="fas fa-balance-scale"></i>
                    <span>Check Balance</span>
                </a>
            </li>
            <li class="nav-item" id="transaction history">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'history.php' ? 'active' : ''; ?>"
                    href="history.php">
                    <i class="fas fa-history"></i>
                    <span>Transaction History</span>
                </a>
            </li>
            <li class="nav-item" id="support tickets">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'ticket.php' ? 'active' : ''; ?>"
                    href="ticket.php">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Support Tickets</span>
                </a>
            </li>
            <li class="nav-item" id="profile">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>"
                    href="profile.php">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
            </li>

        </ul>
    </div>
</div>