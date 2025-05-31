<?php
session_start();
include "member/includes/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $password = hash("sha512", $_POST["password"]);
    $confirm_password = hash("sha512", $_POST["confirm_password"]);
    $coin_id = $mobile . "@coin";
    $_SESSION['coin_id'] = $coin_id;

    if ($password !== $confirm_password) {
        $error_message = "Error: Passwords do not match. Try Again!";
    } else {
        $exists = $conn->prepare("SELECT * FROM users WHERE phone_num = ?");
        $exists->bind_param("s", $mobile);
        $exists->execute();
        $result = $exists->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Mobile number already exists. Please choose a different one.";
        } else {
            $insert = $conn->prepare("INSERT INTO users (full_name, email, phone_num, password, coin_id) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("sssss", $full_name, $email, $mobile, $password, $coin_id);

            if ($insert->execute()) {
                $_SESSION["coin_id"] = $coin_id;
                $success_message = "Account Created Successfully!";

                $alter_query = "ALTER TABLE friends ADD `$coin_id` varchar(128) AFTER id";
                if ($conn->query($alter_query) ){
                    // Column added successfully
                } else {
                    $error_message = "Error adding account: " . $conn->error;
                }
            } else {
                $error_message = "Error creating account: " . $conn->error;
            }
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up | COIN PAY</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/img/coin_logo.png" rel="icon">
  <link href="assets/css/style.css" rel="stylesheet">
  
  

  <style>
    :root {
      --primary-color: #4361ee;
      --primary-hover: #3a56d4;
      --success-color: #2ecc71;
      --error-color: #e74c3c;
      --text-color: #2b2d42;
      --light-gray: #f8f9fa;
    }
    
    body {
      background-color: var(--light-gray);
      font-family: 'Poppins', sans-serif;
      color: var(--text-color);
    }
    
    .signup-container {
      max-width: 500px;
      margin: 3rem auto;
      padding: 2.5rem;
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      position: relative;
      overflow: hidden;
    }
    
    .signup-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, var(--primary-color), #3f37c9);
    }
    
    .signup-heading {
      text-align: center;
      margin-bottom: 2rem;
      font-weight: 600;
      color: var(--text-color);
    }
    
    .logo-container {
      text-align: center;
      margin-bottom: 1.5rem;
    }
    
    .logo-container img {
      width: 80px;
      height: auto;
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
    
    .input-icon {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #6c757d;
    }
    
    .btn-signup {
      background-color: var(--primary-color);
      border: none;
      padding: 12px;
      font-weight: 500;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
      width: 100%;
    }
    
    .btn-signup:hover {
      background-color: var(--primary-hover);
      transform: translateY(-2px);
    }
    
    .btn-signup:active {
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
    
    .alert-message {
      padding: 12px 15px;
      border-radius: 8px;
      margin-bottom: 1.5rem;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
    }
    
    .alert-success {
      background-color: rgba(46, 204, 113, 0.1);
      border: 1px solid rgba(46, 204, 113, 0.3);
      color: var(--success-color);
    }
    
    .alert-error {
      background-color: rgba(231, 76, 60, 0.1);
      border: 1px solid rgba(231, 76, 60, 0.3);
      color: var(--error-color);
    }
    
    .password-strength {
      height: 4px;
      background: #e9ecef;
      border-radius: 2px;
      margin-top: 8px;
      overflow: hidden;
    }
    
    .strength-meter {
      height: 100%;
      width: 0;
      transition: width 0.3s ease, background 0.3s ease;
    }
    
    @media (max-width: 576px) {
      .signup-container {
        margin: 1.5rem;
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
          <a href="login.php" class="btn btn-primary">Login</a>
        </div>
      </div>
    </div>
</nav>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="signup-container">
          <div class="logo-container">
              <img src="rotate_fix.gif" alt="Company Logo">
            </div>
          
          <h2 class="signup-heading">Create Your Account</h2>
          
          <?php if(isset($success_message)): ?>
            <div class="alert-message alert-success">
              <i class="bi bi-check-circle-fill me-2"></i> <?php echo $success_message; ?>
            </div>
          <?php endif; ?>
          
          <?php if(isset($error_message)): ?>
            <div class="alert-message alert-error">
              <i class="bi bi-exclamation-circle-fill me-2"></i> <?php echo $error_message; ?>
            </div>
          <?php endif; ?>
          
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
              <input type="text" class="form-control" id="fullname" name="full_name" placeholder="Full Name" required>
              <i class="bi bi-person input-icon"></i>
            </div>
            
            <div class="form-group">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
              <i class="bi bi-envelope input-icon"></i>
            </div>
            
            <div class="form-group">
              <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required>
              <i class="bi bi-phone input-icon"></i>
            </div>
            
            <div class="form-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="Create Password" required>
              <i class="bi bi-lock input-icon"></i>
              <div class="password-strength">
                <div class="strength-meter" id="strengthMeter"></div>
              </div>
            </div>
            
            <div class="form-group">
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
              <i class="bi bi-lock input-icon"></i>
            </div>
            
            <div class="d-grid gap-2 mt-4">
              <button type="submit" class="btn btn-primary btn-signup">
                <i class="bi bi-person-plus me-2"></i> Create Account
              </button>
            </div>
          </form>
          
          <div class="additional-links">
            <p>Already have an account? <a href="login.php">Sign in</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Password strength indicator
    document.getElementById('password').addEventListener('input', function() {
      const password = this.value;
      const meter = document.getElementById('strengthMeter');
      let strength = 0;
      
      // Check for length
      if (password.length >= 8) strength += 1;
      
      // Check for uppercase letters
      if (/[A-Z]/.test(password)) strength += 1;
      
      // Check for numbers
      if (/[0-9]/.test(password)) strength += 1;
      
      // Check for special characters
      if (/[^A-Za-z0-9]/.test(password)) strength += 1;
      
      // Update meter
      const width = strength * 25;
      meter.style.width = width + '%';
      
      // Update color
      if (strength <= 1) {
        meter.style.background = '#e74c3c';
      } else if (strength <= 3) {
        meter.style.background = '#f39c12';
      } else {
        meter.style.background = '#2ecc71';
      }
    });
    
    // Confirm password validation
    document.getElementById('confirm_password').addEventListener('input', function() {
      const password = document.getElementById('password').value;
      const confirmPassword = this.value;
      
      if (password !== confirmPassword && confirmPassword.length > 0) {
        this.classList.add('is-invalid');
      } else {
        this.classList.remove('is-invalid');
      }
    });
  </script>
</body>
</html>