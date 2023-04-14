<?php
$mysqli = new mysqli("", "", "", "");

$user_name = $_POST['user_name'];

$result = $mysqli->query("SELECT count(*) as `user` FROM `users` WHERE `login` = '$user_name';");
$user_count = $result->fetch_object()->user;
$result->free();

// проверим, существует ли пользователь в массиве $existing_users
if ($user_count > 0) {
      echo "yes";
}  else {
      echo "no";
}
?>