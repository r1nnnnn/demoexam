<?php
include('db.php');
session_start();

if(!isset($_SESSION['admin']) || !$_SESSION['admin']){
    die('Чтобы посмотреть панель администратора, необходимо войти в аккаунт администратора.');
}

if(isset($_GET['index'])){
    session_destroy();
    header('Location:index.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $query = $con->query("
        UPDATE request 
        SET status='{$_POST['status']}' 
        WHERE id={$_POST['request_id']}
    ");

    if(!$query){
        die('Ошибка обновления: ' . $con->error);
    }
}

$query = $con->query("
    SELECT request.*, users.login, users.fullname 
    FROM request 
    INNER JOIN users ON request.user_id = users.id
");

if(!$query){
    die('Ошибка запроса: ' . $con->error);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора — Конференции.РФ</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

<div class="header">
    <div class="nav">

        <a href="index.php" class="logo">Конференции.РФ</a>

        <div class="nav-buttons">
            <a href="admin.php" class="btn-active">Панель администратора</a>
            <a href="?index=1" class="btn-exit">Выход</a>
        </div>

    </div>
</div>

<div class="container">

    <div class="admin-card">

        <div class="admin-header">
            <h1>Панель администратора</h1>
            <p>Просмотр и изменение статусов заявок на бронирование помещений</p>
        </div>

        <?php
        $i = 0;

        while($request = $query->fetch_assoc()){
            $i++;

            echo "
            <div class='request-card'>

                <h2>Заявка $i от {$request['login']}</h2>

                <b>ФИО:</b>
                {$request['fullname']}

                <b>Дата и время начала конференции:</b>
                {$request['date']}

                <b>Выбранное помещение:</b>
                {$request['curses']}

                <b>Способ оплаты:</b>
                {$request['payment']}

                <b>Отзыв пользователя:</b>
                {$request['review']}

                <form action='' method='POST'>

                    <input 
                        type='hidden' 
                        name='request_id' 
                        value='{$request['id']}'
                    >

                    <label>Статус заявки</label>

                    <select name='status'>
                        <option " . ($request['status'] == 'Новая' ? 'selected' : '') . " value='Новая'>Новая</option>
                        <option " . ($request['status'] == 'Мероприятие назначено' ? 'selected' : '') . " value='Мероприятие назначено'>Мероприятие назначено</option>
                        <option " . ($request['status'] == 'Мероприятие завершено' ? 'selected' : '') . " value='Мероприятие завершено'>Мероприятие завершено</option>
                    </select>

                    <button type='submit' class='btn-sub'>Сохранить статус</button>

                </form>

            </div>
            ";
        }

        if($i === 0){
            echo "
            <div class='request-card'>
                <p class='no-requests'>Заявок пока нет</p>
            </div>
            ";
        }
        ?>

    </div>

</div>

</body>
</html>