<?php

if (!empty(isset($_GET['data']))) {
  session_start();
  include_once './../config/Data.php';
  $_SESSION['currentPage'];

  $data = new Data();
  $connect = $data->connect();
  try {
    $text = filter_input(INPUT_GET, 'data', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sql = "SELECT accounts.account_number, balance, CONCAT( first_name, ' ' , last_name) as fullName, age,  gender, CONCAT(address, ', ' , city, ', ' ,  state.name) as address,  employer,  email
    FROM accounts INNER JOIN state on accounts.state = state.state  where
    accounts.account_number LIKE '%$text%' OR
    accounts.balance LIKE '%$text%' OR
    accounts.first_name LIKE '%$text%' OR
    accounts.last_name LIKE '%$text%' OR
    accounts.age LIKE '%$text%' OR
    accounts.gender LIKE '%$text%' OR
    accounts.address LIKE '%$text%' OR
    accounts.email LIKE '%$text%' OR
    accounts.employer LIKE '%$text%' OR
    accounts.city LIKE '%$text%' OR
    state.name LIKE '%$text%' AND
    accounts.state = state.state
    ORDER BY accounts.account_number
   ";
    echo $data->readData($sql)[0];
  } catch (PDOException $e) {
    var_dump("SEARCH ERROR: " . $e->getMessage());
  }
} else {
  $sql = "SELECT accounts.account_number, address, age, balance, city, email, employer, 
      first_name, last_name, gender, state.name FROM `accounts`, `state` 
      WHERE accounts.state = state.state ORDER BY `accounts`.`account_number`";
  echo $data->readData($sql);
}
?>