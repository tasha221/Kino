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

	$label = 'id';
	$id = false;
	if (  !empty( $_GET[ $label ] )  )
	{
		$id = $_GET[ $label ];
	}

	$sql_name = mysqli_query($link, 'SELECT name FROM film WHERE id_film ='.$id);
	$sql_year = mysqli_query($link, 'SELECT year FROM film WHERE id_film ='.$id);
	$sql_description = mysqli_query($link, 'SELECT description FROM film WHERE id_film ='.$id);
	$sql_poster = mysqli_query($link, 'SELECT poster FROM film WHERE id_film ='.$id);

	$res_name = mysqli_fetch_array($sql_name);
	$res_year = mysqli_fetch_array($sql_year);
	$res_description = mysqli_fetch_array($sql_description);
	$res_poster = mysqli_fetch_array($sql_poster);
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

	<div id="film_name_one">Редактировать</div>
	<form id="admin_add" method="post">

		<div class="tabs">
			<input type="radio" name="tab-btn1" id="tab-btn1-1" value="" checked>
			<label for="tab-btn1-1">Редактировать информацию</label>

			<input type="radio" name="tab-btn1" id="tab-btn1-2" value="" <?php if ( isset( $_POST['del_actor_button'] ) ) echo 'checked'?>>
			<label for="tab-btn1-2">Удалить актера</label>

			<input type="radio" name="tab-btn1" id="tab-btn1-3" value="" <?php if ( isset( $_POST['del_producer_button'] )) echo 'checked' ?>>
			<label for="tab-btn1-3">Удалить режиссера</label>

			<input type="radio" name="tab-btn1" id="tab-btn1-4" value="" <?php if ( isset( $_POST['del_genre_button'] )) echo 'checked' ?>>
			<label for="tab-btn1-4">Удалить жанр</label>

			<input type="radio" name="tab-btn1" id="tab-btn1-5" value="" <?php if ( isset( $_POST['add_actor_button'] )) echo 'checked' ?>>
			<label for="tab-btn1-5">Добавить актера</label>

			<input type="radio" name="tab-btn1" id="tab-btn1-6" value=""  <?php if ( isset( $_POST['add_producer_button'] )) echo 'checked' ?> >
			<label for="tab-btn1-6">Добавить режиссера</label>

			<input type="radio" name="tab-btn1" id="tab-btn1-7" value="" <?php if( isset( $_POST['add_genre_button'] ) )  echo 'checked' ?>>
			<label for="tab-btn1-7">Добавить жанр</label>



			<div id="add_movie">
<!--				<form id="change_movie" method="post" class="content_log">-->
					<div class="add_movie">
						<div class="span_add"><span >Название</span></div>
						<input type="text" size="50" name="film_name" id="input_add" <?php
							$sql_name = mysqli_query($link, 'SELECT name FROM film WHERE id_film ='.$id);

							$res_name = mysqli_fetch_array($sql_name);
							echo 'value="'.$res_name[0].'"' ?> >
					</div>
					<div class="add_movie" >
						<div class="span_add"><span>Постер</span></div>
						<input type="text" size="50" name="poster" id="input_add" <?php
							$sql_poster = mysqli_query($link, 'SELECT poster FROM film WHERE id_film ='.$id);

							$res_poster = mysqli_fetch_array($sql_poster);
							echo 'value="'.$res_poster[0].'"' ?> >
					</div>
					<div class="add_movie">
						<div class="span_add"><span>Год выпуска</span></div>
						<input type="text" size="50" name="year" id="input_add" <?php
							$sql_year = mysqli_query($link, 'SELECT year FROM film WHERE id_film ='.$id);

							$res_year = mysqli_fetch_array($sql_year);
							echo 'value="'.$res_year[0].'"' ?> >
					</div>
					<div class="add_movie" >
						<div class="span_add"><span>Описание</span></div>
						<label>
							<textarea name="description" cols="60" rows="3"><?php
									$sql_description = mysqli_query($link, 'SELECT description FROM film WHERE id_film ='.$id);

									$res_description = mysqli_fetch_array($sql_description);
									echo $res_description[0]
								?></textarea>
						</label>
					</div>
					<div class="add_movie">
						<button class="add_button" type="submit" name="change_button">Изменить</button>
					</div>

