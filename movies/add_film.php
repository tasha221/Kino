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

	$film_name = $_POST['film_name'];
	$poster = $_POST['poster'];
	$year = $_POST['year'];
	$description = $_POST['description'];
	$actor_name = $_POST['actor_name'];
	$producer_name = $_POST['producer_name'];

//	echo $_GET['actor_num'];
//	if( isset( $_GET['actor_num'] ) )
//	{
//		$num = $_GET['actor_num'];
//		$sql_req = "SELECT name FROM actor";
//		$sql = mysqli_query($link, $sql_req);
//		$i = 0;
//		echo ''.$num;
//		for ($i; $i < $num; $i++) {
//			echo '<select>';
//
//			while ($result = mysqli_fetch_array($sql)) {
//				echo '<option>' . $result[0] . '</option>';
//			}
//			echo '</select>';
//		}
//	}


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

	<div id="film_name_one">Добавить</div>
	<form id="admin_add" method="post">

		<div class="tabs">
			<input type="radio" name="tab-btn" id="tab-btn-1" value="" checked>
			<label for="tab-btn-1">Добавить фильм</label>
			<input type="radio" name="tab-btn" id="tab-btn-2" value="" <?php if ( isset( $_POST['add_actor_button'] ) ) echo 'checked'?>>
			<label for="tab-btn-2">Добавить актера</label>
			<input type="radio" name="tab-btn" id="tab-btn-3" value="" <?php if ( isset( $_POST['add_producer_button'] )) echo 'checked' ?>>
			<label for="tab-btn-3">Добавить режиссера</label>
			<input type="radio" name="tab-btn" id="tab-btn-4" value="" <?php if ( isset( $_POST['add_actor_film_button'] )) echo 'checked' ?>>
			<label for="tab-btn-4">Добавить актеров фильма</label>
			<input type="radio" name="tab-btn" id="tab-btn-5" value=""  <?php if ( isset( $_POST['add_producer_film_button'] )) echo 'checked' ?> >
			<label for="tab-btn-5">Добавить режиссера фильма</label>
			<input type="radio" name="tab-btn" id="tab-btn-6" value="" <?php if( isset( $_POST['add_genre_film_button'] ) )  echo 'checked' ?>>
			<label for="tab-btn-6">Добавить жанр фильма</label>

			<div id="add_movie">
<!--				<form id="add_movie" method="post" class="content_log">-->
					<div class="add_movie">
						<div class="span_add"><span >Название</span></div>
						<input type="text" size="50" name="film_name" id="input_add" <?php if ($film_name != "") echo 'value="'.$film_name.'"' ?>>
					</div>
					<div class="add_movie" >
						<div class="span_add"><span>Постер</span></div>
						<input type="text" size="50" name="poster" id="input_add" <?php if ($poster != "") echo 'value="'.$poster.'"' ?>>
					</div>
					<div class="add_movie">
						<div class="span_add"><span>Год выпуска</span></div>
						<input type="text" size="50" name="year" id="input_add" <?php if ($year != "") echo 'value="'.$year.'"' ?>>
					</div>
					<div class="add_movie" >
						<div class="span_add"><span>Описание</span></div>
						<label>
							<textarea name="description" cols="40" rows="3"><?php if ($description != "") echo $description ?></textarea>
						</label>
					</div>
					<div class="add_movie">
						<button class="add_button" type="submit" name="add_button">Добавить</button>
					</div>

<!--				</form>-->
			<?php

				if( isset( $_POST['add_button'] ) )
				{
					if ($film_name == "")
						echo 'Введите название фильма';
					else if ($poster == "")
						echo 'Введите расположение постера';
					else if ($year == "")
						echo 'Введите год';
					else if (!is_numeric($year))
						echo 'Введите год правильно';
					else if ($description == "")
						echo 'Введите описание';
					else {
						$sql = "SELECT * FROM film WHERE name='$film_name' AND description='$description' AND year='$year' AND poster='$poster'";
						$result = mysqli_query($link, $sql);
						$count = mysqli_num_rows($result);
						if ($count != 0){
							echo 'Этот фильм уже добавлен';
						}
						else {
							$sql1 = "SELECT MAX(id_film) FROM film";
							$result1 = mysqli_query($link, $sql1);
							$res1 = mysqli_fetch_array($result1);
							$new_id = $res1[0] + 1;
							$sql2 = "INSERT INTO film (id_film, name, description, year, poster) VALUES ('".$new_id."', '".$film_name."', '".$description."', '".$year."', '".$poster."')";
							if (mysqli_query($link, $sql2)) {
								echo 'Фильм успешно добавлен';
							}
							else
								echo "error";
						}
					}

				}
				?>
			</div>
			<div id="add_actor">
