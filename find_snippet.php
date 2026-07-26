<?php
require_once('wp-load.php');
global $wpdb;

echo "--- Searching wp_posts ---\n";
$posts = $wpdb->get_results("SELECT ID, post_title, post_type, post_status FROM {$wpdb->posts} WHERE post_content LIKE '%personalizar_tabs_producto%'");
foreach ($posts as $post) {
    echo "Post ID: {$post->ID}, Title: {$post->post_title}, Type: {$post->post_type}, Status: {$post->post_status}\n";
}

echo "--- Searching wp_snippets ---\n";
$table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}snippets'");
if ($table_exists) {
    $snippets = $wpdb->get_results("SELECT id, name, active FROM {$wpdb->prefix}snippets WHERE code LIKE '%personalizar_tabs_producto%'");
    foreach ($snippets as $snippet) {
        echo "Snippet ID: {$snippet->id}, Name: {$snippet->name}, Active: {$snippet->active}\n";
    }
} else {
    echo "No wp_snippets table found.\n";
}
