<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>COIN-PAY | Smart Payments Redefined</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="icon" href="assets/img/coin_logo.png" />
  <style>
        :root {
      --primary: #6C5CE7;
      --primary-light: #A29BFE;
      --primary-dark: #5649C0;
      --dark: #2D3436;
      --light: #FFFFFF;
      --gray: #F5F6FA;
      --dark-gray: #636E72;
      --success: #00B894;
      --danger: #D63031;
      --warning: #FDCB6E;
      --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
      --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
      --shadow-lg: 0 10px 25px rgba(0,0,0,0.1);
    }

    body {
      font-family: 'Inter', sans-serif;
      color: var(--dark);
      background-color: var(--light);
      line-height: 1.6;
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

    .btn-primary {
      background-color: var(--primary);
      border-color: var(--primary);
      font-weight: 600;
      padding: 0.5rem 1.5rem;
      border-radius: 8px;
    }

    .btn-primary:hover {
      background-color: var(--primary-dark);
      border-color: var(--primary-dark);
    }

    .btn-outline-primary {
      color: var(--primary);
      border-color: var(--primary);
      font-weight: 500;
    }

    .btn-outline-primary:hover {
      background-color: var(--primary);
      color: white;
    }

    .hero {
      background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
      padding: 5rem 0;
      position: relative;
      overflow: hidden;
    }

    .hero-content {
      position: relative;
      z-index: 2;
    }

    .hero-title {
      font-size: 3.5rem;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 1.5rem;
      color: var(--dark);
    }

    .hero-subtitle {
      font-size: 1.25rem;
      color: var(--dark-gray);
      margin-bottom: 2rem;
      max-width: 600px;
    }

    .hero-btns .btn {
      margin-right: 1rem;
      margin-bottom: 1rem;
    }

    .hero-image {
      position: relative;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: var(--shadow-lg);
      transform: perspective(1000px) rotateY(-10deg);
      transition: transform 0.3s ease;
    }

    .hero-image:hover {
      transform: perspective(1000px) rotateY(-5deg);
    }

    .section-title {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: var(--dark);
    }

    .section-subtitle {
      color: var(--dark-gray);
      margin-bottom: 3rem;
      max-width: 700px;
    }

    .feature-card {
      background: var(--light);
      border-radius: 12px;
      padding: 2rem;
      height: 100%;
      transition: all 0.3s ease;
      border: 1px solid rgba(0,0,0,0.05);
      box-shadow: var(--shadow-sm);
    }

    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
      border-color: var(--primary-light);
    }

    .feature-icon {
      width: 60px;
      height: 60px;
      background: rgba(108, 92, 231, 0.1);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
    }

    .feature-icon i {
      font-size: 1.75rem;
      color: var(--primary);
    }

    .feature-title {
      font-size: 1.25rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .feature-text {
      color: var(--dark-gray);
    }

    .video-container {
      border-radius: 16px;
      overflow: hidden;
      box-shadow: var(--shadow-lg);
    }
    .footer {
      background-color: var(--dark);
      color: white;
      padding: 4rem 0 2rem;
    }

    .footer-logo img {
      height: 32px;
      margin-bottom: 1.5rem;
    }

    .footer-links h5 {
      font-size: 1.125rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
    }

    .footer-links ul {
      list-style: none;
      padding: 0;
    }

    .footer-links li {
      margin-bottom: 0.75rem;
    }

    .footer-links a {
      color: rgba(255,255,255,0.7);
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .footer-links a:hover {
      color: white;
      padding-left: 5px;
    }

    .social-icons a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background: rgba(255,255,255,0.1);
      border-radius: 50%;
      margin-right: 0.75rem;
      color: white;
      transition: all 0.2s ease;
    }

    .social-icons a:hover {
      background: var(--primary);
      transform: translateY(-3px);
    }

    .copyright {
      border-top: 1px solid rgba(255,255,255,0.1);
      padding-top: 2rem;
      margin-top: 3rem;
      color: rgba(255,255,255,0.7);
    }

    @media (max-width: 992px) {
      .hero-title {
        font-size: 2.75rem;
      }
    }

    @media (max-width: 768px) {
      .hero {
        padding: 3rem 0;
        text-align: center;
      }
      
      .hero-title {
        font-size: 2.25rem;
      }
      
      .hero-subtitle {
        margin-left: auto;
        margin-right: auto;
      }
      
      .hero-btns {
        justify-content: center;
      }
      
      .hero-image {
        margin-top: 2rem;
        transform: none !important;
      }
    }

    @media (max-width: 576px) {
      .hero-title {
        font-size: 2rem;
      }
      
      .section-title {
        font-size: 2rem;
      }
    }
#homeCarousel {
  position: relative;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

#homeCarousel .carousel-item {
  height: 60vh; 
  min-height: 400px;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  transition: transform 0.6s ease-in-out;
}

#homeCarousel .carousel-item::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.6) 100%);
}

