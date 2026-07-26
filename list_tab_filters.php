<?php
require_once('wp-load.php');
global $wp_filter;
if (isset($wp_filter['woocommerce_product_tabs'])) {
    echo "Registered hooks for woocommerce_product_tabs:\n";
    foreach ($wp_filter['woocommerce_product_tabs']->callbacks as $priority => $callbacks) {
        echo "Priority: $priority\n";
        foreach ($callbacks as $idx => $callback) {
            echo "  Function: " . (is_string($callback['function']) ? $callback['function'] : (is_array($callback['function']) ? get_class($callback['function'][0]) . '->' . $callback['function'][1] : 'Closure')) . "\n";
        }
    }
} else {
    echo "No filters registered for woocommerce_product_tabs\n";
}
