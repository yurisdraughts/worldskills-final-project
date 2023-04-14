<? if ($_GET["p"] != "register") { ?>
<aside>
    <div class="sections">
        <section>
            <header>
                <h1>Авторизация</h1>
            </header>
<?php
if (isset($_SESSION["id"])) {
    $form = "";
    if ($_GET["p"] == 'main') {
        $settings_button = "<input id=settings class=article_button type=button value='Обновить число постов на странице'>";
    }
    echo "<p>Здравствуй, $_SESSION[login]!</p>
        $settings_button
        <form method=post id=login_form>
            <input class=article_button type=submit name=login_button value=Выход>
        </form>";
} else {
    echo "<form method=post id=login_form>
	        <label>Логин: <input type=text name=login required></label>
	        <label>Пароль: <input type=password name=pass required></label>
	        <p><input class=article_button type=submit name=login_button value=Вход disabled></p>
	    </form>
	    <a class=article_button href=index.php?p=register>Регистрация</a>";
}
?>
        </section>
    </div>
</aside>
<? } ?>