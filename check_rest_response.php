<?php
require_once('wp-load.php');
$request = new WP_REST_Request('GET', '/wc/gla/mc/contact-information');
$response = rest_do_request($request);
print_r($response->get_data());
