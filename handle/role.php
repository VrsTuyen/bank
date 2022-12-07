<?php
include_once './config/Data.php';

function getRole($email)
{
  $db = new Data();
  $connect = $db->connect();
  $sql = "SELECT *  FROM user,user_role WHERE user.userID = user_role.userID AND user.email = '$email' and user_role.roleID = 0";
  $statement = $connect->prepare($sql);
  $statement->execute();
  $statement->fetchAll(PDO::FETCH_ASSOC);
  $role = $statement->rowCount();
  return $role > 0 ? true : false;
}

function getPermissions($email)
{
  $permission = array();
  $db = new Data();
  $connect = $db->connect();
  $sql = "SELECT permission.permissionType FROM user INNER JOIN user_role on (user.userID = user_role.userID) INNER JOIN roles on (user_role.roleID = roles.roles) INNER JOIN role_permission on (roles.roles = role_permission.roleID) INNER JOIN permission on (role_permission.permissionID = permission.permissionID) WHERE user.email = '$email';";
  $statement = $connect->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $permission[] = $row['permissionType'];
  }
  return $permission;
}
?>