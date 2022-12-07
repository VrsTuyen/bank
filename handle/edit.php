<?php
include_once './../config/Data.php';
$db = new Data();
$connect = $db->connect();

$account_number = filter_input(INPUT_POST, 'info-account_number', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$full_name = filter_input(INPUT_POST, 'info-full_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$full_name = explode(" ", $full_name);
$first_name = $full_name[0];
$last_name = $full_name[1];
$balance = filter_input(INPUT_POST, 'info-balance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$gender = filter_input(INPUT_POST, 'info-gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'info-address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$city = filter_input(INPUT_POST, 'info-city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$state = filter_input(INPUT_POST, 'info-state', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$employer = filter_input(INPUT_POST, 'info-employer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'info-email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$age = filter_input(INPUT_POST, 'info-age', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// echo "$state";
try {
  $sql = "UPDATE accounts SET
    balance = :balance,
    first_name = :first_name,
    last_name = :last_name,
    age = :age,
    gender = :gender,
    address = :address,
    employer = :employer,
    email =:email,
    city = :city,
    state = :state
    WHERE account_number = :account_number";

  $connect->beginTransaction();
  $statement = $connect->prepare($sql);

  $statement->bindParam(':balance', $balance);
  $statement->bindParam(':first_name', $first_name);
  $statement->bindParam(':last_name', $last_name);
  $statement->bindParam(':age', $age);
  $statement->bindParam(':gender', $gender);
  $statement->bindParam(':address', $address);
  $statement->bindParam(':employer', $employer);
  $statement->bindParam(':email', $email);
  $statement->bindParam(':city', $city);
  $statement->bindParam(':state', $state);
  $statement->bindParam(':account_number', $account_number);

  $result = $statement->execute();
  $connect->commit();
  header('location: ./../index.php');
} catch (PDOException $e) {
  $connect->rollBack();
  echo ('ERROR: ' . $e->getMessage());

}

?>