<?php
/**
 * Created by PhpStorm.
 * User: RinesThaix
 * Date: 20.03.2018
 * Time: 0:44
 */

include "printer.php";

if (isset($_POST['create'])) {
    create_random_product($db_connection);
}

if (isset($_POST['remove'])) {
    delete_random_product($db_connection);
}

$current_page = 0;

if (isset($_POST['page'])) {
    $current_page = $_POST['page'];
} else if (isset($_POST['curpage'])) {
    $current_page = $_POST['curpage'];
}

if ($current_page < 0)
    $current_page = 0;