<?php
require_once('wp-load.php');
$reflection = new ReflectionClass('Yoast\WP\Lib\Dependency_Injection\Container_Registry');
$method = $reflection->getMethod('get');
foreach ($method->getParameters() as $param) {
    echo $param->getName() . "\n";
}
