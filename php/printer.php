<?php
/**
 * Created by PhpStorm.
 * User: RinesThaix
 * Date: 20.03.2018
 * Time: 0:39
 */

include "db.php";
include "mem.php";
include "storage.php";

/**
 * Represents products of the given page as table rows on user-side
 * @param $memcached Memcached memcached instance
 * @param $db_connection mysqli database connection
 * @param $current_page_id int identifier of the current page (starts from 0)
 */
function print_page($memcached, $db_connection, $current_page_id)
{
    print_products(get_products_on_page($memcached, $db_connection, retrieveProductsAmountInDatabase($memcached, $db_connection), $current_page_id));
}

/**
 * Represent products of the given array as table rows on user-side
 * @param $products_array array the array of products
 */
function print_products($products_array)
{
    foreach ($products_array as $product) {
        print_product($product);
    }
}

/**
 * Represents given product as a table row on user-side
 * @param $product array product array-configuration, containing it's id, name, description, price and url in given order
 */
function print_product($product)
{
    echo '
        <tr>
            <th scope="row">#' . $product[0] . '</th>
            <td>' . $product[1] . '</td>
            <td>' . $product[2] . '</td>
            <td>' . $product[3] . ' ₽</td>
            <td><a href="' . $product[4] . '">' . $product[4] . '</a></td>
        </tr>
    ';
}