<!--				<form id="add_movie" method="post" class="content_log">-->
					<div class="add_movie">
						<div class="span_add"><span >Имя актера</span></div>
						<input type="text" size="50" name="actor_name" id="input_add" <?php if ($actor_name != "") echo 'value="'.$actor_name.'"' ?>>
					</div>

					<div class="add_movie">
						<button class="add_button" type="submit" name="add_actor_button">Добавить</button>
					</div>

<!--				</form>-->
				<?php

					if( isset( $_POST['add_actor_button'] ) )
					{
						if ($actor_name == "")
							echo 'Введите имя актера';
						else {
							$sql = "SELECT * FROM actor WHERE name='$actor_name'";
							$result = mysqli_query($link, $sql);
							$count = mysqli_num_rows($result);
							if ($count != 0){
								echo 'Этот актер уже добавлен';
							}
							else {
								$sql1 = "SELECT MAX(id_actor) FROM actor";
								$result1 = mysqli_query($link, $sql1);
								$res1 = mysqli_fetch_array($result1);
								$new_id = $res1[0] + 1;
								$sql2 = "INSERT INTO actor (id_actor, name) VALUES ('".$new_id."', '".$actor_name."')";
								if (mysqli_query($link, $sql2)) {
									echo 'Актер успешно добавлен';
								}
								else
									echo "Ошибка";
							}
						}

					}
				?>

			</div>

			<div id="add_producer">
<!--				<form id="add_movie" method="post" class="content_log">-->
					<div class="add_movie">
						<div class="span_add"><span >Имя режиссера</span></div>
						<input type="text" size="50" name="producer_name" id="input_add" <?php if ($producer_name != "") echo 'value="'.$producer_name.'"' ?>>
					</div>

					<div class="add_movie">
						<button class="add_button" type="submit" name="add_producer_button">Добавить</button>
					</div>

<!--				</form>-->
				<?php

					if( isset( $_POST['add_producer_button'] ) )
					{
						if ($producer_name == "")
							echo 'Введите имя режиссера';
						else {
							$sql = "SELECT * FROM producer WHERE name='$producer_name'";
							$result = mysqli_query($link, $sql);
							$count = mysqli_num_rows($result);
							if ($count != 0){
								echo 'Этот режиссер уже добавлен';
							}
							else {
								$sql1 = "SELECT MAX(id_producer) FROM producer";
								$result1 = mysqli_query($link, $sql1);
								$res1 = mysqli_fetch_array($result1);
								$new_id = $res1[0] + 1;
								$sql2 = "INSERT INTO producer (id_producer, name) VALUES ('".$new_id."', '".$producer_name."')";
								if (mysqli_query($link, $sql2)) {
									echo 'Режиссер успешно добавлен';
								}
								else
									echo "Ошибка";
							}
						}

					}
				?>
			</div>

			<div id="add_actor_film">
<!--				<form id="add_movie" method="post" class="content_log">-->
					<div class="add_movie">
						<div class="span_add"><span >Выберите фильм</span></div>

				<?php

					$sql_req = "SELECT name FROM film";
					$sql_id = "SELECT id_film FROM film";

					echo '<select name="film_name1">';
					$sql = mysqli_query($link, $sql_req);
					$sql_res_id = mysqli_query($link, $sql_id);
					while ($result = mysqli_fetch_array($sql)) {
						$res = mysqli_fetch_array($sql_res_id);
						echo '<option value="'.$res[0].'">' . $result[0] . '</option>';
					}
					echo '</select>';


				?>
					<br>
					<div class="span_add"><span >Выберите актера</span></div>

					<?php

						$sql_req = "SELECT name FROM actor";
						$sql_id = "SELECT id_actor FROM actor";

						echo '<select name="actor_name1">';
						$sql = mysqli_query($link, $sql_req);
						$sql_res_id = mysqli_query($link, $sql_id);
						while ($result = mysqli_fetch_array($sql)) {
							$res = mysqli_fetch_array($sql_res_id);
							echo '<option value="'.$res[0].'">' . $result[0] . '</option>';
						}
						echo '</select>';


					?>


					<div class="add_movie">
						<button class="add_button" type="submit" name="add_actor_film_button">Добавить</button>
					</div>
					</div>
<!--				</form>-->

				<?php

					if( isset( $_POST['add_actor_film_button'] ) )
					{
						$id_film = $_POST['film_name1'];
						$id_actor = $_POST['actor_name1'];
						$sql = "SELECT * FROM film_actor WHERE id_film='$id_film' AND id_actor='$id_actor'";
						$result = mysqli_query($link, $sql);
						$count = mysqli_num_rows($result);
						if ($count != 0){
							echo 'Этот актер уже добавлен к фильму';
						}
						else {
							$sql2 = "INSERT INTO film_actor (id_film, id_actor) VALUES ('".$id_film."', '".$id_actor ."')";
							if (mysqli_query($link, $sql2)) {
								echo 'Актер успешно добавлен';
							}
							else
								echo "Ошибка";
						}


					}
				?>

			</div>

			<div id="add_producer_film">
