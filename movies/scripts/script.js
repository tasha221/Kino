function entr()
{
	login=document.getElementById('login').value;
	password=document.getElementById('password').value;
	if($password=="" || $login=="")
	{
		alert("Проверьте введённые данные!Все поля должны быть заполненны");
	}
	else
	{
		if($password1==$password2)
		{
			document.getElementById('modal-body1').action='addclient.php';
		}
		else
		{
			alert("Проверьте пароль!Он должен совпадать!");
		}
	}

}