<!--				</form>-->
				<?php

					if( isset( $_POST['change_button'] ) )
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

								//$sql2 = "INSERT INTO film (id_film, name, description, year, poster) VALUES ('".$new_id."', '".$film_name."', '".$description."', '".$year."', '".$poster."')";
							$sql2 = "UPDATE film SET name='".$film_name."' WHERE id_film='".$id."'";
							$sql3 = "UPDATE film SET year='".$year."' WHERE id_film='".$id."'";
							$sql4 = "UPDATE film SET poster='".$poster."' WHERE id_film='".$id."'";
							$sql5 = "UPDATE film SET description='".$description."' WHERE id_film='".$id."'";
							if (mysqli_query($link, $sql2) && mysqli_query($link, $sql3) && mysqli_query($link, $sql4) && mysqli_query($link, $sql5)) {
									echo 'Информация обновлена';
								}
								else
									echo "Ошибка";

						}

					}
				?>
			</div>

			<div id="del_actor">
<!--				<form id="add_movie" method="post" class="content_log">-->
					<div class="add_movie">
						<div class="span_add"><span >Имя актера</span></div>
						<?php

								$sql_req = "SELECT id_actor FROM film_actor WHERE id_film=".$id;
								$sql_id = mysqli_query($link, $sql_req);

								echo '<select name="del_actor">';
								while ($res = mysqli_fetch_array($sql_id)) {
									$sql_req1 = "SELECT name FROM actor WHERE id_actor=".$res[0];
									$sql_id1 = mysqli_query($link, $sql_req1);
									$res1 = mysqli_fetch_array($sql_id1);
									echo '<option value="'.$res[0].'">' . $res1[0] . '</option>';
								}
								echo '</select>';

						?>

					</div>

					<div class="add_movie">
						<button class="add_button" type="submit" name="del_actor_button">Удалить</button>
					</div>

<!--				</form>-->
				<?php

					if( isset( $_POST['del_actor_button'] ) )
					{
						$id_actor1 = $_POST['del_actor'];
						$sql = "DELETE FROM film_actor WHERE id_film=".$id." AND id_actor=".$id_actor1;
						if (mysqli_query($link, $sql)) {
							echo 'Актер успешно удален';
						}
						else
							echo "Ошибка";

					}
				?>

			</div>

			<div id="del_producer">
<!--				<form id="add_movie" method="post" class="content_log">-->
					<div class="add_movie">
						<div class="span_add"><span >Имя режиссера</span></div>
						<?php

							$sql_req = "SELECT id_producer FROM film_producer WHERE id_film=".$id;
							$sql_id = mysqli_query($link, $sql_req);

							echo '<select name="del_producer">';
							while ($res = mysqli_fetch_array($sql_id)) {
								$sql_req1 = "SELECT name FROM producer WHERE id_producer=".$res[0];
								$sql_id1 = mysqli_query($link, $sql_req1);
								$res1 = mysqli_fetch_array($sql_id1);
								echo '<option value="'.$res[0].'">' . $res1[0] . '</option>';
							}
							echo '</select>';

						?>
					</div>

					<div class="add_movie">
						<button class="add_button" type="submit" name="del_producer_button">Удалить</button>
					</div>

<!--				</form>-->
				<?php

					if( isset( $_POST['del_producer_button'] ) )
					{
						$id_producer1 = $_POST['del_producer'];
						$sql = "DELETE FROM film_producer WHERE id_film=".$id." AND id_producer=".$id_producer1;
						if (mysqli_query($link, $sql)) {
							echo 'Режиссер успешно удален';
						}
						else
							echo "Ошибка";


					}
				?>
			</div>

			<div id="del_genre">
<!--				<form id="add_movie" method="post" class="content_log">-->
					<div class="add_movie">

						<div class="span_add"><span >Название жанра</span></div>
						<?php

							$sql_req = "SELECT id_genre FROM film_genre WHERE id_film=".$id;
							$sql_id = mysqli_query($link, $sql_req);

							echo '<select name="del_genre">';
							while ($res = mysqli_fetch_array($sql_id)) {
								$sql_req1 = "SELECT name FROM genre WHERE id_genre=".$res[0];
								$sql_id1 = mysqli_query($link, $sql_req1);
								$res1 = mysqli_fetch_array($sql_id1);
								echo '<option value="'.$res[0].'">' . $res1[0] . '</option>';
							}
							echo '</select>';

						?>
					</div>

						<div class="add_movie">
							<button class="add_button" type="submit" name="del_genre_button">Удалить</button>
						</div>

<!--				</form>-->

				<?php

					if( isset( $_POST['del_genre_button'] ) )
					{
						$id_genre1 = $_POST['del_genre'];
						$sql = "DELETE FROM film_genre WHERE id_film=".$id." AND id_genre=".$id_genre1;
						if (mysqli_query($link, $sql)) {
							echo 'Жанр успешно удален';
						}
						else
							echo "Ошибка";


		}
	?>

			</div>


			<div id="add_actor">
