<?php
include './../config/Data.php';
$data = new Data();
$connect = $data->Connect();

$strURI = $_SERVER['REQUEST_URI'];
$strURI = explode("/", $strURI);
$strURI = end($strURI);
// $strURI .= "?new-user";

$username = filter_input(INPUT_POST, 'info-username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$phone = filter_input(INPUT_POST, 'info-phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'info-email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'info-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = hash("SHA256", $password);
$repeatPassword = filter_input(INPUT_POST, 'info-password-repeat', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$repeatPassword = hash("SHA256", $repeatPassword);
$role = filter_input(INPUT_POST, 'info-role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$country = filter_input(INPUT_POST, 'info-country', FILTER_SANITIZE_FULL_SPECIAL_CHARS);



$_SESSION['add-new-user'] = [
  'username' => $username,
  'password' => $password,
  'phone' => $phone,
  'email' => $email,
  'role' => $role,
  'country' => $country,
  'repeatPassword' => $repeatPassword
];

if (
  empty($username)
  || empty($phone)
  || empty($email)
  || empty($password)
  || empty($repeatPassword)
  || empty($country)
) {
  $validate = "Try again";
} else {
  if ($password != $repeatPassword) {
    $validate = "Try again";
  } else {
    $connect->beginTransaction();
    try {
      $sql = "SELECT * FROM user WHERE email = '$email'";
      $statement = $connect->prepare($sql);
      $statement->execute();
      $statement->fetchAll();
      $count = $statement->rowCount();
      if ($count > 0) {
        header('location: ./../user.php?message=Account is already');
        return;
      }
      $sql = "INSERT INTO `user`(`userID`,`username`, `phone`, `email`, `password`, `country`) 
        VALUES (NULL, :username, :phone, :email, :password, :country)";

      $statement = $connect->prepare($sql);
      $statement->bindParam(':username', $username, PDO::PARAM_STR);
      $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
      $statement->bindParam(':email', $email, PDO::PARAM_STR);
      $statement->bindParam(':password', $password, PDO::PARAM_STR);
      // $statement->bindParam(':roles', $role, PDO::PARAM_INT);
      $statement->bindParam(':country', $country, PDO::PARAM_STR);
      $query1 = $statement->execute();

      $id = $connect->lastInsertId();

      $sql = "INSERT INTO `user_role` (`userRoleID`, `userID`, `roleID`) VALUES (NULL, '$id', '$role');";
      $statement = $connect->prepare($sql);

      $query2 = $statement->execute();

      if ($query1 && $query2) {
        $validate = null;
        $strURI = null;
        $connect->commit();
        header('location: ./../user.php?message=Done');
      } else {
        header('location: ./../user.php?message=Error try again');
      }
    } catch (PDOException $e) {
      $connect->rollBack();
      echo "ERROR: " . $e->getMessage();
    }
  }
}


?>