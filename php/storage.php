<?php
/**
 * Created by PhpStorm.
 * User: RinesThaix
 * Date: 20.03.2018
 * Time: 0:37
 */

const PER_PAGE = 100;

/**
 * Creates one new product of random configuration
 * @param $db_connection mysqli database connection
 */
function create_random_product($db_connection)
{
    $id = rand(1000000, 9999999);
    $name = "Продукт #" . $id;
    $description = "Описание продукта #" . $id;
    $price = rand(100, 999);
    $url = "https://vk.com/product/" . $id;
    $db_connection->query("INSERT INTO products (`name`, `description`, `price`, `url`) VALUES ('" . $name . "', '" . $description . "', " . $price . ", '" . $url . "')");
    print_alert('Новый товар успешно создан и будет отображен на странице после обновления кеша.');
}

/**
 * Creates one million random products of random configurations
 * @param $db_connection mysqli database connection
 */
function create_them_all($db_connection)
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
}

/**
 * Used to delete a random product, but in reality removes the one with lowest id
 * @param $db_connection mysqli database connection
 */
function delete_random_product($db_connection)
{
    $db_connection->query("DELETE FROM products LIMIT 1");
    print_alert('Один из существующих товаров удален. Он исчезнет из таблицы после обновления кеша.');
}

/**
 * Gets all products on the given page
 * @param $memcached Memcached memcached instance
 * @param $db_connection mysqli database connection
 * @param $num_rows int number of rows (products) in database
 * @param $page_id int identifier of the current page (starts from 0)
 * @return mixed it's an array of products
 */
function get_products_on_page($memcached, $db_connection, $num_rows, $page_id)
{
    $page = $memcached->get("page" . $page_id);
    if ($page === FALSE) {
        $result = $db_connection->query('SELECT * FROM products WHERE id < ' . ($num_rows - $page_id * PER_PAGE) . ' ORDER BY id DESC LIMIT ' . PER_PAGE);
        $rows = $result->fetch_all();
        if ($memcached->set("page" . $page_id, $rows, 60) === FALSE) {
            echo "<script type='text/javascript'>alert('Could not save data to memcached!!');</script>";
        }
        return $rows;
    } else {
//        echo "<script type='text/javascript'>alert('Retrieved data from memcached');</script>";
        return $page;
    }
}

/**
 * Retrieves amount of rows (products) in database
 * @param $memcached Memcached memcached instance
 * @param $db_connection mysqli database connection
 * @return int amount of rows (products) in database
 */
function retrieveProductsAmountInDatabase($memcached, $db_connection)
{
    $rows = $memcached->get('rows-count');
    if ($rows === FALSE) {
        $rows = $db_connection->query("SELECT COUNT(*) FROM products");
        $result = $rows->fetch_assoc()['COUNT(*)'];
        $memcached->set('rows-count', $result, 30);
        return $result;
    } else {
        return $rows;
    }
}

/**
 * Internal function to create alerts
 * @param $message string the message to be printed
 */
function print_alert($message) {
    echo "<script type='text/javascript'>alert('" . $message . "');</script>";
}