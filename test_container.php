<?php
require_once('wp-load.php');
$reflection = new ReflectionClass('Yoast\WP\Lib\Dependency_Injection\Container_Registry');
$prop = $reflection->getProperty('containers');
$prop->setAccessible(true);
print_r(array_keys($prop->getValue()));
