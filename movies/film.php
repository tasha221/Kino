<?php
	$host='localhost';
	$database='movies';
	$user='root';
	$password='root';
	session_start();
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$link=mysqli_connect($host,$user,$password,$database);
	if(!$link)
		die('Соединения нет!');

	if ( isset( $_POST['film_watchedbutt'] ) ) {
		$sql_id = "SELECT id FROM user WHERE login = '" . $_SESSION['login'] . "'";
		$sql_myid = mysqli_query($link, $sql_id);
		$myid = mysqli_fetch_array($sql_myid);
		$label = 'id';
		$sqladd = "INSERT INTO user_film (id, id_film) VALUES (" . $myid[0] . ", " . $_GET[ $label ] . ")";
		if (!mysqli_query($link, $sqladd)) {
			echo 'error';
		}
	}

	if ( isset( $_POST['film_unwatched'] ) ) {
		$sql_id = "SELECT id FROM user WHERE login = '" . $_SESSION['login'] . "'";
		$sql_myid = mysqli_query($link, $sql_id);
		$myid = mysqli_fetch_array($sql_myid);
		$label = 'id';
		$sqldel = "DELETE FROM user_film WHERE id = " . $myid[0] . " AND id_film = " . $_GET[ $label ];
		if (!mysqli_query($link, $sqldel)) {
			echo 'error';
		}
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
	<form id="watched" method="post">
	<?php
		$label = 'id';
		$id = false;
		if (  !empty( $_GET[ $label ] )  )
		{
			$id = $_GET[ $label ];
		}
		$sql = mysqli_query($link, 'SELECT poster FROM film WHERE id_film ='.$id);
		$sql1 = mysqli_query($link, 'SELECT name FROM film WHERE id_film ='.$id);
		$sqlid = mysqli_query($link, 'SELECT id_film FROM film WHERE id_film ='.$id);
		$sqldescr = mysqli_query($link, 'SELECT description FROM film WHERE id_film ='.$id);
		$result = mysqli_fetch_array($sql);
		$result1 = mysqli_fetch_array($sql1);
		$res_id = mysqli_fetch_array($sqlid);
		$res_descr = mysqli_fetch_array($sqldescr);
		echo '<div id="block_film_one">
			<div id="film_name_one">' . $result1[0];
		if (isset($_SESSION['login']) && $_SESSION['login'] != 'admin') {
			$log = $_SESSION['login'];
			$sql_1 = "SELECT id FROM user WHERE login = '".$log."'";
			$sql_myid = mysqli_query($link, $sql_1);
			$myid = mysqli_fetch_array($sql_myid);

			$sql_ifwatched = "SELECT id_film FROM user_film WHERE id =".$myid[0]." AND id_film = ".$id;
			$result_watched = mysqli_query($link, $sql_ifwatched);

			$count = mysqli_num_rows($result_watched);
			if ($count == 0)
				echo '<button id="film_watched" name="film_watchedbutt">Просмотрен</button>';
			else
				echo '<button id="film_unwatched" name="film_unwatched">Просмотрен</button>';
		}
		else if (isset($_SESSION['login']) && $_SESSION['login'] == 'admin')
		{
			echo '<button><a href="change.php?id='.$id.'">Редактировать</a></button>';
		}
		echo '</div>';
		echo '<img id="pic_one" src="' . $result[0] . '" width=200 height=auto>';
		$sql_year = mysqli_query($link, 'SELECT year FROM film WHERE id_film ='.$id);
		$sql_actorid = mysqli_query($link, 'SELECT id_actor FROM film_actor WHERE id_film ='.$id);
		$sql_genreid = mysqli_query($link, 'SELECT id_genre FROM film_genre WHERE id_film ='.$id);
		$sql_producerid = mysqli_query($link, 'SELECT id_producer FROM film_producer WHERE id_film ='.$id);
		$res_year = mysqli_fetch_array($sql_year);
		echo '<p><span id="tolst">Год</span> '.$res_year[0].'</p>';

		echo '<p><span id="tolst">В ролях</span> ';
		$res_actorid = mysqli_fetch_array($sql_actorid);
		while ($res_actorid)
		{
			$sql_actor = mysqli_query($link, 'SELECT name FROM actor WHERE id_actor ='.$res_actorid[0]);
			$res_actor = mysqli_fetch_array($sql_actor);
			echo '<a href="person.php?id_actor='.$res_actorid[0].'">'.$res_actor[0].'</a>';
			if ($res_actorid = mysqli_fetch_array($sql_actorid))
				echo ', ';
		}
		echo '</p>';

		echo '<p><span id="tolst">Режиссер</span> ';
		$res_producerid = mysqli_fetch_array($sql_producerid);
		while ($res_producerid)
		{
			$sql_producer = mysqli_query($link, 'SELECT name FROM producer WHERE id_producer ='.$res_producerid[0]);
			$res_producer = mysqli_fetch_array($sql_producer);
			echo '<a href="person.php?id_producerid='.$res_producerid[0].'">'.$res_producer[0].'</a>';
			if ($res_producerid = mysqli_fetch_array($sql_producerid))
				echo ', ';
		}
		echo '</p>';

		echo '<p><span id="tolst">Жанр</span> ';
		$res_genreid = mysqli_fetch_array($sql_genreid);
		while ($res_genreid)
		{
			$sql_genre = mysqli_query($link, 'SELECT name FROM genre WHERE id_genre ='.$res_genreid[0]);
			$res_genre = mysqli_fetch_array($sql_genre);
			echo '<a href="person.php?id_genreid='.$res_genreid[0].'">'.$res_genre[0].'</a>';
			if ($res_genreid = mysqli_fetch_array($sql_genreid))
				echo ', ';
		}
		echo '</p>';

		echo '<p><span id="tolst">Описание</span></p>';
		echo '<span id="flm_descr">'.$res_descr[0].'</span>
			</div>';
	?>
	</form>
</div>
<div id="footer">Kino 2020</div>
</body>
</html>