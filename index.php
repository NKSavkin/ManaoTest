<?php
$title="Главная страница"; // название формы
require __DIR__ . '/header.php'; // подключаем шапку проекта
?>

<div class="container mt-4">
<div class="row">
<div class="col">
<center>
<h1>Добро пожаловать на наш сайт!</h1>
</center>
</div>
</div>
</div>

<!-- Если авторизован выведет приветствие -->
<?php if(isset($_COOKIE["login"])) : ?>

<!-- Пользователь может нажать выйти для выхода из системы -->
<form method="post">
  <button type="submit" name="logout" class="btn btn-primary">Выйти</button>
</form>
<?php else : ?>

<!-- Если пользователь не авторизован выведет ссылки на авторизацию и регистрацию -->
<a href="login.php">Авторизоваться</a><br>
<a href="signup.php">Регистрация</a>
<?php endif; ?>

<?php require __DIR__ . '/footer.php'; ?> <!-- Подключаем подвал проекта -->