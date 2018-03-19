<?php
/**
 * Created by PhpStorm.
 * User: RinesThaix
 * Date: 19.03.2018
 * Time: 15:48
 */
include "db.php";
include "mem.php";

$num_rows = retrieveRowsCount();
$per_page = 20;
$selected_page = 0;

if(isset($_GET['create'])) {
    create_random_product();
    echo 'Новый продукт создан!</br></br>';
}

if(isset($_GET['remove'])) {
    delete_random_product();
    echo 'Существующий товар удален!</br></br>';
}

if(isset($_GET['page'])) {
    $selected_page = $_GET['page'];
}else if(isset($_GET['curpage'])) {
    $selected_page = $_GET['curpage'];
}


if($selected_page < 0)
    $selected_page = 0;

function list_products($products_array) {
    foreach ($products_array as $product) {
        echo 'ID=' . $product[0] . ', NAME=' . $product[1] . ', DESC=' . $product[2], ', PRICE=' . $product[3] . ', URL=<a href="' . $product[4] . '">' . $product[4] . '</a></br>';
    }
    echo '</br>';
}

function retrieveRowsCount() {
    global $memcached;
    $rows = $memcached->get('rows-count');
    if($rows === FALSE) {
        global $db_connection;
        $rows = $db_connection->query("SELECT COUNT(*) FROM products");
        $result = $rows->fetch_assoc()['COUNT(*)'];
        $memcached->set('rows-count', $result, 30);
        return $result;
    }else {
        return $rows;
    }
}

/**
 * @param $page_id int начиная с 0
 * @return mixed|null
 */
function get_products_on_page($page_id) {
    global $memcached;
    $page = $memcached->get("page" . $page_id);
    if($page === FALSE) {
        global $per_page, $db_connection, $num_rows;
        $result = $db_connection->query('SELECT * FROM products WHERE id < ' . ($num_rows - $page_id * $per_page) . ' ORDER BY id DESC LIMIT ' . $per_page);
        $rows = $result->fetch_all();
        if($memcached->set("page" . $page_id, $rows, 60) === FALSE) {
            echo '!! Could not save to MemCached !!</br></br>';
        }
        return $rows;
    }else {
        echo 'Retrieved from MemCached</br></br>';
        return $page;
    }
}

function create_random_product() {
    global $db_connection;
    $id = rand(1000000, 9999999);
    $name = "Продукт #" . $id;
    $description = "Описание продукта #" . $id;
    $price = rand(100, 999);
    $url = "https://vk.com/product/" . $id;
    $db_connection->query("INSERT INTO products (`name`, `description`, `price`, `url`) VALUES ('" . $name . "', '" . $description . "', " . $price . ", '" . $url . "')");
}

function create_them_all() {
    global $db_connection;
    for($j = 0; $j < 1000; ++$j) {
        $query = 'INSERT INTO products (`name`, `description`, `price`, `url`) VALUES ';
        for($i = 0; $i < 1000; ++$i) {
            $id = rand(1000000, 9999999);
            $name = "Продукт #" . $id;
            $description = "Описание продукта #" . $id;
            $price = rand(100, 999);
            $url = "https://vk.com/product/" . $id;
            $query .= "('" . $name . "', '" . $description . "', " . $price . ", '" . $url . "')";
            if($i < 999)
                $query .= ', ';
            else
                $query .= ';';
        }
        $db_connection->query($query);
    }
}

function delete_random_product() {
    global $db_connection;
    $db_connection->query("DELETE FROM products LIMIT 1");
}

//create_them_all();
list_products(get_products_on_page($selected_page));

echo '<html>
<form action="index.php" method="get">
    <button name="create" value="" type="submit">Создать новый товар</button>
    <button name="remove" value="" type="submit">Удалить существующий</button>
    <input type="hidden" name="curpage" value="' . $selected_page . '"/>
    <button name="page" value="' . ($selected_page - 1) . '" type="submit">Предыдущая страница</button>
    <button name="page" value="' . ($selected_page + 1) . '" type="submit">Следующая страница</button>
    <input type="submit" class="button" name="refresh" value="Обновить страницу" />
</form>
</html>';

?>
