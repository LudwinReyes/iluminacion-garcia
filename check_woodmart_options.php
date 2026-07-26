<?php
require_once('wp-load.php');
$options = get_option('xts-woodmart-options');
if (!$options) {
    $options = get_option('woodmart_options');
}
if ($options) {
    echo "Found options!\n";
    foreach ($options as $key => $val) {
        if (is_string($val) && stripos($val, 'ficha') !== false) {
            echo "Key: $key, Value: " . substr($val, 0, 100) . "\n";
        }
        if (is_array($val)) {
            $serialized = serialize($val);
            if (stripos($serialized, 'ficha') !== false) {
                echo "Key (array): $key, Serialized: " . substr($serialized, 0, 200) . "\n";
            }
        }
    }
} else {
    echo "No options found.\n";
}
