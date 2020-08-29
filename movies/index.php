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
		<form id="content1" method="post">
		<?php
			echo '<div class="wrapper_genre">
						<div id="menu_genre">
							<li id="invis">&nbsp</li>
							<li id="notinvis"><button name="all"><a href="index.php">Все жанры</a></button></li>';
			$sqlgenre = mysqli_query($link, 'SELECT name FROM genre');
			while ($result = mysqli_fetch_array($sqlgenre)) {
				$sqlgid = "SELECT id_genre FROM genre WHERE name = '".$result[0]."'";
				$sqlgenreid = mysqli_query($link, $sqlgid);
				$resultid = mysqli_fetch_array($sqlgenreid);
				echo '<li id="notinvis"><button name="'.$result[0].'"><a href="person.php?id_genreid='.$resultid[0].'">'. $result[0].'</a></button></li>';
			}
			echo '</div>
						<button for="menu_genre" id="choose_genre_button">Все жанры</button></div>';


			$sql = mysqli_query($link, 'SELECT poster FROM film');
			$sql1 = mysqli_query($link, 'SELECT name FROM film');
			$sqlid = mysqli_query($link, 'SELECT id_film FROM film');
			while ($result = mysqli_fetch_array($sql)) {
				$result1 = mysqli_fetch_array($sql1);
				$res_id = mysqli_fetch_array($sqlid);
				echo '<div id="block_film"><a href="film.php?id=' . $res_id[0] . '"><img id="pic" src="' . $result[0] . '" width=200 height=auto/></a>
				<a href="film.php?id=' . $res_id[0] . '"><span id="film_name">' . $result1[0] . '</span></a></div>';
			}
		?>
		</form>
	</div>
	<div id="footer">Kino 2020</div>
</body>
</html>