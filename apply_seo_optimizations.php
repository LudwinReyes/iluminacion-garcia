<?php
require_once('wp-load.php');

// 1. Optimize Taxonomy: Dicroicos (ID 2391)
$tax_meta = get_option('wpseo_taxonomy_meta');
if (!is_array($tax_meta)) {
    $tax_meta = array();
}
if (!isset($tax_meta['product_cat'])) {
    $tax_meta['product_cat'] = array();
}

$tax_meta['product_cat'][2391] = array(
    'wpseo_title' => 'Dicroicos LED y Accesorios al por Mayor | Iluminaciones García',
    'wpseo_desc'  => 'Compra Dicroicos LED y accesorios al por mayor y menor. Encuentra marcas líderes como Philips, Ledvance y más. Envíos inmediatos a todo el Perú.',
);

update_option('wpseo_taxonomy_meta', $tax_meta);
echo "SUCCESS: Updated taxonomy meta for Dicroicos (ID 2391)\n";


// 2. Optimize Product: Aplique Modelo Tortuga (ID 19372)
update_post_meta(19372, '_yoast_wpseo_title', 'Aplique Modelo Tortuga Exterior E27 Lightech | Iluminaciones García');
update_post_meta(19372, '_yoast_wpseo_metadesc', 'Adquiere el Aplique Modelo Tortuga E27 Lightech de alta resistencia para exteriores. Ideal para jardines y terrazas. ¡Cotiza al por mayor aquí!');
echo "SUCCESS: Updated product meta for Aplique Modelo Tortuga (ID 19372)\n";


// 3. Optimize Product: Luminaria Hermética WT120C Philips (find by slug)
$posts_wt120c = get_posts(array(
    'name' => 'luminaria-hermetica-led-wt120c-led40s-865-psu-l1200-philips',
    'post_type' => 'product',
    'post_status' => 'any'
));
if (!empty($posts_wt120c)) {
    $id_wt120c = $posts_wt120c[0]->ID;
    update_post_meta($id_wt120c, '_yoast_wpseo_title', 'Luminaria Hermética LED WT120C Philips | Iluminaciones García');
    update_post_meta($id_wt120c, '_yoast_wpseo_metadesc', 'Luminaria hermética LED WT120C Philips de 1200mm. Máxima protección IP65 contra agua y polvo. Ideal para almacenes e industrias. ¡Envíos a nivel nacional!');
    echo "SUCCESS: Updated product meta for WT120C (ID $id_wt120c)\n";
} else {
    echo "WARNING: Product WT120C not found.\n";
}


// 4. Optimize Product: Luminaria Hermética Indiko 2x36W (ID 19204)
update_post_meta(19204, '_yoast_wpseo_title', 'Luminaria Hermética Indiko 2x36W IP65 Philips | Iluminaciones García');
update_post_meta(19204, '_yoast_wpseo_metadesc', 'Encuentra la Luminaria Hermética Indiko 2x36W IP65 de Philips. Diseñada para entornos exigentes y húmedos. ¡Calidad certificada al mejor precio!');
echo "SUCCESS: Updated product meta for Indiko 2x36W (ID 19204)\n";

// Clear Litespeed/WP cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}
