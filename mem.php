<?php
/**
 * Created by PhpStorm.
 * User: RinesThaix
 * Date: 19.03.2018
 * Time: 16:26
 */

$mem_host = "localhost";
$mem_port = 11211;
$memcached = new Memcached();
$memcached->addServer($mem_host, $mem_port);