<!DOCTYPE html>
<html lang="en">
<head>
    <title>Table V04</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!--===============================================================================================-->
</head>
<body>
<?php
include "php/params_checker.php";
?>

</br>

<center>
    <form action="index.php" method="get">
        <button name="create" class="btn btn-success" value="" type="submit">Создать новый товар</button>
        <button name="remove" class="btn btn-danger" value="" type="submit">Удалить существующий</button>
        <input type="hidden" name="curpage" value="<?= $current_page ?>"/>
        <button name="page" class="btn btn-info" value="<?= $current_page - 1 ?>" type="submit">Предыдущая страница</button>
        <button name="page" class="btn btn-info" value="<?= $current_page + 1 ?>" type="submit">Следующая страница</button>
        <input type="submit" class="btn btn-primary" name="refresh" value="Обновить страницу"/>
    </form>
</center>

</br>

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Название товара</th>
            <th scope="col">Описание</th>
            <th scope="col">Цена</th>
            <th scope="col">Ссылка на товар</th>
        </tr>
    </thead>
    <tbody>
        <?php
        print_current_page($memcached, $db_connection, $current_page);
        ?>
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>
</html>