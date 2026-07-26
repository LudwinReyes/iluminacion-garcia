<?php
require_once('wp-load.php');
$server = rest_get_server();
$routes = array_keys($server->get_routes());
foreach ($routes as $route) {
    if (stripos($route, 'gla') !== false) {
        echo $route . "\n";
    }
}
