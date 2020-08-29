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
	<div id="film_name_one">Удалить пользователя</div>
	<form id="del_user" method="post">
		<div id="del_user">
			<div class="del_user">

				<div class="span_add"><span >Выберите пльзователя</span></div>

				<?php

					$sql_req = "SELECT login FROM user";
					$sql_id = "SELECT id FROM user";

					echo '<select name="del_user">';
					$sql = mysqli_query($link, $sql_req);
					$sql_res_id = mysqli_query($link, $sql_id);
					$res = mysqli_fetch_array($sql_res_id);
					$result = mysqli_fetch_array($sql);
					while ($result = mysqli_fetch_array($sql)) {
						$res = mysqli_fetch_array($sql_res_id);
						echo '<option value="'.$res[0].'">' . $result[0] . '</option>';
					}
					echo '</select>';


				?>


				<div class="add_movie">
					<button class="add_button" type="submit" name="del_user_button">Удалить</button>
				</div>
			</div>


			<?php

				if( isset( $_POST['del_user_button'] ) )
				{
					$id_user = $_POST['del_user'];
					if ($id_user != 1) {
						$sql_filmid = mysqli_query($link, 'SELECT id_film FROM user_film WHERE id ='.$id_user);
						while ($res_filmid = mysqli_fetch_array($sql_filmid))
						{
							$sql_del = "DELETE FROM user_film WHERE id_film=".$res_filmid[0]." AND id=".$id_user;
							mysqli_query($link, $sql_del);
						}

						$sql1 = "DELETE FROM user WHERE id=" . $id_user;
						if (mysqli_query($link, $sql1)) {
							echo 'Пользователь успешно удален';
						} else
							echo "Ошибка";

					}
					else
						echo 'Невозможно удалить администратора';
				}
			?>
	</form>
</div>
<div id="footer">Kino 2020</div>
</body>
</html>