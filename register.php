<?php
// Обработка регистрации пользователя
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('db.php');

    $login = $_POST['login'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $con->query("INSERT INTO users (login, password, fullname, phone, email) 
    VALUES ('$login', '$password', '$fullname', '$phone', '$email')") 
    or die('Ошибка: ' . $con->error);

    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация — Конференции.РФ</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="phone.js"></script>
</head>

<body class="body-form">
    <div class="register-container">
        <a href="index.php" class="index-link">◄ На главную</a>

        <h1>Регистрация</h1>
        <p>Создайте аккаунт для бронирования помещения для конференции</p>

        <form method="POST">
            <label>ФИО*</label>
            <input type="text" name="fullname" required>

            <label>Контактный номер телефона*</label>
            <input 
                type="tel" 
                name="phone" 
                placeholder="+7(___)___-__-__" 
                pattern="\+7\(\d{3}\)\d{3}-\d{2}-\d{2}" 
                maxlength="16" 
                required
            >

            <label>E-mail*</label>
            <input type="email" name="email" required>

            <label>Логин* — латинские буквы и цифры, минимум 6 символов</label>
            <input 
                type="text" 
                name="login" 
                pattern="[a-zA-Z0-9]{6,}" 
                required
            >

            <label>Пароль* — минимум 8 символов</label>
            <input 
                type="password" 
                name="password" 
                minlength="8" 
                required
            >

            <button type="submit" class="btn-sub">Зарегистрироваться</button>
        </form>

        <p class="form-bottom-text">
            Уже есть аккаунт? 
            <a href="login.php" class="login-link">Войти</a>
        </p>
    </div>
</body>
</html>