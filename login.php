<?php
session_start();

include "member/includes/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $mobile = $_POST["mobile"];
  $password = $_POST["password"];

  $hashed_password = hash("sha512", $password);

  $stmt = $conn->prepare("SELECT * FROM users WHERE phone_num = ? AND password = ?");
  $stmt->bind_param("ss", $mobile, $hashed_password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
      $user = $result->fetch_assoc();
      $_SESSION["loggedin"] = true;
      $_SESSION["mobile"] = $mobile;
      $_SESSION['mail'] = $user['email'];
      $_SESSION['coin_id'] = $user['coin_id'];
      
      header("Location: http://localhost/coin/member/");
      exit;
  } else {
      $error_message = "Invalid mobile number or password.";
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page | COIN-PAY</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/img/coin_logo.png" rel="icon">
  <link href="assets/css/style.css" rel="stylesheet">

  <style>
    :root {
      --primary-color: #4361ee;
      --primary-hover: #3a56d4;
      --secondary-color: #f8f9fa;
      --text-color: #2b2d42;
      --light-gray: #f1f3f5;
    }

    body {
      background-color: var(--secondary-color);
      font-family: 'Poppins', sans-serif;
      color: var(--text-color);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    
    .login-container {
      max-width: 450px;
      margin: 2rem auto;
      padding: 2.5rem;
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      position: relative;
      overflow: hidden;
    }
    
    .login-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, var(--primary-color), #3f37c9);
    }
    
    .login-heading {
      text-align: center;
      margin-bottom: 2rem;
      color: var(--text-color);
      font-weight: 600;
    }
    
    .logo-container {
      text-align: center;
      margin-bottom: 1.5rem;
    }
    
    .logo-container img {
      width: 80px;
      height: auto;
      transition: transform 0.3s ease;
    }
    
    .logo-container img:hover {
      transform: rotate(15deg);
    }
    
    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }
    
    .form-control {
      padding: 12px 15px;
      border-radius: 8px;
      border: 1px solid #dee2e6;
      transition: all 0.3s ease;
    }
    
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
    }
    
    .form-group label {
      position: absolute;
      top: -10px;
      left: 10px;
      background: white;
      padding: 0 5px;
      font-size: 0.85rem;
      color: #6c757d;
    }
    
    .btn-login {
      background-color: var(--primary-color);
      border: none;
      padding: 12px;
      font-weight: 500;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
    }
    
    .btn-login:hover {
      background-color: var(--primary-hover);
      transform: translateY(-2px);
    }
    
    .btn-login:active {
      transform: translateY(0);
    }
    
    .additional-links {
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.9rem;
    }
    
    .additional-links a {
      color: var(--primary-color);
      text-decoration: none;
      transition: color 0.3s ease;
    }
    
    .additional-links a:hover {
      color: var(--primary-hover);
      text-decoration: underline;
    }
    
    .error-message {
      color: #dc3545;
      text-align: center;
      margin-bottom: 1rem;
      font-size: 0.9rem;
    }
    
    .input-icon {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #6c757d;
    }
    
    @media (max-width: 576px) {
      .login-container {
        margin: 1rem;
        padding: 1.5rem;
      }
    }
        .navbar {
      background-color: var(--light);
      box-shadow: var(--shadow-sm);
      padding: 1rem 0;
    }

    .navbar-brand img {
      height: 32px;
    }

    .nav-link {
      font-weight: 500;
      color: var(--dark) !important;
      margin: 0 0.5rem;
      padding: 0.5rem 1rem !important;
      border-radius: 8px;
      transition: all 0.2s ease;
    }

    .nav-link:hover, .nav-link.active {
      color: var(--primary) !important;
      background-color: rgba(108, 92, 231, 0.1);
    }
  </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">
          <img src="assets/img/coin_logo.png" alt="COIN-PAY Logo">COIN-PAY
        </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          
        <div class="d-flex ms-lg-3 mt-3 mt-lg-0">
          <a href="index.php" class="btn btn-outline-primary me-2">Home</a>
          <a href="sign_up.php" class="btn btn-primary">Sign Up</a>
        </div>
      </div>
    </div>
</nav>
  
  <main class="flex-grow-1 d-flex align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="login-container">
            <div class="logo-container">
              <img src="rotate_fix.gif" alt="Company Logo">
            </div>
            
            <h2 class="login-heading">Welcome Back</h2>
            
            <?php if(isset($error_message)): ?>
              <div class="error-message">
                <i class="bi bi-exclamation-circle-fill"></i> <?php echo $error_message; ?>
              </div>
            <?php endif; ?>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="form-group">
                <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required>
                <i class="bi bi-phone input-icon"></i>
              </div>
              
              <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <i class="bi bi-lock input-icon"></i>
              </div>
              
              <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn btn-primary btn-login">
                  <i class="bi bi-box-arrow-in-right"></i> Login
                </button>
              </div>
            </form>
            
            <div class="additional-links mt-4">
              <p>Don't have an account? <a href="sign_up.php">Sign up</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>