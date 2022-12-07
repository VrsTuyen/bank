<?php
$account_number = $_GET['account_number'];
$fullName = '';
$age = '';
$gender = '';
$address = '';
$employer = '';
$email = '';
$city = '';
$state = '';
$balance = '';
$sql = 'SELECT * FROM accounts WHERE account_number = ' . $account_number . ';';

$statement = $connect->prepare($sql);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
  $fullName = $row['first_name'] . ' ' . $row['last_name'];
  $age = $row['age'];
  $gender = $row['gender'] == 'M' ? 'Male' : 'Female';
  $address = $row['address'];
  $employer = $row['employer'];
  $email = $row['email'];
  $city = $row['city'];
  $state = $row['state'];
  $balance = $row['balance'];
}

?>