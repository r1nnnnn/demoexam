<?php
session_start();

// Проверяем, авторизован ли пользователь
if(!isset($_SESSION['user_id'])){
    die('Чтобы посмотреть историю заявок, необходимо войти в аккаунт.');
}

include('db.php');

// Обработка выхода
if(isset($_GET['index'])){
    session_destroy();
    header('Location:index.php');
    exit;
}

// Обработка отправки отзыва
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $con->query("
        UPDATE request 
        SET review='{$_POST['review']}' 
        WHERE id='{$_POST['request_id']}' 
        AND user_id='{$_SESSION['user_id']}'
    ");
}

// Получаем все заявки текущего пользователя
$query = $con->query("
    SELECT * FROM request 
    WHERE user_id='{$_SESSION['user_id']}'
");

if(!$query){
    die('Ошибка запроса: ' . $con->error);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет — Конференции.РФ</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

<!-- Шапка сайта -->
<div class="header">
    <div class="nav">

        <a href="index.php" class="logo">Конференции.РФ</a>

        <div class="nav-buttons">
            <a href="history.php" class="btn-active">Мои заявки</a>
            <a href="create.php" class="btn-create">Новая заявка</a>
            <a href="?index=1" class="btn-exit">Выйти</a>
        </div>

    </div>
</div>

<!-- Основной контент -->
<div class="container">

    <div class="booking-card">

        <div class="booking-header">
            <h1>История заявок</h1>
            <p>Здесь отображаются ваши заявки на бронирование помещений</p>
        </div>

        <?php
        $i = 0;

        while($request = $query->fetch_assoc()){
            $i++;

            echo "
            <div class='request-card'>
                <h2 style='text-align:center'>Заявка $i</h2>

                <b>Дата начала конференции:</b>
                {$request['date']}

                <b>Выбранное помещение:</b>
                {$request['curses']}

                <b>Способ оплаты:</b>
                {$request['payment']}

                <b>Статус заявки:</b>
                {$request['status']}
            ";

            if(!empty($request['review'])){
                echo "
                <b>Ваш отзыв:</b>
                {$request['review']}
                ";
            }

            if($request['status'] === 'Мероприятие завершено'){
                echo "
                <form method='POST'>
                    <b>Оставить отзыв</b>

                    <input 
                        type='hidden' 
                        name='request_id' 
                        value='{$request['id']}'
                    >

                    <input 
                        name='review' 
                        placeholder='Напишите отзыв о проведённом мероприятии' 
                        value='{$request['review']}'
                    >

                    <button class='btn-sub'>Оставить отзыв</button>
                </form>
                ";
            }

            echo "</div>";
        }

        if($i === 0){
            echo "
            <div class='request-card'>
                <p class='no-requests'>У вас пока нет заявок</p>
            </div>
            ";
        }
        ?>

    </div>

</div>

</body>
</html>