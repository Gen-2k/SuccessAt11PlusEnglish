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
  <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

  <!-- toest -->
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" crossorigin="anonymous" />
   <!-- google fonts -->
 <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
  <style>
    .lear_img {
      width: 100%;
      display: flex;
      margin: auto;
    }

    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    form .input_enter {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      box-sizing: border-box;
      border: 1px solid #ccc;
      outline: none;
    }

    form .input_enter:focus {
      border: 1px solid #6e20a7;
    }


    .header {
      color: #6e20a7;

    }

    /* login */
    .box_shad {
      box-shadow: 3px 3px 20px 10px #e5caf7;
      margin-top: 10%;
      align-items: center;
    }
   
   .pwdIcon {
      cursor: pointer;
    }

    .pwdIcon:hover {
      transition: .5s;
      color: #6e20a7;
    }
  </style>
</head>

<body onload="getCookieUserdata()">
  <div class="sticky-sm-top">
    <?php include('navbar2.php') ?>
  </div>
  <div class="container">
    <div class="row box_shad d-flex mt-sm-5 mb-sm-5">
      <div class="col-lg" style="background-color: #fff; padding: 10px">
        <img src="assets/images/loginanimi.png" alt="login" class="lear_img" />
      </div>
      <div class="col-lg" style="background-color: #fff; padding: 10px">
         <div>
          <h1 class="header" style="font-weight: bold;">Welcome to Success At 11 Plus English</h1>
        </div>
        <?php
        if (isset($_SESSION['status_code'])) {

          echo "<script type='text/javascript'>toastr.error('".$_SESSION['status_code']."')</script>";
          unset($_SESSION['status_code']);
        }
        ?>
        <style>
          #toast-container>.toast-error {
            background-color: #FF3333;

          }
        </style>
        <p class="fw-bold">Sign in to start your session</p>
        <form action="loginaction.php" method="POST" autocomplete="off" class="needs-validation" novalidate>
          <label for="email" class="fw-bold"> Email Id</label>
          <input type="email" id="email" name="username" class="input_enter form-control shadow-none" placeholder="Email-id" required />
          <small class="invalid-feedback">
            please enter your email id correctly
          </small>

          <label for="pass" class="fw-bold">Password</label>
           <div class="position-relative">
            <input type="password" id="pass" name="password" class="input_enter form-control shadow-none" placeholder="Password" required />
           
            <div class="text-center">
              <input type="checkbox" name="viewPwd" id="viewPwd" class="form-check-input shadow-none d-none">
              <label for="viewPwd" class="pwdIcon form-check-label user-select-none">
                <i class="fa fa-eye-slash" id="viewPwdIcon"></i> View password
              </label>
            </div>
          </div>
          <small class="invalid-feedback">
            please enter your password correctly
          </small>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="rememberMe" />
            <div class="row"> <label class="form-check-label col-6" for="rememberMe">
                Remember Me

              </label><a href="ForgotPassword" class="col-6" style="text-decoration:none;"><em style="color:#6e20a7;float:right">Forgot Password</em></a></div>

          </div>

          <button type="submit" name="submit" class="btn btn-lg btn-block" style="
            background-color: #6e20a7;
            color: #fff;
            width: 100%;
            margin-top: 25px;
          ">

            <span class="d-flex justify-content-center" name="submit">Login</span>
          </button>
        </form>
      </div>
    </div>
  </div>

  <?php include('footer.php') ?>

  <script src="formValidation.js"></script>

</body>
 <script>
  const userId = document.getElementById('email')
  const password = document.getElementById('pass');
  const viewpassword = document.getElementById('viewPwd');
  const viewPwdIcon = document.getElementById('viewPwdIcon');

  viewpassword.addEventListener('change', () => {
    if (viewpassword.checked == true) {
      viewPwdIcon.classList.replace('fa-eye-slash', 'fa-eye');
      password.type = "text"
    } else {
      viewPwdIcon.classList.replace('fa-eye', 'fa-eye-slash');
      password.type = "password"
    }
  })
  let expiryDate=new Date();
  const month=(expiryDate.getMonth()+2);
  expiryDate.setMonth(month)
  const rememberMe = document.getElementById('rememberMe');
  rememberMe.addEventListener('click', () => {
    if (rememberMe.checked != false) {
      if (!userId.value == " " && !password.value == " ") {
        const uName = userId.value;
        const pwd = password.value;;
        document.cookie = "username=" + encodeURIComponent(uName) + "; Expires=" + expiryDate + ";path=/Login";
        document.cookie = "password=" + encodeURIComponent(pwd) + "; Expires=" + expiryDate + ";path=/Login";
      }

    }
  })

  function getCookieUserdata() {
    const userEmailId = getCookie('username');
    const userPwd = getCookie('password');

    userId.value = userEmailId;
    password.value = userPwd;
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