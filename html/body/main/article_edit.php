<main>
    <div class="articles">
        <article>
<?php
if (isset($_GET["article_id"])) { // outer if
    $update = true;

    if (isset($_GET["page"])) $page = $_GET["page"];
    else $update = false;

    if (isset($_GET["article_view"])) $article_view = $_GET["article_view"];
    else $article_view = False;
    
    $article_id = $_GET["article_id"];

    $id_user = $_SESSION["id"];
    $sql = "SELECT COUNT(*) AS `art_count` FROM `articles` WHERE `id` = $article_id AND `id_user` = $id_user";
    $result = $mysqli->query($sql);
    $art_count = $result->fetch_object()->art_count;

    if (($art_count == 1) or $id_user == 1) { // inner if
        if (isset($_POST["title"])) $edit_article["title"] = $_POST["title"];
        else $update = false;

        if (isset($_POST["content"])) {
        	$edit_article["text"] = $_POST["content"];
        	$edit_article["annotation"] = $_POST["content"];
        } else $update = false;

        if (isset($_POST["tags"])) {
        	$edit_article["tags"] = $_POST["tags"];
        } else $update = false;

        if ($update) {
        	$sql = "UPDATE `articles` SET `title` = '$edit_article[title]', `annotation` = '$edit_article[annotation]', `text` = '$edit_article[text]', `tag` = '$edit_article[tags]' WHERE `articles`.`id` = $article_id;";
        	$result = $mysqli->query($sql);

            header("Location: http://myproject/index.php?p=main&page=$page");
        } else {
            $result = $mysqli->query("SELECT * FROM `articles` WHERE `id` = $article_id");
            $article = $result->fetch_assoc();
        }
?>
            <header>
                <h1>Редактировать статью</h1>
            </header>

            <form method="post" action="./index.php?p=article_edit&article_id=<? echo $article_id ?>&page=<? echo $page?>" id="add_article">
                <span>Заголовок:</span>
                <div><input type="text" name="title" value="<? echo $article['title'] ?>"></div>

                <span>Текст:</span>
                <div><textarea type="text" name="content"><? echo $article['text'] ?></textarea></div>

                <span>Тэги:</span>
                <div><input type="text" name="tags" value="<? echo $article['tag'] ?>"></div>

                <div class="buttons">
                    <button class="article_button" type="submit">Добавить статью</button>
                    <a class="article_button" href="./index.php?<?php
                        if ($article_view) echo "p=article_view&article_id=$article_id&page=$page";
                        else echo "p=main&page=" . $page;
                    ?>">Отмена</a>
                </div>
            </form>
<?php
    } else { // inner else begin
?>
            <header>
                <h1>Вы не можете редактировать эту статью!</h1>
            </header>
            <div class="buttons">
                <a class="article_button" href="./index.php?p=main&page=<? echo $page ?>">Вернуться</a>
            </div>
<?php
    } // inner else end
} // outer if end
?>
        </article>
    </div>
</main>