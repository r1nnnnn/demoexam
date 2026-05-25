<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Конференции.РФ — бронирование помещений</title>

    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/slider.css">
</head>

<body>

<!-- Шапка сайта -->
<div class="header">
    <div class="nav">

        <a href="index.php" class="logo">Конференции.РФ</a>

        <?php if(!isset($_SESSION['user_id'])): ?>

            <div class="nav-buttons">
                <a href="login.php" class="btn-login">Войти</a>
                <a href="register.php" class="btn-register">Регистрация</a>
            </div>

        <?php else: ?>

            <?php
            if(isset($_GET['index'])){
                session_destroy();
                header('Location:index.php');
                exit;
            }
            ?>

            <div class="nav-buttons">
                <a href="history.php" class="btn-lk">Мои заявки</a>
                <a href="create.php" class="btn-create">Новая заявка</a>
                <a href="?index=1" class="btn-exit">Выход</a>
            </div>

        <?php endif; ?>

    </div>
</div>

<!-- Слайдер с помещениями -->
<div class="slideshow-container">

    <div class="mySlides fade">
        <img src="https://archdetali.ru/upload/iblock/720/7208f1739d6d3f2215668e35f9e32107.jpg" style="width:100%">
        <div class="text">Современные аудитории для деловых конференций</div>
    </div>

    <div class="mySlides fade">
        <img src="https://i.pinimg.com/736x/be/17/9c/be179c92c4763162310dc3eeaf86f28a.jpg" style="width:100%">
        <div class="text">Коворкинги для встреч, форумов и рабочих сессий</div>
    </div>

    <div class="mySlides fade">
        <img src="https://i.pinimg.com/originals/b4/5a/55/b45a550de5a8f2f5431c7dd94fd29a48.jpg" style="width:100%">
        <div class="text">Кинозалы для масштабных выступлений и презентаций</div>
    </div>

    <div class="mySlides fade">
        <img src="https://avatars.mds.yandex.net/i?id=fbcfb8ac7919cd96bb4f216073b0d12f_l-3523167-images-thumbs&ref=rim&n=13&w=1920&h=1080" style="width:100%">
        <div class="text">Быстрое оформление заявки на бронирование</div>
    </div>

    <a class="prev" onclick="plusSlides(-1)">❮</a>
    <a class="next" onclick="plusSlides(1)">❯</a>

</div>

<!-- Точки навигации -->
<div class="dot-container">
    <span class="dot active" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
    <span class="dot" onclick="currentSlide(4)"></span>
</div>

<script src="script/script.js"></script>

</body>
</html>