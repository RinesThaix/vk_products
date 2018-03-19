<?php
/**
 * Created by PhpStorm.
 * User: RinesThaix
 * Date: 19.03.2018
 * Time: 16:09
 */

const DB_HOST = "localhost";
const DB_PORT = 3306;
const DB_USER = "root";
const DB_PASS = "root";
const DB_NAME = "vk_test";
$db_connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

?>