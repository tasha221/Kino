<?php
	session_start();
	$host='localhost';
	$database='movies';
	$user='root';
	$password='root';
	$table='film';

	$link=mysqli_connect($host,$user,$password,$database);
	if(!$link)
		die('Соединения нет!');
	if( isset( $_GET['stop'] ) )
	{
		$_SESSION['login'] = null;
		session_destroy();
	}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Kino</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id="header">
	<div id="name"><a href="index.php">Kino</a></div>
	<div id="header_right">
		<?php
			if(isset($_SESSION['login']) && $_SESSION['login'] != 'admin'){
				echo '
						<div class="wrapper">
						<div id="menu">
							<li id="invis">&nbsp</li>
							<li><a href="myfilm.php">Мои просмотры</a></li>
							<li><a href="recomend.php">Рекомендации</a></li>
							<li><a href="change_pass.php">Сменить пароль</a></li>
							<li><a href="index.php?stop">Выход</a></li>
						</div>
						<button for="menu" id="my_profile">'.$_SESSION['login'].'</button></div>';
			}
			else if (isset($_SESSION['login']) && $_SESSION['login'] = 'admin') {
				echo '
						<div class="wrapper">
						<div id="menu">
							<li id="invis">&nbsp</li>
							<li><a href="add_film.php">Добавить фильм</a></li>
							<li><a href="del_user.php">Удалить</a></li>
							<li><a href="change_pass.php">Сменить пароль</a></li>
							<li><a href="index.php?stop">Выход</a></li>
						</div>
						<button for="menu" id="my_profile">'.$_SESSION['login'].'</button></div>';
			}
			else {
				echo '<button id="registr"><a href="registr.php">Зарегистрироваться</a></button>';
				echo '<button id="enter"><a href="entrance.php">Войти</a></button>';

			}

		?>
	</div>
</div>
<div id="content">

	<?php
		echo '<div id="film_name_one">Мои просмотры</div>';
		$sql_id = "SELECT id FROM user WHERE login = '" . $_SESSION['login'] . "'";
		$sql_myid = mysqli_query($link, $sql_id);
		$myid = mysqli_fetch_array($sql_myid);
		$sql_findwatched = mysqli_query($link, 'SELECT id_film FROM user_film WHERE id ='.$myid[0]);

		while ($res_watched = mysqli_fetch_array($sql_findwatched)) {
			$sql = mysqli_query($link, 'SELECT poster FROM film WHERE id_film ='.$res_watched[0]);
			$sql1 = mysqli_query($link, 'SELECT name FROM film WHERE id_film ='.$res_watched[0]);
			$sqlid = mysqli_query($link, 'SELECT id_film FROM film WHERE id_film ='.$res_watched[0]);
			$result = mysqli_fetch_array($sql);
			$result1 = mysqli_fetch_array($sql1);
			$res_id = mysqli_fetch_array($sqlid);
			echo '<div id="block_film"><a href="film.php?id=' . $res_id[0] . '"><img id="pic" src="' . $result[0] . '" width=200 height=auto/></a>
			<a href="film.php?id=' . $res_id[0] . '"><span id="film_name">' . $result1[0] . '</span></a></div>';

		}
	?>
</div>
<div id="footer">Kino 2020</div>
</body>
</html>