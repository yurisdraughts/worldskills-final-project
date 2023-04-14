<main>
    <div class="articles">
<?php
if (isset($_SESSION["id"]) and isset($_POST["del_article_button"]) and isset($_GET["page"])) {
    $id_art = $_POST["del_article_button"];
    $id_user = $_SESSION["id"];
    $page = $_GET["page"];

    $sql = "SELECT COUNT(*) AS `art_count` FROM `articles` WHERE `id` = $id_art AND `id_user` = $id_user";
	$result = $mysqli->query($sql);
	$art_count = $result->fetch_object()->art_count;
    
    if (($art_count == 1) OR $id_user == 1) {
        $sql = "DELETE FROM `articles` WHERE `articles`.`id` = {$_POST["del_article_button"]}";
        $result = $mysqli->query($sql);
    }

    header("Location: http://myproject/index.php?p=main&page=$page");
} elseif (isset($article)) {
    if (isset($_SESSION["id"]) and ($_SESSION["id"] == $article["id_user"] or $_SESSION["id"] == 1)) $buttons = "<form class=article_form>
        <button type=submit class='article_button del_article' formmethod=post name=del_article_button value=$article[id]>
            Удалить
        </button>
        <a class=article_button href=index.php?p=article_edit&article_id=$article_id&page=$page&article_view=True>
            Редактировать
        </a>
    </form>";
    else $buttons = "";

    $article_datetime = explode(" ", $article['datetime']);
    $user_login = $mysqli->query("SELECT `login` FROM `users` WHERE `id` = $article[id_user]")->fetch_assoc()['login'];
    $article_html = "<article id=article_$article_id>
    <header>
        <div class=time>
            <div class=year>{$article_datetime[0]}</div>
            <div class=date>{$article_datetime[1]}</div>
        </div>
        <h1>{$article['title']}</h1>
        <div class=comments>{$article['comments']}</div>
    </header>
    <p>{$article['annotation']}</p>
    <footer>
        <div class=info>
            <div class=author><em>Автор:</em> <strong><a href=index.php?author=$user_login>{$user_login}</a></strong></div>
            <div class=tags><em>Тэги:</em> <strong>{$article['tag']}</strong></div>
        </div>
        <div class=buttons>
            $buttons
            <a class=article_button href='./index.php?p=main&page=$page'>Вернуться</a>
        </div>
    </footer>
    </article>";
    echo $article_html;
} else { ?>
        <article>
            <header>
                <h1>Такой статьи не существует!</h1>
            </header>
        </article>
<?
}
?>
    </div>
</main>