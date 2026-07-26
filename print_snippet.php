<?php
require_once('wp-load.php');
$post = get_post(17022);
if ($post) {
    echo "=== Title: {$post->post_title} ===\n";
    echo $post->post_content;
    echo "\n===================================\n";
} else {
    echo "Post 17022 not found.\n";
}
