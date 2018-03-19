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

function print_current_page($memcached, $db_connection, $current_page_id)
{
    print_products(get_products_on_page($memcached, $db_connection, retrieveProductsAmountInDatabase($memcached, $db_connection), $current_page_id));
}

function print_products($products_array)
{
    foreach ($products_array as $product) {
        print_product($product);
    }
}

function print_product($product)
{
    echo '
        <tr>
            <th scope="row">' . $product[0] . '</th>
            <td>' . $product[1] . '</td>
            <td>' . $product[2] . '</td>
            <td>' . $product[3] . '</td>
            <td><a href="' . $product[4] . '">' . $product[4] . '</a></td>
        </tr>
    ';
}