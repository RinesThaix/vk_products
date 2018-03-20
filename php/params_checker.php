<?php
/**
 * Created by PhpStorm.
 * User: RinesThaix
 * Date: 20.03.2018
 * Time: 0:44
 */

include "printer.php";

if (isset($_GET['create'])) {
    create_random_product($memcached, $db_connection);
    print_alert('Новый товар успешно создан, кеш инвалидирован.');
}

if (isset($_GET['create-all'])) {
    create_them_all($memcached, $db_connection);
    print_alert('Готово!');
}

if (isset($_GET['remove'])) {
    delete_random_product($memcached, $db_connection);
    print_alert('Один из существующих товаров удален, кеш инвалидирован.');
}

$current_page = 0;

if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
} else if (isset($_GET['curpage'])) {
    $current_page = $_GET['curpage'];
}

if ($current_page < 0)
    $current_page = 0;