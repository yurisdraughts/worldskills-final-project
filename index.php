<!DOCTYPE html>
<html lang="ru">
<?php
// подключаемся к базе данных
$mysqli = new mysqli("", "", "", "");
session_start();

// получаем логин и пароль из формы (POST-запросом)
if (isset($_POST["login_button"]) and $_POST["login_button"] == "Вход") { // если нажата кнопка "Вход"
    if(isset($_POST["login"])) $login = $_POST["login"];
    else $login = "";
    if(isset($_POST["pass"])) $pass=$_POST["pass"];
	else $pass = "";

    // авторизуем пользователя
    $sql = "SELECT `id`, `login`, `art_in_page` FROM `users` WHERE `login` LIKE '$login' AND `password` LIKE '$pass'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
	    $_SESSION = $result->fetch_assoc();
	}
} elseif (isset($_POST["login_button"]) and $_POST["login_button"] == "Выход") { // если нажата кнопка "Выход"
	// заканчиваем сессию
    session_destroy();
	$_SESSION = "";
}

// получаем название раздела сайта или задаем название по умолчанию
if (isset($_GET["p"])) $page_number = $_GET["p"];
else $page_number = "main";

require "html/head.php";
require "html/body.php";
?>
</html>