<?php
	$host='localhost';
	$database='movies';
	$user='root';
	$password='root';

	session_start();
	$link=mysqli_connect($host,$user,$password,$database);
	if(!$link)
		die('Соединения нет!');
	if( isset( $_POST['change_but'] ) ) {
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];

		if (!$password1 || !$password2) {
			echo "<script>alert(\"Заполните все поля\");</script >";
		}
		else if ($password1 != $password2){
			echo "<script>alert(\"Пароли не совпадают\");</script >";
		}
		else {
			$sql = "UPDATE user SET password = '".$password1."' WHERE login = '".$_SESSION['login']."'";
			if ($mysql = mysqli_query($link, $sql))
			{
				header ('Location: index.php');
			}
			else
				echo "error";
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
			<div class="log" >
				<p class="log">Новый пароль</p>
				<input type="password" size="50" name="password1" id="password">
			</div>
			<div class="log" >
				<p class="log">Повторите пароль</p>
				<input type="password" size="50" name="password2" id="password">
			</div>
			<div class="log">
				<button class="log_button" type="submit" name="change_but">Сменить пароль</button>
			</div>
		</form>
	</div>
	<div id="footer">Kino 2020</div>
	</body>
	</html>

