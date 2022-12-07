<?php
include_once('./../config/Data.php');
$data = new Data();
$connect = $data->connect();

$sql = "DELETE FROM accounts WHERE account_number = " . $_GET['account_number'] . "";

try {
  $statement = $connect->prepare($sql);
  $statement->execute();
  header('location: ../index.php');
} catch (PDOException $e) {
  echo "DELETE ERROR: " . $e->getMessage();
}

?>