<!--				<form id="add_movie" method="post" class="content_log">-->
					<div class="add_movie">

						<div class="span_add"><span >Выберите актера</span></div>

						<?php

							$sql_req = "SELECT name FROM actor";
							$sql_id = "SELECT id_actor FROM actor";

							echo '<select name="add_actor">';
							$sql = mysqli_query($link, $sql_req);
							$sql_res_id = mysqli_query($link, $sql_id);
							while ($result = mysqli_fetch_array($sql)) {
								$res = mysqli_fetch_array($sql_res_id);
								echo '<option value="'.$res[0].'">' . $result[0] . '</option>';
							}
							echo '</select>';


						?>


						<div class="add_movie">
							<button class="add_button" type="submit" name="add_actor_button">Добавить</button>
						</div>
					</div>
<!--				</form>-->

				<?php

					if( isset( $_POST['add_actor_button'] ) )
					{
						$id_actor = $_POST['add_actor'];
						$sql = "SELECT * FROM film_actor WHERE id_film='.$id.' AND id_actor='.$id_actor.'";
						$result = mysqli_query($link, $sql);
						$count = mysqli_num_rows($result);
						if ($count != 0){
							echo 'Этот актер уже добавлен к фильму';
						}
						else {
							$sql2 = "INSERT INTO film_actor (id_film, id_actor) VALUES ('".$id."', '".$id_actor ."')";
							if (mysqli_query($link, $sql2)) {
								echo 'Актер успешно добавлен';
							}
							else
								echo "Ошибка";
						}


					}
				?>


			</div>

			<div id="add_producer">
<!--				<form id="add_movie" method="post" class="content_log">-->
					<div class="add_movie">

						<div class="span_add"><span >Выберите режиссера</span></div>

						<?php

							$sql_req = "SELECT name FROM producer";
							$sql_id = "SELECT id_producer FROM producer";

							echo '<select name="add_producer">';
							$sql = mysqli_query($link, $sql_req);
							$sql_res_id = mysqli_query($link, $sql_id);
							while ($result = mysqli_fetch_array($sql)) {
								$res = mysqli_fetch_array($sql_res_id);
								echo '<option value="'.$res[0].'">' . $result[0] . '</option>';
							}
							echo '</select>';


						?>


						<div class="add_movie">
							<button class="add_button" type="submit" name="add_producer_button">Добавить</button>
						</div>
					</div>
<!--				</form>-->

				<?php

					if( isset( $_POST['add_producer_button'] ) )
					{
						$id_producer = $_POST['add_producer'];
						$sql = "SELECT * FROM film_producer WHERE id_film='.$id.' AND id_producer='.$id_producer.'";
						$result = mysqli_query($link, $sql);
						$count = mysqli_num_rows($result);
						if ($count != 0){
							echo 'Этот режиссер уже добавлен к фильму';
						}
						else {
							$sql2 = "INSERT INTO film_producer (id_film, id_producer) VALUES ('".$id."', '".$id_producer ."')";
							if (mysqli_query($link, $sql2)) {
								echo 'Режиссер успешно добавлен';
							}
							else
								echo "Ошибка";
						}


					}
				?>


			</div>

			<div id="add_genre">
<!--				<form id="add_movie" method="post" class="content_log">-->
					<div class="add_movie">
						<div class="span_add"><span >Выберите жанр</span></div>

						<?php

							$sql_req = "SELECT name FROM genre";
							$sql_id = "SELECT id_genre FROM genre";

							echo '<select name="add_genre">';
							$sql = mysqli_query($link, $sql_req);
							$sql_res_id = mysqli_query($link, $sql_id);
							while ($result = mysqli_fetch_array($sql)) {
								$res = mysqli_fetch_array($sql_res_id);
								echo '<option value="'.$res[0].'">' . $result[0] . '</option>';
							}
							echo '</select>';


						?>

						<div class="add_movie">
							<button class="add_button" type="submit" name="add_genre_button">Добавить</button>
						</div>
					</div>
<!--				</form>-->

				<?php

					if( isset( $_POST['add_genre_button'] ) )
					{
						$id_genre = $_POST['add_genre'];
						$sql = "SELECT * FROM film_genre WHERE id_film='.$id.' AND id_genre='.$id_genre.'";
						$result = mysqli_query($link, $sql);
						$count = mysqli_num_rows($result);
						if ($count != 0){
							echo 'Этот жанр уже добавлен к фильму';
						}
						else {
							$sql2 = "INSERT INTO film_genre (id_film, id_genre) VALUES ('".$id."', '".$id_genre ."')";
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