<?php
require_once('wp-load.php');
$product_obj = wc_get_product(19616);
if ($product_obj) {
    $post = get_post($product_obj->get_id());
    setup_postdata($post);
    $GLOBALS['product'] = $product_obj;
    $tabs = apply_filters('woocommerce_product_tabs', array());
    echo "Product: " . $product_obj->get_name() . " (ID: " . $product_obj->get_id() . ")\n";
    print_r($tabs);
} else {
    echo "Product 19616 not found\n";
}
