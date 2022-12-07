<?php
include './../config/Data.php';
$data = new Data();
$connect = $data->Connect();

$userName = filter_input(INPUT_POST, 'info-username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$phone = filter_input(INPUT_POST, 'info-phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'info-email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'info-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = hash("SHA256", $password);
$role = filter_input(INPUT_POST, 'info-role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$country = filter_input(INPUT_POST, 'info-country', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$strURI = $_SERVER['REQUEST_URI'];
$strURI = explode("/", $strURI);
$strURI = end($strURI);
$strURI .= "?user-email=" . $email;

if (empty(trim($userName)) || empty(trim($phone) || empty(trim($password)))) {
  $validate = "Try again";
} else {
  try {
    $sql = "UPDATE user SET username = :userName, phone = :phone, password = :password ,
        country = :country WHERE  email = :email AND LAST_INSERT_ID(userID) LIMIT 1";
    $statement = $connect->prepare($sql);
    $statement->bindParam(':userName', $userName);
    $statement->bindParam(':phone', $phone);
    $statement->bindParam(':password', $password);
    // $statement->bindParam(':role', $role);
    $statement->bindParam(':country', $country);
    $statement->bindParam(':email', $email);
    $query1 = $statement->execute();

    $id = $connect->lastInsertId();

    $sql = "SELECT user_role.userRoleID FROM `user_role`, roles, user WHERE user.userID = user_role.userID AND user_role.roleID = roles.roles AND user.userID = $id;";
    $statement = $connect->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    $userID = $result[0];


    $sql = "UPDATE user_role SET userID = $id , roleID = $role WHERE userRoleID = $userID";
    $statement = $connect->prepare($sql);
    $query2 = $statement->execute();

    if ($query1 && $query2) {
      header("Location: user.php");
      $strURI = null;
      $validate = null;
      header('location: ./../user.php?message=Done');
    } else {
      $validate = "ERROR";
      header('location: ./../user.php?message=Error try again');
    }
  } catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
  }
}


?>