<!--				<form id="add_movie" method="post" class="content_log">-->
					<div class="add_movie">
						<div class="span_add"><span >Выберите фильм</span></div>

						<?php

							$sql_req = "SELECT name FROM film";
							$sql_id = "SELECT id_film FROM film";

							echo '<select name="film_name2">';
							$sql = mysqli_query($link, $sql_req);
							$sql_res_id = mysqli_query($link, $sql_id);
							while ($result = mysqli_fetch_array($sql)) {
								$res = mysqli_fetch_array($sql_res_id);
								echo '<option value="'.$res[0].'">' . $result[0] . '</option>';
							}
							echo '</select>';


						?>
						<br>
						<div class="span_add"><span >Выберите режиссера</span></div>

						<?php

							$sql_req = "SELECT name FROM producer";
							$sql_id = "SELECT id_producer FROM producer";

							echo '<select name="producer_name1">';
							$sql = mysqli_query($link, $sql_req);
							$sql_res_id = mysqli_query($link, $sql_id);
							while ($result = mysqli_fetch_array($sql)) {
								$res = mysqli_fetch_array($sql_res_id);
								echo '<option value="'.$res[0].'">' . $result[0] . '</option>';
							}
							echo '</select>';


						?>


						<div class="add_movie">
							<button class="add_button" type="submit" name="add_producer_film_button">Добавить</button>
						</div>
					</div>
<!--				</form>-->

				<?php

					if( isset( $_POST['add_producer_film_button'] ) )
					{
						$id_film = $_POST['film_name2'];
						$id_producer = $_POST['producer_name1'];
						$sql = "SELECT * FROM film_producer WHERE id_film='$id_film' AND id_producer='$id_producer'";
						$result = mysqli_query($link, $sql);
						$count = mysqli_num_rows($result);
						if ($count != 0){
							echo 'Этот режиссер уже добавлен к фильму';
						}
						else {
							$sql2 = "INSERT INTO film_producer (id_film, id_producer) VALUES ('".$id_film."', '".$id_producer ."')";
							if (mysqli_query($link, $sql2)) {
								echo 'Режиссер успешно добавлен';
							}
							else
								echo "Ошибка";
						}


					}
				?>


			</div>

			<div id="add_genre_film">
<!--				<form id="add_movie" method="post" class="content_log">-->
					<div class="add_movie">
						<div class="span_add"><span >Выберите фильм</span></div>

						<?php

							$sql_req = "SELECT name FROM film";
							$sql_id = "SELECT id_film FROM film";

							echo '<select name="film_name3">';
							$sql = mysqli_query($link, $sql_req);
							$sql_res_id = mysqli_query($link, $sql_id);
							while ($result = mysqli_fetch_array($sql)) {
								$res = mysqli_fetch_array($sql_res_id);
								echo '<option value="'.$res[0].'">' . $result[0] . '</option>';
							}
							echo '</select>';


						?>
						<br>
						<div class="span_add"><span >Выберите жанр</span></div>

						<?php

							$sql_req = "SELECT name FROM genre";
							$sql_id = "SELECT id_genre FROM genre";

							echo '<select name="genre_name1">';
							$sql = mysqli_query($link, $sql_req);
							$sql_res_id = mysqli_query($link, $sql_id);
							while ($result = mysqli_fetch_array($sql)) {
								$res = mysqli_fetch_array($sql_res_id);
								echo '<option value="'.$res[0].'">' . $result[0] . '</option>';
							}
							echo '</select>';


						?>


						<div class="add_movie">
							<button class="add_button" type="submit" name="add_genre_film_button">Добавить</button>
						</div>
					</div>
<!--				</form>-->

				<?php

					if( isset( $_POST['add_genre_film_button'] ) )
					{
						$id_film = $_POST['film_name3'];
						$id_genre = $_POST['genre_name1'];
						$sql = "SELECT * FROM film_genre WHERE id_film='$id_film' AND id_genre='$id_genre'";
						$result = mysqli_query($link, $sql);
						$count = mysqli_num_rows($result);
						if ($count != 0){
							echo 'Этот жанр уже добавлен к фильму';
						}
						else {
							$sql2 = "INSERT INTO film_genre (id_film, id_genre) VALUES ('".$id_film."', '".$id_genre ."')";
							if (mysqli_query($link, $sql2)) {
								echo 'Жанр успешно добавлен';
							}
							else
								echo "Ошибка";
						}


					}
				?>
			</div>
		</div>

	</form>
</div>
<div id="footer">Kino 2020</div>
</body>
</html>