<?php
require_once('wp-load.php');
if (function_exists('yoast_get_by_classname')) {
    $repository = yoast_get_by_classname('Yoast\WP\SEO\Repositories\Indexable_Repository');
    $builder = yoast_get_by_classname('Yoast\WP\SEO\Builders\Indexable_Builder');
    
    $indexable = $repository->find_by_id_and_type(4179, 'post');
    if ($indexable) {
        $indexable->delete();
    }
    
    $indexable = $repository->find_by_id_and_type(4179, 'post');
    $builder->build($indexable);
    echo "Indexable for post 4179 rebuilt successfully via global helper!\n";
} else {
    echo "yoast_get_by_classname function not found.\n";
}
