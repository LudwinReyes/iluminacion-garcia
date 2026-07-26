<?php
require_once('wp-load.php');
$reflection = new ReflectionClass('Yoast\WP\Lib\Dependency_Injection\Container_Registry');
foreach ($reflection->getMethods() as $method) {
    echo $method->getName() . "\n";
}
