<?php
require_once('wp-load.php');
if (class_exists('Yoast\WP\Lib\Dependency_Injection\Container_Registry')) {
    $repository = Yoast\WP\Lib\Dependency_Injection\Container_Registry::get('Yoast\WP\SEO\Repositories\Indexable_Repository', 'wpseo');
    $builder = Yoast\WP\Lib\Dependency_Injection\Container_Registry::get('Yoast\WP\SEO\Builders\Indexable_Builder', 'wpseo');
    
    $indexable = $repository->find_by_id_and_type(4179, 'post');
    if ($indexable) {
        $indexable->delete();
    }
    
    $indexable = $repository->find_by_id_and_type(4179, 'post');
    $builder->build($indexable);
    echo "Indexable for post 4179 rebuilt successfully using Container_Registry static get!\n";
} else {
    echo "Container_Registry class not found.\n";
}
