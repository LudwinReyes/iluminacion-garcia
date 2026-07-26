<?php
$yoast_classes = [];
foreach (get_declared_classes() as $class) {
    if (stripos($class, 'Yoast') !== false || stripos($class, 'WPSEO') !== false) {
        $yoast_classes[] = $class;
    }
}
print_r(array_slice($yoast_classes, 0, 50));
