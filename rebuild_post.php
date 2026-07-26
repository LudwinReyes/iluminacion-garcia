<?php
require_once('wp-load.php');
if (class_exists('Yoast\WP\SEO\Main')) {
    $yoast_container = Yoast\WP\SEO\Main::get_container();
    $repository = $yoast_container->get('Yoast\WP\SEO\Repositories\Indexable_Repository');
    $builder = $yoast_container->get('Yoast\WP\SEO\Builders\Indexable_Builder');
    
    // Check if indexable exists and delete it to force build
    $indexable = $repository->find_by_id_and_type(4179, 'post');
    if ($indexable) {
        // Yoast indexables are active record models, we can call delete() on them
        $indexable->delete();
    }
    
    // Re-fetch (this creates a new empty indexable model)
    $indexable = $repository->find_by_id_and_type(4179, 'post');
    
    // Build metadata
    $builder->build($indexable);
    echo "Indexable for post 4179 rebuilt successfully!\n";
} else {
    echo "Yoast Main class not found.\n";
}
