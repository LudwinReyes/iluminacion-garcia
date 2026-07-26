<?php
require_once('wp-load.php');
$admins = get_users(['role' => 'administrator']);
if (!empty($admins)) {
    $admin = $admins[0];
    wp_set_current_user($admin->ID);
    echo "Logged in as administrator: " . $admin->user_login . "\n";
} else {
    echo "No administrator found.\n";
}

$request = new WP_REST_Request('GET', '/wc/gla/mc/contact-information');
$response = rest_do_request($request);
print_r($response->get_data());
