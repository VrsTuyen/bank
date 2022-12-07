<?php
session_start();
include_once './config/Data.php';
include_once './handle/role.php';

$db = new Data();
$connect = $db->connect();

include_once './handle/login.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@200;300;400;500;600;700;800;900;1000&display=swap"
    rel="stylesheet">
  <title>Login</title>
</head>

<body>
  <div class="overlay active">
    <div class="overlay-body">
      <div class="overlay-body-login overlay-form active">
        <h2 class="h2-heading">Login</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="overlay-body-wrap">
            <div class="overlay-body-wrap-input">
              <label for="login_email">Email</label>
              <input type="text" name="login_email"
                value="<?= isset($_POST['login_email']) ? $_POST['login_email'] : '' ?>" id="login_email">
            </div>
          </div>
          <div class="overlay-body-wrap">
            <div class="overlay-body-wrap-input">
              <label for="login_password">Password</label>
              <input type="password" name="login_password"
                value="<?= isset($_POST['login_password']) ? $_POST['login_password'] : '' ?>" id="login_password">
            </div>
          </div>
          <div class="overlay-body-wrap">
            <p class="overlay-body-wrap-validate">
              <?= $validate ?>
            </p>
          </div>
          <div class="overlay-body-wrap">
            <div class="overlay-body-wrap-check">
              <div class="overlay-body-wrap-check-remember">
                <input type="checkbox" id="login-remember" name="login-remember">
                <label for="login-remember">Remember Me</label>
              </div>

              <div class="overlay-body-form-wrap-forgot">
                <a href="#" class="overlay-body-form-link">Forgot your password?</a>
              </div>
            </div>
          </div>
          <div class="overlay-body-wrap-button">
            <input type="submit" name="submit_login" value="Login">
          </div>
          <div class="overlay-body-wrap">
            <div class="overlay-body-wrap-paragraph">
              <!-- <p>Don't have an account?<a class="overlay-body-form-link link-tab">Sign up for free</a></p> -->
            </div>
          </div>
        </form>
      </div>
      <div class="overlay-body-register overlay-form">
        <h2 class="h2-heading">Sign up</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="overlay-body-wrap">
            <div class="overlay-body-wrap-input">
              <label for="register-username">Username</label>
              <input type="text" name="register-username" id="register-username">
            </div>
          </div>
          <div class="overlay-body-wrap">
            <div class="overlay-body-wrap-input">
              <label for="register-phone">Phone Number</label>
              <input type="tel" name="register-phone" id="register-phone">
            </div>
          </div>
          <div class="overlay-body-wrap">
            <div class="overlay-body-wrap-input">
              <label for="register-email">Email</label>
              <input type="email" name="register-email" id="register-email">
            </div>
          </div>
          <div class="overlay-body-wrap">
            <div class="overlay-body-wrap-input">
              <label for="register-password">Password</label>
              <input type="password" name="register-password" id="register-password">
            </div>
          </div>
          <div class="overlay-body-wrap">
            <div class="overlay-body-wrap-input">
              <label for="register-repeat-password">Confirm Password</label>
              <input type="password" name="register-repeat-password" id="register-repeat-password">
            </div>
          </div>
          <div class="overlay-body-wrap-button">
            <input type="submit" name="register-submit" value="Create account">
          </div>
          <div class="overlay-body-wrap">
            <p class="overlay-body-wrap-paragraph">Already have an account? <a
                class="overlay-body-form-link link-tab">Log in</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="./assets/js/main.js"></script>

</body>

</html>