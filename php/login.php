<?php
  session_start();
  
  // Check if user is already logged in
  // if (isset($_SESSION['user_id'])) {
  //   header("Location: dashboard.php");
  //   exit();
  // }
  
  // Check for login errors
  $error_message = "";
  if (isset($_SESSION['login_error'])) {
    $error_message = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Zara Tech - Login</title>
  <meta name="description" content="Login to your Zara Tech account to access internship applications and more.">

  <!-- Favicons -->
  <link href="../assets/img/logo.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../assets/css/main.css" rel="stylesheet">
  
  <style>
    :root {
      --primary-color: #4154f1;
      --secondary-color: #6c757d;
      --success-color: #28a745;
      --danger-color: #dc3545;
      --light-color: #f8f9fa;
      --dark-color: #343a40;
      --transition-speed: 0.3s;
      --box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
    }
    
    /* Animated Background */
    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
      background-size: 400% 400%;
      animation: gradient 15s ease infinite;
      position: relative;
      overflow: hidden;
    }
    
    @keyframes gradient {
      0% {
        background-position: 0% 50%;
      }
      50% {
        background-position: 100% 50%;
      }
      100% {
        background-position: 0% 50%;
      }
    }
    
    /* Floating particles */
    body::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background: url('../assets/img/image3.webp');
      animation: particles 20s linear infinite;
      opacity: 0.5;
    }
    
    @keyframes particles {
      0% {
        transform: translateX(10vh) rotate(280deg);
      }
      25% {
        transform: translateY(-25vh) rotate(90deg);
      }
      50% {
        transform: translateX(-50vh) rotate(180deg);
      }
      75% {
        transform: translateY(-75vh) rotate(270deg);
      }
      100% {
        transform: translateX(-100vh) rotate(360deg);
      }
    }
    
    /* Enhanced Container Animation */
    .auth-container {
      display: flex;
      width: 900px;
      max-width: 95%;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(10px);
      transform: perspective(1000px);
      animation: container-appear 1s cubic-bezier(0.34, 1.56, 0.64, 1);
      transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    .auth-container:hover {
      transform: perspective(1000px) translateY(-5px);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    }
    
    @keyframes container-appear {
      0% {
        opacity: 0;
        transform: perspective(1000px) rotateX(10deg) translateY(50px);
      }
      100% {
        opacity: 1;
        transform: perspective(1000px) rotateX(0) translateY(0);
      }
    }
    
    .auth-image {
      flex: 1;
      background: linear-gradient(135deg, rgba(65, 84, 241, 0.9) 0%, rgba(116, 97, 255, 0.9) 100%), url('assets/img/login-bg.jpg');
      background-size: cover;
      background-position: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: white;
      padding: 40px;
      position: relative;
      overflow: hidden;
      animation: slide-in-left 1.2s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    @keyframes slide-in-left {
      0% {
        transform: translateX(-100%);
        opacity: 0;
      }
      100% {
        transform: translateX(0);
        opacity: 1;
      }
    }
    
    .auth-image::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(65, 84, 241, 0.8) 0%, rgba(116, 97, 255, 0.8) 100%);
      animation: pulse-gradient 8s ease infinite;
    }
    
    @keyframes pulse-gradient {
      0% {
        background: linear-gradient(135deg, rgba(65, 84, 241, 0.8) 0%, rgba(116, 97, 255, 0.8) 100%);
      }
      50% {
        background: linear-gradient(135deg, rgba(116, 97, 255, 0.8) 0%, rgba(65, 84, 241, 0.8) 100%);
      }
      100% {
        background: linear-gradient(135deg, rgba(65, 84, 241, 0.8) 0%, rgba(116, 97, 255, 0.8) 100%);
      }
    }
    
    .auth-image-content {
      position: relative;
      z-index: 1;
      text-align: center;
      animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
      0% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(-15px);
      }
      100% {
        transform: translateY(0px);
      }
    }
    
    .auth-image h2 {
      font-size: 2.5rem;
      margin-bottom: 20px;
      font-weight: 700;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      animation: text-focus-in 1s cubic-bezier(0.55, 0.085, 0.68, 0.53) 0.5s both;
    }
    
    @keyframes text-focus-in {
      0% {
        filter: blur(12px);
        opacity: 0;
      }
      100% {
        filter: blur(0px);
        opacity: 1;
      }
    }
    
    .auth-image p {
      font-size: 1.1rem;
      margin-bottom: 30px;
      line-height: 1.6;
      text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
      animation: fade-in 1s ease 0.8s both;
    }
    
    @keyframes fade-in {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }
    
    .auth-form {
      flex: 1;
      padding: 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      animation: slide-in-right 1.2s cubic-bezier(0.34, 1.56, 0.64, 1);
      position: relative;
      z-index: 1;
    }
    
    @keyframes slide-in-right {
      0% {
        transform: translateX(100%);
        opacity: 0;
      }
      100% {
        transform: translateX(0);
        opacity: 1;
      }
    }
    
    .auth-form h3 {
      font-size: 1.8rem;
      margin-bottom: 30px;
      color: var(--dark-color);
      font-weight: 600;
      text-align: center;
    }
    
    .form-group {
      margin-bottom: 25px;
      position: relative;
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
      pointer-events: none;
    }
    
    .form-group.visible {
      opacity: 1;
      transform: translateY(0);
      pointer-events: auto;
    }
    
    .form-group.active {
      animation: highlight-field 2s ease;
    }
    
    @keyframes highlight-field {
      0%, 100% {
        box-shadow: 0 0 0 0 rgba(65, 84, 241, 0);
      }
      50% {
        box-shadow: 0 0 15px 5px rgba(65, 84, 241, 0.3);
      }
    }
    
    .form-control {
      height: 55px;
      border-radius: 10px;
      padding: 10px 20px;
      font-size: 16px;
      border: 2px solid #e1e5ee;
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      background: rgba(255, 255, 255, 0.8);
    }
    
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 20px rgba(65, 84, 241, 0.25);
      transform: translateY(-2px);
      background: rgba(255, 255, 255, 1);
    }
    
    .form-label {
      position: absolute;
      top: 17px;
      left: 20px;
      color: var(--secondary-color);
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      pointer-events: none;
      font-size: 16px;
    }
    
    .form-control:focus ~ .form-label,
    .form-control:not(:placeholder-shown) ~ .form-label {
      top: -12px;
      left: 15px;
      font-size: 12px;
      background: white;
      padding: 0 5px;
      color: var(--primary-color);
      font-weight: 600;
    }
    
    .btn-primary {
      background-color: var(--primary-color);
      border: none;
      height: 55px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      margin-top: 10px;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }
    
    .btn-primary::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: all 0.6s;
      z-index: -1;
    }
    
    .btn-primary:hover {
      background-color: #2a36a0;
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(65, 84, 241, 0.4);
    }
    
    .btn-primary:hover::before {
      left: 100%;
    }
    
    .auth-links {
      text-align: center;
      margin-top: 25px;
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    .auth-links.visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    .auth-links a {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s;
      position: relative;
    }
    
    .auth-links a::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -2px;
      left: 0;
      background-color: var(--primary-color);
      transition: width 0.3s;
    }
    
    .auth-links a:hover::after {
      width: 100%;
    }
    
    .form-check {
      margin-bottom: 20px;
    }
    
    .form-check-input {
      width: 18px;
      height: 18px;
      margin-top: 0.2rem;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .form-check-input:checked {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      animation: checkbox-pop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    @keyframes checkbox-pop {
      0% {
        transform: scale(0.8);
      }
      50% {
        transform: scale(1.2);
      }
      100% {
        transform: scale(1);
      }
    }
    
    .form-check-label {
      padding-left: 5px;
      color: var(--secondary-color);
      cursor: pointer;
    }
    
    .alert {
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 25px;
      opacity: 0;
      transform: translateY(-20px);
      transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
      background: rgba(220, 53, 69, 0.1);
      border: 1px solid rgba(220, 53, 69, 0.2);
    }
    
    .alert.visible {
      opacity: 1;
      transform: translateY(0);
      animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
    }
    
    @keyframes shake {
      10%, 90% {
        transform: translateX(-1px);
      }
      20%, 80% {
        transform: translateX(2px);
      }
      30%, 50%, 70% {
        transform: translateX(-4px);
      }
      40%, 60% {
        transform: translateX(4px);
      }
    }
    
    .social-login {
      margin-top: 30px;
      text-align: center;
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    .social-login.visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    .social-login p {
      color: var(--secondary-color);
      margin-bottom: 15px;
      position: relative;
    }
    
    .social-login p::before,
    .social-login p::after {
      content: "";
      position: absolute;
      top: 50%;
      width: 30%;
      height: 1px;
      background-color: #e1e5ee;
    }
    
    .social-login p::before {
      left: 0;
    }
    
    .social-login p::after {
      right: 0;
    }
    
    .social-icons {
      display: flex;
      justify-content: center;
      gap: 15px;
    }
    
    .social-icon {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #f8f9fa;
      color: var(--dark-color);
      font-size: 20px;
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      border: 1px solid #e1e5ee;
      position: relative;
      overflow: hidden;
    }
    
    .social-icon::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background: var(--primary-color);
      top: 100%;
      left: 0;
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      z-index: -1;
    }
    
    .social-icon:hover {
      color: white;
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      border-color: var(--primary-color);
    }
    
    .social-icon:hover::before {
      top: 0;
    }
    
    .welcome-text {
      text-align: center;
      margin-bottom: 40px;
      cursor: pointer;
      transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
      animation: welcome-bounce 2s infinite;
    }
    
    @keyframes welcome-bounce {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
    }
    
    .welcome-text:hover {
      transform: scale(1.05);
    }
    
    .welcome-text h4 {
      color: var(--primary-color);
      font-weight: 600;
      margin-bottom: 10px;
      text-shadow: 0 2px 10px rgba(65, 84, 241, 0.2);
    }
    
    .welcome-text p {
      color: var(--secondary-color);
    }
    
    /* Glowing effect */
    .glow {
      animation: glow 2s ease-in-out infinite alternate;
    }
    
    @keyframes glow {
      from {
        text-shadow: 0 0 5px #fff, 0 0 10px #fff, 0 0 15px var(--primary-color), 0 0 20px var(--primary-color);
      }
      to {
        text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px var(--primary-color), 0 0 40px var(--primary-color);
      }
    }
    
    @media (max-width: 768px) {
      .auth-container {
        flex-direction: column;
      }
      
      .auth-image {
        display: none;
      }
      
      .auth-form {
        padding: 30px;
      }
    }
  </style>
</head>

<body>
 <div class="auth-container">
    <div class="auth-image">
      <div class="auth-image-content">
        <h2>Welcome Back!</h2>
        <p>Log in to access your account and explore internship opportunities at Zara Tech.</p>
        <img src="../assets/img/hero-img.png" alt="Login Illustration" style="max-width: 80%; margin-top: 20px;">
      </div>
    </div>
    
    <div class="auth-form">
      <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger" id="error-alert">
          <?php echo $error_message; ?>
        </div>
      <?php endif; ?>
      
      <div class="welcome-text" id="welcome-prompt">
        <h4 class="glow">Sign In to Your Account</h4>
        <p>Click here to get started</p>
      </div>
      
      <form action="process_login.php" method="POST" id="login-form">
        <div class="form-group" id="email-group">
          <input type="email" class="form-control" id="email" name="email" placeholder=" " required>
          <label for="email" class="form-label">Email Address</label>
        </div>
        
        <div class="form-group" id="password-group">
          <input type="password" class="form-control" id="password" name="password" placeholder=" " required>
          <label for="password" class="form-label">Password</label>
        </div>
        
        <div class="form-group" id="remember-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember" name="remember">
            <label class="form-check-label" for="remember">
              Remember me
            </label>
          </div>
        </div>
        
        <div class="form-group" id="submit-group">
          <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </div>
      </form>
      
      <div class="auth-links" id="links-group">
        <a href="forgot_password.php">Forgot Password?</a>
        <p class="mt-3 mb-0">Don't have an account? <a href="signup.php">Sign Up</a></p>
      </div>
      
      <div class="social-login" id="social-login">
        <p>Or sign in with</p>
        <div class="social-icons">
          <a href="#" class="social-icon"><i class="bi bi-google"></i></a>
          <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
          <a href="#" class="social-icon"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div>
  </div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const welcomePrompt = document.getElementById('welcome-prompt');
      const loginForm = document.getElementById('login-form');
      const formGroups = document.querySelectorAll('.form-group');
      const socialLogin = document.getElementById('social-login');
      const errorAlert = document.getElementById('error-alert');
      const authLinks = document.getElementById('links-group');
      
      // Hide all form groups initially
      formGroups.forEach(group => {
        group.style.display = 'none';
      });
      
      // Hide social login and auth links initially
      if (socialLogin) {
        socialLogin.style.display = 'none';
      }
      
      if (authLinks) {
        authLinks.style.display = 'none';
      }
      
      // Show error alert if exists
      if (errorAlert) {
        errorAlert.classList.add('visible');
      }
      
      // Function to sequentially show form elements with animation
      function revealFormElements() {
        // Hide welcome prompt with fade out
        welcomePrompt.style.transition = 'opacity 0.5s, transform 0.5s';
        welcomePrompt.style.opacity = '0';
        welcomePrompt.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
          welcomePrompt.style.display = 'none';
          
          // Show only the first form group (email)
          const emailGroup = document.getElementById('email-group');
          emailGroup.style.display = 'block';
          
          setTimeout(() => {
            emailGroup.classList.add('visible');
            emailGroup.classList.add('active');
            
            // Focus on the email input
            document.getElementById('email').focus();
          }, 200);
          
          // Setup sequential form activation
          setupSequentialFormActivation();
          
        }, 500);
      }
      
      // Function to setup sequential form activation
      function setupSequentialFormActivation() {
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const passwordGroup = document.getElementById('password-group');
        const rememberGroup = document.getElementById('remember-group');
        const submitGroup = document.getElementById('submit-group');
        
        // When email is filled, show password field
        email.addEventListener('input', function() {
          if (email.value.length >= 10 && !passwordGroup.classList.contains('visible')) {
            passwordGroup.style.display = 'block';
            
            setTimeout(() => {
              passwordGroup.classList.add('visible');
              passwordGroup.classList.add('active');
              password.focus();
            }, 300);
          }
        });
        
        // When password is filled, show remember me and submit button
        password.addEventListener('input', function() {
          if (password.value.length > 0 && !rememberGroup.classList.contains('visible')) {
            rememberGroup.style.display = 'block';
            submitGroup.style.display = 'block';
            
            setTimeout(() => {
              rememberGroup.classList.add('visible');
              
              setTimeout(() => {
                submitGroup.classList.add('visible');
                
                // Show auth links after submit button
                authLinks.style.display = 'block';
                setTimeout(() => {
                  authLinks.classList.add('visible');
                  
                  // Show social login last
                  if (socialLogin) {
                    socialLogin.style.display = 'block';
                    setTimeout(() => {
                      socialLogin.classList.add('visible');
                    }, 300);
                  }
                }, 300);
              }, 300);
            }, 300);
          }
        });
      }
      
      // Trigger animation on welcome prompt click
      welcomePrompt.addEventListener('click', revealFormElements);
      
      // Also trigger on page click after a short delay
      setTimeout(() => {
        document.body.addEventListener('click', function bodyClickHandler() {
          revealFormElements();
          document.body.removeEventListener('click', bodyClickHandler);
        });
      }, 2000);
      
      // Add floating effect to container on mouse move
      const container = document.querySelector('.auth-container');
      document.addEventListener('mousemove', function(e) {
        const x = e.clientX / window.innerWidth;
        const y = e.clientY / window.innerHeight;
        
        container.style.transform = `perspective(1000px) rotateY(${x * 5 - 2.5}deg) rotateX(${y * -5 + 2.5}deg) translateY(-5px)`;
      });
      
      // Reset transform when mouse leaves
      document.addEventListener('mouseleave', function() {
        container.style.transform = 'perspective(1000px) rotateY(0deg) rotateX(0deg) translateY(-5px)';
      });
    });
  </script>
</body>

</html>