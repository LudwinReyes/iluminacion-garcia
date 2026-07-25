<?php
require_once('wp-load.php');
global $wp_query;
$wp_query->is_home = false;
$wp_query->is_front_page = true;
$wp_query->queried_object = get_post(4179);
$wp_query->queried_object_id = 4179;

ob_start();
wp_head();
$head = ob_get_clean();

echo "=== WP_HEAD CONTENT ===\n";
// Print only lines containing title, description, or yoast
foreach (explode("\n", $head) as $line) {
    if (stripos($line, 'title') !== false || stripos($line, 'description') !== false || stripos($line, 'yoast') !== false) {
        echo trim($line) . "\n";
    }
}
