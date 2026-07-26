<?php
require_once('wp-load.php');
$slugs = array(
    'aplique-modelo-tortuga-para-exterior-e27-lightech',
    'luminaria-hermetico-led-wt120c-led40s-865-psu-l1200-philips',
    'luminaria-hermetico-2x36w-ip65-indiko-philips'
);
foreach ($slugs as $slug) {
    $posts = get_posts(array(
        'name' => $slug,
        'post_type' => 'product',
        'post_status' => 'any'
    ));
    if (!empty($posts)) {
        echo "$slug ID: " . $posts[0]->ID . "\n";
    } else {
        echo "$slug NOT FOUND\n";
    }
}
