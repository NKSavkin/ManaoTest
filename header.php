<?php
//Начало сессии
session_start();

if (isset($_POST["logout"])) {
	 unset($_COOKIE["login"]);
	 setcookie('login', null, -1, '/');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta content="text/html; charset=utf-8">
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/form.js"></script>
</head>

<!-- Если авторизован выведет приветствие -->
<?php if(isset($_COOKIE["login"])) : ?>
	Привет, <?php echo $_COOKIE['name']; ?>
<?php endif; ?></br>
<body>