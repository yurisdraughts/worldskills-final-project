<main>
    <div class="articles">
<?php
// удаление статьи
if(isset($_POST["del_article_button"])) {
    $id_art = $_POST["del_article_button"];
    $id_user = $_SESSION["id"];

    $sql = "SELECT COUNT(*) AS `art_count` FROM `articles` WHERE `id` = $id_art AND `id_user` = $id_user";
	$result = $mysqli->query($sql);
	$art_count = $result->fetch_object()->art_count;
    
    if (($art_count == 1) OR $id_user == 1) {
        $sql = "DELETE FROM `articles` WHERE `articles`.`id` = {$_POST["del_article_button"]}";
        $result = $mysqli->query($sql);
    }
}

//получаем общее число статей
if (isset($_GET["author"])) {
    $result = $mysqli->query("SELECT COUNT(*) AS `art_count` FROM `articles` WHERE `id_user` = (
        SELECT `id` FROM `users` WHERE `login` = '$_GET[author]'
    )");
} else if (isset($_GET["tag"])) {
    $tag = urldecode($_GET["tag"]);
    $regexp = ",\n*$tag\n*,";
    $result = $mysqli->query("SELECT COUNT(*) AS `art_count` FROM `articles` WHERE `tag` REGEXP '$tag'");
} else {
    $result = $mysqli->query("SELECT COUNT(*) AS `art_count` FROM `articles`");
}
$article_max = $result->fetch_object()->art_count;
$result->free();

//получаем кол-во статей на странице
if (isset($_SESSION["id"])) {
    $art_in_page = $mysqli->query("SELECT `art_in_page` FROM `users` WHERE `id` = $_SESSION[id]")
        ->fetch_assoc()['art_in_page'];
} else $art_in_page = 3;

//расчет кол-ва страниц
$page_max = ceil($article_max / $art_in_page);
if ($page >= $page_max) $page = $page_max - 1;
$article_start = $art_in_page * $page;
$article_finish = $art_in_page + $art_in_page * $page;

if (isset($_GET["author"])) {
    $result = $mysqli->query("SELECT * FROM `articles` WHERE `id_user` = (
        SELECT `id` FROM `users` WHERE `login` = '$_GET[author]'
    ) LIMIT $article_start , $article_finish");
} else if (isset($_GET["tag"])) {
    $tag = urldecode($_GET["tag"]);
    $regexp = ",\n*$tag\n*,";
    $result = $mysqli->query("SELECT * FROM `articles` WHERE `tag` REGEXP '$tag' LIMIT $article_start , $article_finish");
} else {
    $result = $mysqli->query("SELECT * FROM `articles` LIMIT $article_start , $article_finish");
}

if (gettype($result) != "boolean") {
    // выводим статьи на экран
    for ($i = $article_start; $i < $article_finish; $i++) {
        // if ($i >= $article_max) break;
    	$article = $result->fetch_assoc();
    	$res_user = $mysqli->query("SELECT `login` FROM `users` WHERE `id` = $article[id_user]");
        if (gettype($res_user) == "boolean") break;
    	$user = $res_user->fetch_assoc();
    	$art_id = $i;
        $current_page = $page + 1;

    	// добавляем кнопки удаления и редактирования статьи
        if (isset($_SESSION["id"]) and ($_SESSION["id"] == $article["id_user"] or $_SESSION["id"] == 1)) $buttons = "<form class=article_form>
            <button type=submit class='article_button del_article' formmethod=post name=del_article_button value=$article[id]>
                Удалить
            </button>
            <a class=article_button href=index.php?p=article_edit&article_id=$article[id]&page=$current_page>
                Редактировать
            </a>
        </form>";
    	else $buttons = "";

        $article_datetime = explode(" ", $article['datetime']);

        $article_tags = explode(",", $article['tag']);
        foreach ($article_tags as &$tag) {
            $tag = trim($tag);
            $tag_url = urlencode($tag);
            $tag = "<a href=index.php?tag=$tag_url>{$tag}</a>";
        }
        $article_tags = implode(", ", $article_tags);

        $articles = "<article id=article_{$article['id']}>
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
                    <div class=author><em>Автор:</em> <strong><a href=index.php?author=$user[login]>{$user['login']}</a></strong></div>
                    <div class=tags><em>Тэги:</em> <strong>{$article_tags}</strong></div>
                </div>
                <div class=buttons>
                    $buttons
                    <a class=article_button href=index.php?p=article_view&article_id=$article[id]&page=$current_page>Открыть статью</a>
                </div>
            </footer>
        </article>";
    	echo $articles;
    	if ($i == $article_max) break;
    }

    //вывод списка страниц со статьями
    echo "<div id=links>";
    if ($page_max > 1) {
        if (isset($_GET["author"])) {
            $dest = "&author=$_GET[author]";
        } else if (isset($_GET["tag"])) {
            $tag = urlencode($_GET['tag']);
            $dest = "&tag=$tag";
        } else {
            $dest = "";
        }
    	for($i = 1; $i <= $page_max; $i++) {
            if ($i == $page + 1) echo "<a class=main_link href=index.php?p=main$dest&page=$i>$i</a>";
            else echo "<a href=index.php?p=main$dest&page=$i>$i</a>";
        }
    }
}
echo "</div>";

if (isset($_GET["author"]) or isset($_GET["tag"])) {
    echo '<a href=index.php?p=main class="article_button back_button">Вернуться ко всем статьям</a>';
}
?>
<? if (isset($_SESSION["id"])) { ?>
<button class="article_button" id="add_article_button" type="button" onclick="newArticle()">Добавить статью</button>

<form action="scripts/add_post.php" id="add_article" name="my_form" style="display: none;">
    <span>Заголовок:</span>
    <div><input type="text" name="title"></div>

    <span>Текст:</span>
    <div><textarea type="text" name="content"></textarea></div>

    <span>Тэги:</span>
    <div><input type="text" name="tags"></div>

    <input type="hidden" name="last_page" value="<?
        if (ceil(($article_max + 1) / $art_in_page) != $page_max) echo $page_max + 1;
        else echo $page_max;
    ?>">
    
    <div class="buttons">
        <button class="article_button" type="submit" onclick="closeForm()">Добавить статью</button>
        <button class="article_button" type="button" onclick="cancelForm()">Отмена</button>
    </div>
</form>
<? } ?>
    </div>
</main>