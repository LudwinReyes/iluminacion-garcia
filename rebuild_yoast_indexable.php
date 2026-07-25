<?php
require_once('wp-load.php');
if (class_exists('Yoast\WP\SEO\Container_Registry')) {
    $repository = Yoast\WP\SEO\Container_Registry::get_instance()->get('Yoast\WP\SEO\Repositories\Indexable_Repository');
    
    // Find and delete the existing indexable for post 4179 to force a clean rebuild
    $indexable = $repository->find_by_id_and_type(4179, 'post');
    if ($indexable) {
        $indexable->delete();
    }
    
    // Re-fetch (this will create a new empty indexable object if not found)
    $indexable = $repository->find_by_id_and_type(4179, 'post');
    
    // Build the indexable
    $builder = Yoast\WP\SEO\Container_Registry::get_instance()->get('Yoast\WP\SEO\Builders\Indexable_Builder');
    $builder->build($indexable);
    
    echo "Indexable for post 4179 rebuilt successfully!\n";
} else {
    echo "Yoast SEO classes not found.\n";
}
