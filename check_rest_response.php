<?php
require_once('wp-load.php');
$request = new WP_REST_Request('GET', '/google-listings-and-ads/v1/merchant/contact-information');
$response = rest_do_request($request);
print_r($response->get_data());
