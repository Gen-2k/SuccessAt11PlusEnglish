<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Success At 11 Plus English" />
  <title>Success At 11 Plus English | Login</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:wght@700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">

  <!-- Toastr -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />


   <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/favicons/favicon.ico">

  <style>
    :root {
      --theme-blue: #1e40af;
      --theme-blue-dark: #1e3a8a;
      --theme-gold: #f59e0b;
      --theme-gold-dark: #d97706;
      --body-bg: #f8f9fa;
      --card-bg: #ffffff;
    }
    
    body {
      background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
      font-family: 'Varela Round', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      margin: 0;
      padding: 0;
    }
    
    h1, h2, h3, h4, h5, h6 {
      font-family: 'Source Serif Pro', serif;
    }
    
    .login-container {
      flex: 1;
      display: flex;
      align-items: stretch;
      padding: 0;
      min-height: calc(100vh - 80px); /* Subtract navbar height */
    }
    
    .login-card {
      background: var(--card-bg);
      border-radius: 0;
      overflow: hidden;
      box-shadow: 0 25px 60px rgba(30, 64, 175, 0.15);
      border: none;
      min-height: 100vh;
      margin: 0;
    }
    
    .login-card .row {
      height: 100%;
      min-height: 100vh;
    }
    
    .login-card .col-lg-6 {
      display: flex;
      flex-direction: column;
    }
    
    .login-image {
      background: linear-gradient(135deg, var(--theme-blue) 0%, var(--theme-blue-dark) 100%);
      padding: 2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100%;
    }
    
    .login-image img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
    }
    
    .login-form {
      padding: 3rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      min-height: 100%;
    }
    
    .login-header {
      margin-bottom: 2rem;
      text-align: center;
    }
    
    .login-header h1 {
      color: var(--theme-blue);
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    
    .login-header p {
      color: #6c757d;
      font-size: 1rem;
      margin-bottom: 0;
    }
    
    .form-label {
      font-weight: 600;
      color: #495057;
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
    }
    
    .form-label i {
      margin-right: 0.5rem;
      color: var(--theme-blue);
      width: 18px;
    }
    
    .form-control {
      padding: 0.875rem 1rem;
      font-size: 1rem;
      border-radius: 12px;
      border: 2px solid #e9ecef;
      transition: all 0.3s ease;
      background-color: #f8f9fa;
      margin-bottom: 1rem;
    }
    
    .form-control:focus {
      border-color: var(--theme-blue);
      box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
      background-color: #fff;
    }
    
    .password-toggle {
      position: relative;
    }
    
    .password-toggle-btn {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #6c757d;
      cursor: pointer;
      padding: 0;
      z-index: 10;
    }
    
    .password-toggle-btn:hover {
      color: var(--theme-blue);
    }
    
    .password-toggle-btn:focus {
      outline: 2px solid var(--theme-blue);
      outline-offset: 2px;
      border-radius: 3px;
    }
    
    .form-control.is-valid {
      border-color: #198754;
      background-color: #fff;
    }
    
    .form-control.is-invalid {
      border-color: #dc3545;
      background-color: #fff;
    }
    
    .invalid-feedback {
      display: block;
      color: #dc3545;
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }
    
    .valid-feedback {
      display: block;
      color: #198754;
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }
    
    .btn-login {
      background: linear-gradient(135deg, var(--theme-blue), var(--theme-blue-dark));
      color: white;
      font-weight: 600;
      font-size: 1.1rem;
      padding: 0.875rem 2rem;
      border-radius: 12px;
      border: none;
      width: 100%;
      transition: all 0.3s ease;
      margin-top: 1rem;
      box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
    }
    
    .btn-login:hover {
      background: linear-gradient(135deg, var(--theme-blue-dark), var(--theme-blue));
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
    }
    
    .btn-login:active {
      transform: translateY(0);
    }
    
    .btn-login:disabled {
      opacity: 0.7;
      cursor: not-allowed;
      transform: none;
    }
    
    /* Toastr Customization */
    #toast-container > .toast-error {
      background-color: #dc3545;
      box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }
    
    #toast-container > .toast-success {
      background-color: #198754;
      box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
    }
    
    #toast-container > .toast-info {
      background-color: var(--theme-blue);
      box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
    }
    
    #toast-container > .toast {
      border-radius: 8px;
      font-family: 'Varela Round', sans-serif;
    }
    
    @media (max-width: 768px) {
      .login-container {
        min-height: calc(100vh - 60px); /* Adjust for smaller navbar */
      }
      
      .login-card {
        margin: 0;
        border-radius: 0;
        min-height: 100vh;
      }
      
      .login-form {
        padding: 2rem 1.5rem;
      }
      
      .login-image {
        min-height: 300px;
        padding: 1.5rem;
      }
      
      .login-header h1 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>

<body>
  <div class="sticky-sm-top">
    <?php include('navbar2.php') ?>
  </div>
  
  <div class="login-container">
    <div class="container-fluid px-0">
      <div class="login-card">
        <div class="row g-0">
          <div class="col-lg-6">
            <div class="login-image">
              <img src="assets/images/loginanimi.png" alt="Login Illustration" />
            </div>
          </div>
          
          <div class="col-lg-6">
            <div class="login-form">
              <div class="login-header">
                <h1>Welcome Back!</h1>
                <p>Sign in to access your Success At 11 Plus English account</p>
              </div>
              
              <!-- Error/Success Messages -->
              <div id="loginMessages"></div>
              
              <?php
              if (isset($_SESSION['status_code'])) {
                echo "<script type='text/javascript'>
                  document.addEventListener('DOMContentLoaded', function() {
                    toastr.error('".$_SESSION['status_code']."');
                  });
                </script>";
                unset($_SESSION['status_code']);
              }
              ?>
              
              <form action="loginaction.php" method="POST" autocomplete="off" id="loginForm" class="needs-validation" novalidate>
                <div class="mb-3">
                  <label for="email" class="form-label">
                    <i class="bi bi-envelope-fill"></i>Email Address
                  </label>
                  <input type="email" id="email" name="username" class="form-control" placeholder="Enter your email" required />
                  <div class="invalid-feedback">
                    Please enter a valid email address
                  </div>
                </div>

                <div class="mb-3">
                  <label for="pass" class="form-label">
                    <i class="bi bi-lock-fill"></i>Password
                  </label>
                  <div class="password-toggle">
                    <input type="password" id="pass" name="password" class="form-control" placeholder="Enter your password" required />
                    <button type="button" class="password-toggle-btn" id="togglePassword">
                      <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                  </div>
                  <div class="invalid-feedback">
                    Please enter your password
                  </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="rememberMe" />
                    <label class="form-check-label" for="rememberMe">
                      Remember Me
                    </label>
                  </div>
                  <a href="ForgotPassword.php" class="forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" name="submit" class="btn-login" id="loginBtn">
                  <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include('footer.php') ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
 <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Configure toastr options
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };

    const userId = document.getElementById('email');
    const password = document.getElementById('pass');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const toggleIcon = document.getElementById('toggleIcon');
    const rememberMe = document.getElementById('rememberMe');
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');

    // Clear any validation states on page load
    clearValidation(userId);
    clearValidation(password);

    // Form validation functions
    function validateField(field) {
      const value = field.value.trim();
      let isValid = true;
      
      if (field.id === 'email') {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (value === '') {
          isValid = false;
          showFieldError(field, 'Email address is required');
        } else if (!emailPattern.test(value)) {
          isValid = false;
          showFieldError(field, 'Please enter a valid email address');
        } else {
          showFieldSuccess(field);
        }
      } else if (field.id === 'pass') {
        if (value === '') {
          isValid = false;
          showFieldError(field, 'Password is required');
        } else if (value.length < 3) {
          isValid = false;
          showFieldError(field, 'Password must be at least 3 characters');
        } else {
          showFieldSuccess(field);
        }
      }
      
      return isValid;
    }

    function showFieldError(field, message) {
      field.classList.remove('is-valid');
      field.classList.add('is-invalid');
      const feedback = field.parentNode.querySelector('.invalid-feedback') || field.nextElementSibling;
      if (feedback && feedback.classList.contains('invalid-feedback')) {
        feedback.textContent = message;
      }
    }

    function showFieldSuccess(field) {
      field.classList.remove('is-invalid');
      field.classList.add('is-valid');
    }

    function clearValidation(field) {
      field.classList.remove('is-valid', 'is-invalid');
    }

    function validateForm() {
      const emailValid = validateField(userId);
      const passwordValid = validateField(password);
      return emailValid && passwordValid;
    }

    // Real-time validation
    userId.addEventListener('blur', () => validateField(userId));
    password.addEventListener('blur', () => validateField(password));
    
    userId.addEventListener('input', () => {
      if (userId.classList.contains('is-invalid')) {
        validateField(userId);
      }
    });
    
    password.addEventListener('input', () => {
      if (password.classList.contains('is-invalid')) {
        validateField(password);
      }
    });

    // Form submission with enhanced validation
    loginForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Validate all fields
      if (!validateForm()) {
        // Focus first invalid field
        const firstInvalid = loginForm.querySelector('.is-invalid');
        if (firstInvalid) {
          firstInvalid.focus();
        }
        toastr.error('Please correct the errors before submitting.');
        return false;
      }
      
      // Check if form is already being submitted
      if (loginBtn.disabled) {
        return false;
      }
      
      // Show loading state
      const originalText = loginBtn.innerHTML;
      loginBtn.disabled = true;
      loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Signing In...';
      
      // Submit form after brief delay for UX
      setTimeout(() => {
        // Create a hidden form to submit (prevents double submission)
        const hiddenForm = document.createElement('form');
        hiddenForm.method = 'POST';
        hiddenForm.action = 'loginaction.php';
        hiddenForm.style.display = 'none';
        
        // Add form data
        const usernameInput = document.createElement('input');
        usernameInput.type = 'hidden';
        usernameInput.name = 'username';
        usernameInput.value = userId.value;
        hiddenForm.appendChild(usernameInput);
        
        const passwordInput = document.createElement('input');
        passwordInput.type = 'hidden';
        passwordInput.name = 'password';
        passwordInput.value = password.value;
        hiddenForm.appendChild(passwordInput);
        
        const submitInput = document.createElement('input');
        submitInput.type = 'hidden';
        submitInput.name = 'login_submit'; // changed from 'submit' to 'login_submit'
        submitInput.value = '1';
        hiddenForm.appendChild(submitInput);
        
        document.body.appendChild(hiddenForm);
        hiddenForm.submit();
      }, 500);
    });

    // Toggle password visibility
    togglePasswordBtn.addEventListener('click', () => {
      if (password.type === 'password') {
        password.type = 'text';
        toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
        togglePasswordBtn.setAttribute('aria-label', 'Hide password');
      } else {
        password.type = 'password';
        toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
        togglePasswordBtn.setAttribute('aria-label', 'Show password');
      }
    });

    // Remember me functionality
    let expiryDate = new Date();
    const month = (expiryDate.getMonth() + 2);
    expiryDate.setMonth(month);

    rememberMe.addEventListener('click', () => {
      if (rememberMe.checked && userId.value.trim() !== "" && password.value.trim() !== "") {
        const uName = userId.value;
        const pwd = password.value;
        document.cookie = "username=" + encodeURIComponent(uName) + "; Expires=" + expiryDate + ";path=/Login";
        document.cookie = "password=" + encodeURIComponent(pwd) + "; Expires=" + expiryDate + ";path=/Login";
      }
    });

    function getCookieUserdata() {
      const userEmailId = getCookie('username');
      const userPwd = getCookie('password');

      if (userEmailId) userId.value = userEmailId;
      if (userPwd) password.value = userPwd;
      if (userEmailId && userPwd) rememberMe.checked = true;
    }

    function getCookie(cname) {
      let name = cname + "=";
      let decodedCookie = decodeURIComponent(document.cookie);
      let ca = decodedCookie.split(';');
      for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    // Load saved credentials on page load
    getCookieUserdata();
  });
</script>

</html>