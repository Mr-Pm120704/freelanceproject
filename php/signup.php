<?php
  session_start();
  
  // Check if user is already logged in
//   if (isset($_SESSION['user_id'])) {
//     header("Location: ../html/index.html");
//     exit();
//   }
  
  // Check for signup errors
  $error_message = "";
  if (isset($_SESSION['signup_error'])) {
    $error_message = $_SESSION['signup_error'];
    unset($_SESSION['signup_error']);
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Zara Tech - Sign Up</title>
  <meta name="description" content="Create a new account at Zara Tech to apply for internships and more.">

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
      background: url('../assets/img/image2.webp');
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
      width: 1000px;
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
      background: linear-gradient(135deg, rgba(65, 84, 241, 0.9) 0%, rgba(116, 97, 255, 0.9) 100%), url('assets/img/signup-bg.jpg');
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
      flex: 1.2;
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
    
    .welcome-text p {
      color: var(--secondary-color);
    }
    
    .password-strength {
      height: 5px;
      margin-top: 10px;
      border-radius: 5px;
      background-color: #e1e5ee;
      position: relative;
      overflow: hidden;
      transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    .password-strength-meter {
      height: 100%;
      border-radius: 5px;
      transition: width 0.5s ease, background-color 0.5s ease;
      width: 0;
      position: relative;
    }
    
    .password-strength-meter::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
      animation: shimmer 2s infinite;
      transform: translateX(-100%);
    }
    
    @keyframes shimmer {
      100% {
        transform: translateX(100%);
      }
    }
    
    .password-strength-text {
      font-size: 12px;
      margin-top: 5px;
      text-align: right;
      transition: all 0.3s;
      font-weight: 500;
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
        <h2>Join Zara Tech</h2>
        <p>Create an account to apply for internships and start your journey with us.</p>
        <img src="../assets/img/hero-img.png" alt="Signup Illustration" style="max-width: 80%; margin-top: 20px;">
      </div>
    </div>
    
    <div class="auth-form">
      <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger" id="error-alert">
          <?php echo $error_message; ?>
        </div>
      <?php endif; ?>
      
      <div class="welcome-text" id="welcome-prompt">
        <h4>Create Your Account</h4>
        <p>Click here to get started</p>
      </div>
      
      <form action="process_signup.php" method="POST" id="signup-form">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group" id="firstname-group">
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder=" " required>
              <label for="firstname" class="form-label">First Name</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" id="lastname-group">
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder=" " required>
              <label for="lastname" class="form-label">Last Name</label>
            </div>
          </div>
        </div>
        
        <div class="form-group" id="email-group">
          <input type="email" class="form-control" id="email" name="email" placeholder=" " required>
          <label for="email" class="form-label">Email Address</label>
        </div>
        
        <div class="form-group" id="phone-group">
          <input type="tel" class="form-control" id="phone" name="phone" placeholder=" " required>
          <label for="phone" class="form-label">Phone Number</label>
        </div>
        
        <div class="form-group" id="password-group">
          <input type="password" class="form-control" id="password" name="password" placeholder=" " required>
          <label for="password" class="form-label">Password</label>
          <div class="password-strength">
            <div class="password-strength-meter" id="password-meter"></div>
          </div>
          <div class="password-strength-text" id="password-text"></div>
        </div>
        
        <div class="form-group" id="confirm-password-group">
          <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder=" " required>
          <label for="confirm_password" class="form-label">Confirm Password</label>
        </div>
        
        <div class="form-group" id="terms-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
            <label class="form-check-label" for="terms">
              I agree to the <a href="terms.php" target="_blank">Terms of Service</a> and <a href="privacy.php" target="_blank">Privacy Policy</a>
            </label>
          </div>
        </div>
        
        <div class="form-group" id="submit-group">
          <button type="submit" class="btn btn-primary w-100">Create Account</button>
        </div>
        
        <div class="auth-links" id="links-group">
          <p class="mb-0">Already have an account? <a href="login.php">Sign In</a></p>
        </div>
      </form>
    </div>
  </div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const welcomePrompt = document.getElementById('welcome-prompt');
      const signupForm = document.getElementById('signup-form');
      const formGroups = document.querySelectorAll('.form-group');
      const errorAlert = document.getElementById('error-alert');
      const passwordInput = document.getElementById('password');
      const passwordMeter = document.getElementById('password-meter');
      const passwordText = document.getElementById('password-text');
      const confirmPasswordInput = document.getElementById('confirm_password');
      const authLinks = document.getElementById('links-group');
      
      // Hide all form groups initially
      formGroups.forEach(group => {
        group.style.display = 'none';
      });
      
      // Hide auth links initially
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
          
          // Show form groups one by one with staggered timing
          formGroups.forEach((group, index) => {
            group.style.display = 'block';
            
            setTimeout(() => {
              group.classList.add('visible');
              
              // Add active class temporarily for highlight animation
              group.classList.add('active');
              setTimeout(() => {
                group.classList.remove('active');
              }, 2000);
              
              // If it's the last form group, show auth links after it
              if (index === formGroups.length - 1) {
                setTimeout(() => {
                  authLinks.style.display = 'block';
                  setTimeout(() => {
                    authLinks.classList.add('visible');
                  }, 300);
                }, 300);
              }
              
              // Focus on the first input field
              if (index === 0) {
                const input = group.querySelector('input');
                if (input) input.focus();
              }
            }, 150 * index);
          });
        }, 500);
      }
      
      // Enhanced password strength checker with animations
      passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        let strengthText = '';
        
        if (password.length > 0) {
          // Length check
          if (password.length >= 8) strength += 25;
          
          // Lowercase check
          if (password.match(/[a-z]/)) strength += 25;
          
          // Uppercase check
          if (password.match(/[A-Z]/)) strength += 25;
          
          // Number or special char check
          if (password.match(/[0-9]/) || password.match(/[^a-zA-Z0-9]/)) strength += 25;
          
          // Set meter width and color with animation
          passwordMeter.style.width = strength + '%';
          
          if (strength <= 25) {
            passwordMeter.style.backgroundColor = '#dc3545'; // Weak - Red
            strengthText = 'Weak';
            passwordText.style.color = '#dc3545';
          } else if (strength <= 50) {
            passwordMeter.style.backgroundColor = '#ffc107'; // Fair - Yellow
            strengthText = 'Fair';
            passwordText.style.color = '#ffc107';
          } else if (strength <= 75) {
            passwordMeter.style.backgroundColor = '#17a2b8'; // Good - Blue
            strengthText = 'Good';
            passwordText.style.color = '#17a2b8';
          } else {
            passwordMeter.style.backgroundColor = '#28a745'; // Strong - Green
            strengthText = 'Strong';
            passwordText.style.color = '#28a745';
          }
          
          // Animate the strength text
          passwordText.textContent = '';
          setTimeout(() => {
            passwordText.textContent = strengthText;
            passwordText.style.opacity = 0;
            setTimeout(() => {
              passwordText.style.opacity = 1;
            }, 100);
          }, 200);
        } else {
          passwordMeter.style.width = '0%';
          passwordText.textContent = '';
        }
      });
      
      // Enhanced confirm password validation with visual feedback
      confirmPasswordInput.addEventListener('input', function() {
        const confirmPasswordGroup = document.getElementById('confirm-password-group');
        
        if (this.value !== passwordInput.value) {
          this.setCustomValidity('Passwords do not match');
          confirmPasswordGroup.style.borderColor = '#dc3545';
          this.style.borderColor = '#dc3545';
          this.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
        } else {
          this.setCustomValidity('');
          confirmPasswordGroup.style.borderColor = '#28a745';
          this.style.borderColor = '#28a745';
          this.style.boxShadow = '0 0 0 0.2rem rgba(40, 167, 69, 0.25)';
        }
      });
      
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