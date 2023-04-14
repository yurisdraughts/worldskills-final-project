<main>
    <div class="articles">
		<article>
<?php
if (isset($_POST["new_login"])) {
	$login = $_POST["new_login"];

	$sql = "SELECT `login` FROM `users` WHERE `login` LIKE '$login'";
	$result = $mysqli->query($sql);
	if ($result->num_rows > 0) {
		$login = "";
	}
} else $login = "";
	
if (isset($_POST["new_pass"])) $pass = $_POST["new_pass"];
else $pass = "";
if (isset($_POST["new_pass2"])) $pass = $_POST["new_pass2"];
else $pass2 = "";

if ($login != "" and !isset($_SESSION['id'])) {
	$sql = "INSERT INTO `users` (`login`, `password`) VALUES ('$login', '$pass');";
	$mysqli->query($sql);
	echo "<header><h1>Вы зарегистрировали пользователя: $login</h1></header>";

    $sql = "SELECT `id`, `login`, `art_in_page` FROM `users` WHERE `login` LIKE '$login' AND `password` LIKE '$pass'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
	    $_SESSION = $result->fetch_assoc();
	}
} elseif (isset($_SESSION['id'])) {
	echo "<header><h1>Вы уже зарегистрированы!</h1></header>";
} else {
	echo "<header><h1>Форма регистрации:</h1></header>";
?>
        	<form method="post" id="reg_form">
				<p>
					Логин:<br>
					<input id="new_login" type="text" name="new_login" value="<? echo $login ?>">
				</p>
	    		<p>
					Пароль:<br>
					<input id="new_pass" type="password" name="new_pass" value="<? echo $pass ?>">
				</p>
	    		<p>
					Проверка пароля:<br>
					<input id="new_pass2" type="password" name="new_pass2" value="<? echo $pass2 ?>">
				</p>
	    		<button id="reg_button" class="article_button" type="submit" disabled></button>
	    	</form>
<? } ?>
		</article>
    </div>
</main>