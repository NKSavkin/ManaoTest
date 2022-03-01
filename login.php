<?php
$title="Форма авторизации"; // название формы
require __DIR__ . '/header.php'; // подключаем шапку проекта

// Создаем переменную для сбора данных от пользователя по методу POST
$data = $_POST;

// Пользователь нажимает на кнопку "Авторизоваться" и код начинает выполняться
if(isset($data['do_login'])) { 

 	// Создаем массив для сбора ошибок
 	$errors = array();

 	//Список логинов и паролей
	$jsonArray = [];

	$users = file_get_contents("libs/ManaoTest.json");
	$jsonArray = json_decode($users, true);

	//Верификация логина и расшифрованного пароля

	for ($i=0; $i < count($jsonArray); $i++) {
		if (trim($_POST["login"]) == trim($jsonArray[$i]["login"]) && hash_equals($jsonArray[$i]["password"], crypt($_POST["password"], $jsonArray[$i]["password"]))) {
			//регистрируем пользователя в сессии
			setcookie('name', $jsonArray[$i]["name"]);
			setcookie('login', $_POST["login"]);
			header("Location: index.php");
			exit();
		}	
	}
	if ($_COOKIE["login"] != $_POST["login"]) {
		$errors[] = "Неверно введен логин или пароль!";
	}


	if(!empty($errors)) {
		echo '<div style="color: red; ">' . array_shift($errors). '</div><hr>';
	}
}
?>

<div class="container mt-4">
		<div class="row">
			<div class="col">
		<!-- Форма авторизации -->
		<h2>Форма авторизации</h2>
		<form action="login.php" method="post" id="form">
			<input type="text" class="form-control" name="login" id="login" placeholder="Введите логин" required><br>
			<input type="password" class="form-control" name="password" id="pass" placeholder="Введите пароль" required><br>
			<script type="text/javascript">
    			document.write("<button type=\"submit\" name=\"do_login\" class=\"btn btn-success\">Авторизоваться</button>");
			</script>
			<noscript>
    			<p style="color: red;"><b><i>Для отпраки формы необходимо включить JavaScript</i></b><p>
			</noscript>
		</form>
		<br>
		<p>Если вы еще не зарегистрированы, тогда нажмите <a href="signup.php">здесь</a>.</p>
		<p>Вернуться на <a href="index.php">главную</a>.</p>
			</div>
		</div>
	</div>

<?php require __DIR__ . '/footer.php'; ?> <!-- Подключаем подвал проекта -->