<?php
$validate = '';
if (isset($_SESSION['account'])) {
  header('location: ./index.php');
} else {
  try {

    if (isset($_POST['submit_login'])) {
      $email = filter_input(INPUT_POST, 'login_email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $password = filter_input(INPUT_POST, 'login_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


      if (empty(trim($email))) {
        $validate = 'Please enter a email';
      } elseif (empty(trim($password))) {
        $validate = 'Please enter a password';
      } else {
        $password = hash("SHA256", $password);
        $sql = "SELECT COUNT(*) FROM user WHERE email = :email AND password = :password";

        $statement = $connect->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $password);
        $statement->execute();

        $count = $statement->fetch();
        if (!empty($count[0])) {
          $_SESSION['account'] = $email;
          header('location: ./index.php');
        } else {
          $validate = "These credentials do not match our records.";
        }
      }
    }
  } catch (PDOException $e) {
    $mess = 'Error: ' . $e->getMessage();
  }
}

?>