.carousel-caption {
  background: rgba(0, 0, 0, 0.7);
  padding: 1.5rem;
  border-radius: 8px;
  backdrop-filter: blur(5px);
  bottom: 25%; 
  left: 50%;
  transform: translateX(-50%);
  width: 80%;
  max-width: 700px; 
  text-align: center;
}

.carousel-caption h1 {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 1rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.carousel-caption p {
  font-size: 1.2rem; 
  line-height: 1.5;
}

@media (max-width: 992px) {
  .carousel-caption {
    width: 90%;
    padding: 1rem;
  }
  
  .carousel-caption h1 {
    font-size: 2rem;
  }
  
  .carousel-caption p {
    font-size: 1rem;
  }
}

@media (max-width: 768px) {
  #homeCarousel .carousel-item {
    height: 50vh; 
    min-height: 350px;
  }
  
  .carousel-caption {
    bottom: 15%;
    padding: 0.8rem;
  }
  
  .carousel-caption h1 {
    font-size: 1.8rem;
  }
  
  .carousel-caption p {
    font-size: 0.9rem;
  }
}

#homeCarousel {
  position: relative;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

#homeCarousel .carousel-item {
  height: 70vh; 
  min-height: 400px;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  transition: transform 0.6s ease-in-out;
}

#homeCarousel .carousel-item::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.6) 100%);
}

.carousel-caption {
  background: rgba(0, 0, 0, 0.7);
  padding: 1.5rem;
  border-radius: 8px;
  backdrop-filter: blur(5px);
  bottom: 25%; 
  left: 50%;
  transform: translateX(-50%);
  width: 80%;
  max-width: 700px; 
  text-align: center;
}

