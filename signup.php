<?php 
$title="Форма регистрации"; // название формы
require __DIR__ . '/header.php'; // подключаем шапку проекта

// Создаем переменную для сбора данных от пользователя по методу POST
$data = $_POST;

// Пользователь нажимает на кнопку "Зарегистрировать" и код начинает выполняться
if(isset($data['do_signup'])) {

        // Регистрируем
        // Создаем массив для сбора ошибок
	$errors = array();

	// Проводим проверки
    // trim — удаляет пробелы (или другие символы) из начала и конца строки
	if(trim($data['login']) == '') {

		$errors[] = "Введите логин!";
	}

	if(stristr($data["login"]," ")) {

		$errors[] = "Логин не должен содержать пробелы!";
	}
	if(trim($data['email']) == '') {

		$errors[] = "Введите Email";
	}


	if(trim($data['name']) == '') {

		$errors[] = "Введите Имя";
	}

	if (preg_match('~\d~', $data['name'])) {

  		$errors[] = 'Имя должно состоять только из букв';
	}

	if (preg_match("|\s|", $data['name']) ) {
    	$errors[] = "Имя не должно содержать пробелов";
    }

	if($data['password'] == '') {

		$errors[] = "Введите пароль";
	}

	if(stristr($data["password"]," ")) {

		$errors[] = "Пароль не должен содержать пробелы!";
	}

	if (!preg_match("#^[aA-zZ0-9\-_]+$#",$data["password"])) {

		$errors[] = "Пароль должен состоять только из латинский букв и цифр!";
	}

	if (!preg_match("#[0-9]+#", $data['password_2'])) {

  		$errors[] = "Пароль должен содержать хотя бы одну цифру";
	}
	
	if (!preg_match("#[a-zA-Z]+#", $data['password'])) {

  		$errors[] = "Пароль должен содержать хотя бы одну букву";
	} 

	if($data['password_2'] != $data['password']) {

		$errors[] = "Повторный пароль введен не верно!";
	}
    // функция mb_strlen - получает длину строки
    // Если логин будет меньше 6 символов, то выйдет ошибка
	if(mb_strlen($data['login']) < 6) {

	    $errors[] = "Недопустимая длина логина";

    }

    if (mb_strlen($data['name']) < 2){
	    
	    $errors[] = "Недопустимая длина имени";

    }

    if (mb_strlen($data['password']) < 6){
	
	    $errors[] = "Недопустимая длина пароля";

    }

    // проверка на правильность написания Email
    if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $data['email'])) {

	    $errors[] = 'Неверно введен е-mail';
    
    }

	$jsonArray = [];
	$users = file_get_contents("libs/ManaoTest.json");
	$jsonArray = json_decode($users, true);

	// Проверка на уникальность логина
	for ($i=0; $i < count($jsonArray); $i++) {
	if (trim($_POST["login"]) == trim($jsonArray[$i]["login"])) {
		$errors[] = "Пользователь с таким логином уже существует!";
	}	
}

	// Проверка на уникальность email
	for ($i=0; $i < count($jsonArray); $i++) {
		if (trim($_POST["email"]) == trim($jsonArray[$i]["email"])) {
			$errors[] = "Пользователь с таким Email существует!";
		}	
	}


	if(empty($errors)) {

		// Все проверено, регистрируем

		$i=count($jsonArray);
        // добавляем в файл информации о пользователе и шифруем пароль
		$jsonArray[$i]["login"] = $_POST["login"];
		$jsonArray[$i]["email"] = $_POST["email"];
		$jsonArray[$i]["name"] = $_POST["name"];
		$jsonArray[$i]["password"] = crypt($_POST["password"], '$1$rasmusle$');
		file_put_contents("libs/ManaoTest.json", json_encode($jsonArray, JSON_UNESCAPED_UNICODE));

        echo '<div style="color: green; ">Вы успешно зарегистрированы! Можно <a href="login.php">авторизоваться</a>.</div><hr>';

	} else {
                // array_shift() извлекает первое значение массива array и возвращает его, сокращая размер array на один элемент. 
		echo '<div style="color: red; ">' . array_shift($errors). '</div><hr>';
	}
}
?>

<div class="container mt-4">
		<div class="row">
			<div class="col">
	   <!-- Форма регистрации -->
		<h2>Форма регистрации</h2>
		<form action="signup.php" id="ajax_form" method="post">
			<input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"><br>
			<input type="email" class="form-control" name="email" id="email" placeholder="Введите Email"><br>
			<input type="text" class="form-control" name="name" id="name" placeholder="Введите имя" required><br>
			<input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль"><br>
			<input type="password" class="form-control" name="password_2" id="password_2" placeholder="Повторите пароль"><br>
			<script type="text/javascript">
    			document.write("<button type=\"submit\" id=\"btn\" class=\"btn btn-success\" name=\"do_signup\">Зарегистрироваться</button>");
			</script>
			<noscript>
    			<p style="color: red;"><b><i>Для отпраки формы необходимо включить JavaScript</i></b><p>
			</noscript>
			<!--<button class="btn btn-success" id="btn" name="do_signup" type="submit">Зарегистрировать</button>-->
		</form>
		<br>
		<p>Если вы зарегистрированы, тогда нажмите <a href="login.php">здесь</a>.</p>
		<p>Вернуться на <a href="index.php">главную</a>.</p>
			</div>
		</div>
	</div>
<?php require __DIR__ . '/footer.php'; ?> <!-- Подключаем подвал проекта -->