<?php
require_once('wp-load.php');
if (function_exists('WC')) {
    print_r(WC()->countries->get_states('PE'));
} else {
    echo "WooCommerce not loaded\n";
}
