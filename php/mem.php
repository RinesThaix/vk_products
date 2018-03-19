<?php
/**
 * Created by PhpStorm.
 * User: RinesThaix
 * Date: 19.03.2018
 * Time: 16:26
 */

const MEM_HOST = "localhost";
const MEM_PORT = 8000;
$memcached = new Memcached();
$memcached->addServer(MEM_HOST, MEM_PORT);