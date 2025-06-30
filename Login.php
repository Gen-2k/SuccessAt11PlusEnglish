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
    
    .form-check {
      margin: 1.5rem 0;
    }
    
    .form-check-input:checked {
      background-color: var(--theme-blue);
      border-color: var(--theme-blue);
    }
    
    .form-check-label {
      color: #495057;
      font-weight: 500;
    }
    
    .forgot-link {
      color: var(--theme-blue);
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }
    
    .forgot-link:hover {
      color: var(--theme-blue-dark);
      text-decoration: underline;
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
    
    #toast-container > .toast-error {
      background-color: #dc3545;
    }
    
    #toast-container > .toast-success {
      background-color: #198754;
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

<body onload="getCookieUserdata()">
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
              
              <?php
              if (isset($_SESSION['status_code'])) {
                echo "<script type='text/javascript'>toastr.error('".$_SESSION['status_code']."')</script>";
                unset($_SESSION['status_code']);
              }
              ?>
              
              <form action="loginaction.php" method="POST" autocomplete="off" class="needs-validation" novalidate>
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

                <button type="submit" name="submit" class="btn-login">
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
  <script src="formValidation.js"></script>

</body>
 <script>
  const userId = document.getElementById('email');
  const password = document.getElementById('pass');
  const togglePasswordBtn = document.getElementById('togglePassword');
  const toggleIcon = document.getElementById('toggleIcon');
  const rememberMe = document.getElementById('rememberMe');

  // Toggle password visibility with new button
  togglePasswordBtn.addEventListener('click', () => {
    if (password.type === 'password') {
      password.type = 'text';
      toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
    } else {
      password.type = 'password';
      toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
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
</script>

</html>