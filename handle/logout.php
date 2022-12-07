<?php
session_start();
// if (isset($_SESSION['account']) || isset($_COOKIE['account'])) {
unset($_SESSION['account']);
$_SESSION['account'] = null;
// setcookie('account', '', time() - 3600, '/');
// }
header('location: ./../index.php');

?>