.carousel-caption h1 {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 1rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.carousel-caption p {
  font-size: 1.2rem; 
  line-height: 1.5;
}

@media (max-width: 992px) {
  .carousel-caption {
    width: 90%;
    padding: 1rem;
  }
  
  .carousel-caption h1 {
    font-size: 2rem;
  }
  
  .carousel-caption p {
    font-size: 1rem;
  }
}

@media (max-width: 768px) {
  #homeCarousel .carousel-item {
    height: 60vh;
    min-height: 350px;
  }
  
  .carousel-caption {
    bottom: 15%;
    padding: 0.8rem;
  }
  
  .carousel-caption h1 {
    font-size: 1.8rem;
  }
  
  .carousel-caption p {
    font-size: 0.9rem;
  }
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
          <li class="nav-item">
            <a class="nav-link" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#featured">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#service">services</a>
          </li>
        <div class="d-flex ms-lg-3 mt-3 mt-lg-0">
          <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
          <a href="sign_up.php" class="btn btn-primary">Sign Up</a>
        </div>
      </div>
    </div>
</nav>
<section id="home">
  <div id="homeCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active" style="background-image: url(assets/img/home-carousel/precision.jpg);">
        <div class="carousel-caption">
          <h1 class="display-4 fw-bold">Precision</h1>
          <p>Crafting Pixel-Perfect Experiences for Seamless Transactions.</p>
        </div>
      </div>
      <div class="carousel-item" style="background-image: url(assets/img/home-carousel/security.jpg);">
        <div class="carousel-caption">
          <h1 class="display-4 fw-bold">Security</h1>
          <p>Fortifying Your Finances: Robust Protection, Peace of Mind.</p>
        </div>
      </div>
      <div class="carousel-item" style="background-image: url(assets/img/home-carousel/innovation.jpg);">
        <div class="carousel-caption">
          <h1 class="display-4 fw-bold">Innovation</h1>
          <p>Pushing Boundaries, Redefining User Interaction in Finance.</p>
        </div>
      </div>
      <div class="carousel-item" style="background-image: url(assets/img/home-carousel/efficiency.jpg);">
        <div class="carousel-caption">
          <h1 class="display-4 fw-bold">Efficiency</h1>
          <p>Streamlining Transactions: Swift, Smooth, and Stress-Free.</p>
        </div>
      </div>
      <div class="carousel-item" style="background-image: url(assets/img/home-carousel/elegance.jpg);">
        <div class="carousel-caption">
          <h1 class="display-4 fw-bold">Elegance</h1>
          <p>Where Simplicity Meets Sophistication: Elevating Digital Wallets.</p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</section>



<section id="featured" class="py-5">
  <div class="text-center mb-5">
        <h2 class="section-title">Features</h2>
        <p class="section-subtitle mx-auto">Our platform offers cutting-edge features designed to simplify your financial transactions</p>
      </div>
  <div class="container">
    <div class="row g-4 text-center align-items-center">
      <div class="col-md-4">
        <div class="feature-card">
          <i class="bi bi-currency-exchange"></i>
          <h4>Revolutionary Transactions</h4>
          <p>Introducing COIN: Where Blockchain Meets Your Wallet. Enjoy lightning-fast transactions and pioneering broadcast capabilities, setting new standards in digital finance.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card">
          <i class="bi bi-shield-lock-fill"></i>
          <h4>Seamless Security</h4>
          <p>Your Fortress in the Digital World. Utilizing blockchain technology, COIN ensures ironclad security for your transactions, making every exchange a peace of mind.</p>
        </div>
      </div>
      <div class="col-md-4">
  <div class="feature-card">
    <i class="bi bi-toggle2-on"></i>
    <h4>Smart Wallet Control</h4>
    <p>Enable or disable your wallet access anytime for full control and added security.</p>
  </div>
</div>

    </div>
  </div>
</section>


  <section class="py-5 my-5" id="service">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title">Why Choose COIN-PAY</h2>
        <p class="section-subtitle mx-auto">Our platform offers cutting-edge features designed to simplify your financial transactions</p>
      </div>
      <div class="row g-4">
        <div class="col-md-6 col-lg-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-currency-exchange"></i>
            </div>
            <h3 class="feature-title">Secure Transactions</h3>
            <p class="feature-text">Experience peace of mind with our secure transaction platform powered by blockchain technology. Your financial data is encrypted and protected against unauthorized access, ensuring every transaction is safe and secure.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-shield-lock"></i>
            </div>
            <h3 class="feature-title">Broadcast Transactions</h3>
            <p class="feature-text">With COIN's innovative broadcast transactions feature, you can send money to multiple recipients simultaneously, saving time and streamlining your payment processes.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-lightning-charge"></i>
            </div>
            <h3 class="feature-title">Voice Assistance</h3>
            <p class="feature-text">Enjoy a seamless user experience with our integrated voice assistance feature. Simply speak commands to initiate transactions, check your balance, or access other account information, making managing your finances easier than ever before.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-broadcast"></i>
            </div>
            <h3 class="feature-title">Real-time Updates</h3>
            <p class="feature-text">Stay informed with real-time updates on your transactions. Whether you're sending money, receiving funds, or conducting a broadcast transaction, you'll receive instant notifications to keep you in the loop.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-mic"></i>
            </div>
            <h3 class="feature-title">24/7 Support</h3>
            <p class="feature-text">We're here for you whenever you need assistance. Our dedicated support team is available 24/7 to address any questions or concerns you may have, ensuring you have a smooth and hassle-free experience with COIN.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-graph-up"></i>
            </div>
            <h3 class="feature-title">Advanced Dashboard & Analytics</h3>
            <p class="feature-text">Visualize total amount sent/received

See frequent senders/receivers

Graphs showing top transactions, history trends, and more</p>
          </div>
        </div>
         <div class="col-md-6 col-lg-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-graph-up"></i>
            </div>
            <h3 class="feature-title">Smart Wallet System</h3>
            <p class="feature-text">Rounds up payments and saves the difference

Example: Sending ₹197 rounds to ₹200, saving ₹3

Funds are stored securely and used only when:

Balance exceeds ₹50

Bank service is unavailable

User manually donates or transfers</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5 bg-light">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h2 class="section-title">See It In Action</h2>
          <p class="section-subtitle">Watch how COIN-PAY transforms your payment experience with intuitive design and powerful features.</p>
          <ul class="list-unstyled">
            <li class="mb-2 d-flex align-items-center">
              <i class="bi bi-check-circle-fill text-primary me-2"></i>
              <span>Secure transactions with end-to-end encryption</span>
            </li>
            <li class="mb-2 d-flex align-items-center">
              <i class="bi bi-check-circle-fill text-primary me-2"></i>
              <span>Instant transfers with minimal fees</span>
            </li>
            <li class="mb-2 d-flex align-items-center">
              <i class="bi bi-check-circle-fill text-primary me-2"></i>
              <span>User-friendly interface for all experience levels</span>
            </li>
          </ul>
          <a href="sign_up.php" class="btn btn-primary mt-3">Use COIN-PAY</a>
        </div>
        <div class="col-lg-6">
          <div class="video-container">
            <video autoplay loop muted class="w-100">
              <source src="services.mp4" type="video/mp4">
            </video>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="footer-logo">
            <img src="assets/img/coin_logo.png" alt="COIN-PAY Logo">
          </div>
          <p class="opacity-75">Smart payments redefined for the modern financial landscape. Secure, fast, and reliable.</p>
          <div class="social-icons mt-4">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-twitter"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
          </div>
        </div>
      <div class="copyright text-center">
        <p class="mb-0">&copy; 2025 COIN-PAY. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
document.addEventListener("DOMContentLoaded", function() {
  const links = document.querySelectorAll(".nav-link[href^='#']");
  const sections = Array.from(links).map(link => document.querySelector(link.getAttribute("href")));

  function activateLink() {
    let index = sections.findIndex(section =>
      section.getBoundingClientRect().top <= 150 && section.getBoundingClientRect().bottom > 150
    );

    links.forEach((link, i) => {
      if (i === index) {
        link.classList.add("active");
      } else {
        link.classList.remove("active");
      }
    });
  }

  window.addEventListener("scroll", activateLink);
});
</script>

</body>
</html>