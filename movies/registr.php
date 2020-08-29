<?php
	$host='localhost';
	$database='movies';
	$user='root';
	$password='root';

	$link=mysqli_connect($host,$user,$password,$database);
	if(!$link)
		die('Соединения нет!');
	if( isset( $_POST['reg_button'] ) ) {
		$username = $_POST['login'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];

		if (!$username || !$password1 || !$password2) {
			echo "<script>alert(\"Заполните все поля\");</script >";
		}
		else if ($password1 != $password2){
			echo "<script>alert(\"Пароли не совпадают\");</script >";
		}
		else {
			$sql = "SELECT * FROM user WHERE login='$username'";
			$result = mysqli_query($link, $sql);
			$count = mysqli_num_rows($result);

			if($count==0) {
				session_start();
				$sql1 = "SELECT MAX(id) FROM user";
				$result1 = mysqli_query($link, $sql1);
				$res1 = mysqli_fetch_array($result1);
				$new_id = $res1[0] + 1;
				$sql2 = "INSERT INTO user (id, login, password) VALUES ('".$new_id."', '".$username."', '".$password1."')";
				if (mysqli_query($link, $sql2)) {
					$_SESSION['login'] = $username;
					header ('Location: index.php');
				}
				else
					echo "error";
			}
			else{
				echo "<script>alert(\"Этот логин занят, придумайте другой.\");</script >";
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
			<input type="password" size="50" name="password1" id="password">
		</div>
		<div class="log" >
			<p class="log">Повторите пароль</p>
			<input type="password" size="50" name="password2" id="password">
		</div>
		<div class="log">
			<button class="log_button" type="submit" name="reg_button">Зарегистрироваться</button>
		</div>
	</form>
</div>
<div id="footer">Kino 2020</div>
</body>
</html>
