<?php
/**
 * Created by PhpStorm.
 * User: RinesThaix
 * Date: 20.03.2018
 * Time: 0:37
 */

const PER_PAGE = 250;

/**
 * Creates one new product of random configuration
 * @param $memcached Memcached memcached instance
 * @param $db_connection mysqli database connection
 */
function create_random_product($memcached, $db_connection)
{
    $id = rand(1000000, 9999999);
    $name = "Продукт #" . $id;
    $description = "Описание продукта #" . $id;
    $price = rand(100, 999);
    $url = "https://vk.com/product/" . $id;
    $db_connection->query("INSERT INTO products (`name`, `description`, `price`, `url`) VALUES ('" . $name . "', '" . $description . "', " . $price . ", '" . $url . "')");
    invalidate_cache($memcached);
    print_alert('Новый товар успешно создан, кеш инвалидирован.');
}

/**
 * Creates one million random products of random configurations
 * @param $memcached Memcached memcached instance
 * @param $db_connection mysqli database connection
 */
function create_them_all($memcached, $db_connection)
{
    for ($j = 0; $j < 1000; ++$j) {
        $query = 'INSERT INTO products (`name`, `description`, `price`, `url`) VALUES ';
        for ($i = 0; $i < 1000; ++$i) {
            $id = rand(1000000, 9999999);
            $name = "Продукт #" . $id;
            $description = "Описание продукта #" . $id;
            $price = rand(100, 999);
            $url = "https://vk.com/product/" . $id;
            $query .= "('" . $name . "', '" . $description . "', " . $price . ", '" . $url . "')";
            if ($i < 999)
                $query .= ', ';
            else
                $query .= ';';
        }
        $db_connection->query($query);
    }
    invalidate_cache($memcached);
    print_alert('Готово!');
}

/**
 * Used to delete a random product, but in reality removes the one with lowest id
 * @param $memcached Memcached memcached instance
 * @param $db_connection mysqli database connection
 */
function delete_random_product($memcached, $db_connection)
{
    $db_connection->query("DELETE FROM products LIMIT 1");
    invalidate_cache($memcached);
    print_alert('Один из существующих товаров удален, кеш инвалидирован.');
}

/**
 * Gets all products on the given page
 * @param $memcached Memcached memcached instance
 * @param $db_connection mysqli database connection
 * @param $page_id int identifier of the current page (starts from 0)
 * @return mixed it's an array of products
 */
function get_products_on_page($memcached, $db_connection, $page_id)
{
    $page = $memcached->get("page" . $page_id);
    if ($page === FALSE) {
        $max = $db_connection->query("SELECT MAX(id) FROM products")->fetch_assoc()['MAX(id)'];
        $result = $db_connection->query('SELECT * FROM products WHERE id < ' . ($max - $page_id * PER_PAGE) . ' ORDER BY id DESC LIMIT ' . PER_PAGE);
        $rows = $result->fetch_all();
        if ($memcached->set("page" . $page_id, $rows, 600) === FALSE) {
            echo "<script type='text/javascript'>alert('Could not save data to memcached!!');</script>";
        }
        return $rows;
    } else {
        return $page;
    }
}

/**
 * Invalidates all data from memcached
 * @param $memcached Memcached memcached instance
 */
function invalidate_cache($memcached) {
    $memcached->flush();
}

/**
 * Internal function to create alerts
 * @param $message string the message to be printed
 */
function print_alert($message) {
    echo "<script type='text/javascript'>alert('" . $message . "');</script>";
}