<?php
session_start();
$mysqli = new mysqli("", "", "", "");

$art_in_page = intval($_POST["art_in_page"]);

if ($art_in_page != 0) {
    $query = "UPDATE `users` SET `art_in_page` = '$art_in_page' WHERE `users`.`id` = $_SESSION[id]";
    $result = $mysqli->query($query);
    if ($result === TRUE) {
        echo "Настройки успешно обновлены.";
    } else {
        echo "Возникла ошибка.";
    }
}
?>