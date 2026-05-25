<?php
// Обработка входа пользователя

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    include('db.php');

    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = $con->query("
        SELECT * FROM users 
        WHERE login='$login' 
        AND password='$password'
    ") or die('Ошибка: ' . $con->error);

    $user = $query->fetch_assoc();

    if(!$user){
        die('Неверный логин или пароль');
    }

    session_start();

    $_SESSION['user_id'] = $user['id'];

    // Проверяем, является ли пользователь администратором
    $_SESSION['admin'] = ($user['login'] == 'Admin26' && $user['password'] == 'Demo20');

    if($_SESSION['admin']){
        header('Location: admin.php');
    } else {
        header('Location: index.php');
    }

    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход — Конференции.РФ</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="body-form">

<div class="login-container">

    <a href="index.php" class="index-link">◄ На главную</a>

    <h1>Вход в систему</h1>

    <p>Авторизуйтесь для управления заявками на бронирование помещений</p>

    <form method="POST">

        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите логин" required>

        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль" required>

        <button type="submit" class="btn-sub">Войти</button>

    </form>

    <p>
        Еще не зарегистрированы?
        <a href="register.php" class="register-link">Регистрация</a>
    </p>

</div>

</body>
</html>