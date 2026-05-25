<?php
session_start();

// Проверяем, авторизован ли пользователь
if(!isset($_SESSION['user_id'])){
    die('Чтобы создать заявку, необходимо войти в аккаунт.');
}

// Обработка отправки формы
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include('db.php');

    $con->query("
        INSERT INTO request (review, date, curses, payment, user_id, status) 
        VALUES ('', '{$_POST['date']}', '{$_POST['curses']}', '{$_POST['payment']}', '{$_SESSION['user_id']}', 'Новая')
    ") or die('Ошибка: ' . $con->error);

    header('Location: history.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создание заявки — Конференции.РФ</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

<!-- Шапка сайта -->
<div class="header">
    <div class="nav">

        <a href="index.php" class="logo">Конференции.РФ</a>

        <div class="nav-buttons">
            <a href="history.php" class="btn-lk">Мои заявки</a>
            <a href="create.php" class="btn-active">Новая заявка</a>
        </div>

    </div>
</div>

<!-- Основной контент -->
<div class="container">
    <div class="booking-card">

        <div class="booking-header">
            <h1>Создание заявки</h1>
            <p>Выберите помещение, дату начала конференции и способ оплаты</p>
        </div>

        <!-- Форма создания заявки -->
        <form method="POST" class="form-group">

            <label for="curses">Помещение для конференции</label>
            <select required name="curses" id="curses">
                <option value="Аудитория">Аудитория</option>
                <option value="Коворкинг">Коворкинг</option>
                <option value="Кинозал">Кинозал</option>
            </select>

            <label for="date">Дата и время начала конференции</label>
            <input 
                type="datetime-local" 
                name="date" 
                id="date" 
                required
            >

            <label for="payment">Способ оплаты</label>
            <select required name="payment" id="payment">
                <option value="Наличные">Наличные</option>
                <option value="Банковская карта">Банковская карта</option>
                <option value="Безналичный расчёт">Безналичный расчёт</option>
            </select>

            <button class="btn-sub">Отправить заявку</button>

        </form>

    </div>
</div>

</body>
</html>