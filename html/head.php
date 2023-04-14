<?php
if (isset($_GET["article_id"]) and isset($_GET["page"])) {
    $article_id = $_GET["article_id"];
    $page = $_GET["page"];

    $result = $mysqli->query("SELECT * FROM `articles` WHERE `id` = $article_id");
    $article = $result->fetch_assoc();
}

$title;
$my_site = "My 1st site";
$title_separator = " | ";

switch ($page_number) {
	case "about": $title = "About"; break;
	case "service": $title = "Services"; break;
	case "portfolio": $title = "Portfolio"; break;
	case "contact": $title = "Contacts"; break;
    case "register": $title = "Registration"; break;
	case "article_edit": $title = "Edit post " . $article['title']; break;
	case "article_view": $title = $article['title']; break;
	default: $title = ""; break;
}

//получаем номер текущей страницы
if (isset($_GET["page"]) and $_GET["page"] > 1) $page = $_GET['page'] - 1;
else $page = 0;

if (strlen($title) == 0) {
    if (isset($_GET["author"])) {
        $title = $my_site . $title_separator . "Posts by " . $_GET["author"];
    } else if (isset($_GET["tag"])) {
        $title = $my_site . $title_separator . "Posts with tag " . urldecode($_GET["tag"]);
    } else {
        $title = $my_site . ($page == 0 ? "" : ($title_separator . "Page " . ($page + 1)));
    }
} else {
    $title = $my_site .  " | " . $title;
}

echo <<<HEAD
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$title</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon-16x16.png">
    <script defer src="scripts/jquery.js"></script>
    <script defer src="scripts/script.js"></script>
    <script defer src="scripts/ajax_login.js"></script>
    <script defer src="scripts/set_art_in_page.js"></script>
</head>
HEAD;
?>