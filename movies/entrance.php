<?php
	$host='localhost';
	$database='movies';
	$user='root';
	$password='root';

	$link=mysqli_connect($host,$user,$password,$database);
	if(!$link)
		die('Соединения нет!');
	if( isset( $_POST['log_button'] ) ) {
		$username = $_POST['login'];
		$password = $_POST['password'];

		if (!$username || !$password) {
			echo "<script>alert(\"Заполните все поля\");</script >";
		}
		else {
			$sql = "SELECT * FROM user WHERE login='$username' and password='$password'";
			$result = mysqli_query($link, $sql);

			$count = mysqli_num_rows($result);

			if($count==1) {
				session_start();
				$_SESSION['login'] = $username;
				header ('Location: index.php');
			}
			else{
				echo "<script>alert(\"Неверный Логин или Пароль\");</script >";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Kino</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="/scripts/script.js"></script>
</head>
<body>
<div id="header">
	<div id="name"><a href="index.php">Kino</a></div>
	<div id="header_right">
	</div>
</div>
<div id="content_log" class="content_log">
	<form id="entrance" method="post" class="content_log">
		<div class="log">
			<p class="log">Логин</p>
			<input type="text" size="50" name="login" id="login">
		</div>
		<div class="log" >
			<p class="log">Пароль</p>
			<input type="password" size="50" name="password" id="password">
		</div>
		<div class="log">
			<button class="log_button" type="submit" name="log_button">Войти</button>
		</div>
	</form>
</div>
<div id="footer">Kino 2020</div>
</body>
</html>
