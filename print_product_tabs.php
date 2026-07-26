<?php
require_once('wp-load.php');
$args = array(
    'limit' => 1,
    'status' => 'publish',
);
$products = wc_get_products($args);
if (!empty($products)) {
    $product_obj = $products[0];
    $post = get_post($product_obj->get_id());
    setup_postdata($post);
    $GLOBALS['product'] = $product_obj;
    $tabs = apply_filters('woocommerce_product_tabs', array());
    echo "Product: " . $product_obj->get_name() . " (ID: " . $product_obj->get_id() . ")\n";
    print_r(array_keys($tabs));
} else {
    echo "No product found\n";
}
