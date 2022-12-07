<?php
session_start();
include_once('../config/Data.php');
include_once('role.php');
$is_admin = getRole($_SESSION['account']);

if ($is_admin) {
  $data = new Data();
  $connect = $data->connect();

  $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $sql = "DELETE FROM `user` WHERE `user`.`email` = '$email';";

  try {
    $statement = $connect->prepare($sql);
    $statement->execute();
    header('location: ../user.php');
  } catch (PDOException $e) {
    echo "DELETE ERROR: " . $e->getMessage();
  }

} else {
  header('location: ../index.php');
}
?>