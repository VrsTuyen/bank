<?php
if (isset($_POST['submit'])) {

  $is_admin = getRole($_SESSION['account']);
  if (!$is_admin) {
    header('location: index.php');
  }

  $userName = filter_input(INPUT_POST, 'info-username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $phone = filter_input(INPUT_POST, 'info-phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_input(INPUT_POST, 'info-email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, 'info-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $role = filter_input(INPUT_POST, 'info-role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $country = filter_input(INPUT_POST, 'info-country', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if (empty($userName)) {
    $validate = "Enter your Username";
  } else {
    try {
      $sql = "UPDATE user SET username = :userName, phone = :phone, password = :password , roles = :role , country = :country WHERE  email = :email";
      $statement = $connect->prepare($sql);
      $statement->bindParam(':userName', $userName);
      $statement->bindParam(':phone', $phone);
      $statement->bindParam(':password', $password);
      $statement->bindParam(':role', $role);
      $statement->bindParam(':country', $country);
      $statement->bindParam(':email', $email);
      if ($statement->execute()) {
        header("Location: user.php");
      } else {
        $validate = "ERROR";
      }
    } catch (PDOException $e) {
      echo "ERROR: " . $e->getMessage();
    }
  }
}

?>