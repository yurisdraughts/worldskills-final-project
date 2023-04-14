<body>
<? require "html/body/header.php"; ?>

    <div class="container">
<?php
// вставляем центральную часть сайта
switch ($page_number) {
	case "about": require "./html/body/main/about.php"; break;
	case "service": require "./html/body/main/service.php"; break;
	case "portfolio": require "./html/body/main/portfolio.php"; break;
	case "contact": require "./html/body/main/contact.php"; break;
    case "register": require "./html/body/main/register.php"; break;
	case "article_edit": require "./html/body/main/article_edit.php"; break;
	case "article_view": require "./html/body/main/article_view.php"; break;
	default: require "./html/body/main/main.php"; break;
}

include "html/body/aside.php";
?>
    </div>

<? require "html/body/footer.php"; ?>
</body>