<?php
if (isset($_POST["last_page"]) and $_POST["last_page"] > 0) $page = $_POST["last_page"];
else $page = 1;

header("Location: http://myproject/index.php?p=main&page=$page");

session_start();

$mysqli = new mysqli("", "", "", "");

if (isset($_POST["title"])) {
	if (isset($_POST["title"]) and $_POST["title"] != "") $new_article["title"] = $_POST["title"];
	else $new_article["title"] = "Нет заголовока!";

	if (isset($_POST["content"]) and $_POST["content"] != "") {
		$new_article["text"] = $_POST["content"];
		$new_article["annotation"] = $_POST["content"];
	} else {
		$new_article["text"] = "Нет текста!";
		$new_article["annotation"] = "Нет текста!";
	}

	if (isset($_POST["tags"])) {
		$new_article["tags"] = $_POST["tags"];
	}

	if (isset($_SESSION["id"])) $id_user = $_SESSION["id"];
	else $id_user = 1;

	// добавление новой статьи в базу данных
	$query = "INSERT INTO `articles` (`id_user`, `title`, `annotation`, `text`, `tag`, `comments`) VALUES ('$id_user', '$new_article[title]', '$new_article[annotation]', '$new_article[text]', '$new_article[tags]', 0)";
	$mysqli->query($query);
}
?>