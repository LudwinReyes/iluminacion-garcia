<?php
/**
 * Update WooCommerce product short descriptions to interlink orphan pages
 */
require_once( 'wp-load.php' );

// 1. Reflector LED BVP150 (ID: 20065) -> Link to Reflector LED BVP090 (ID: 18996)
$p1_id = 20065;
$p1_excerpt = get_post_field( 'post_excerpt', $p1_id );
if ( strpos( $p1_excerpt, 'BVP090' ) === false ) {
    $p1_new = $p1_excerpt . "\n<p>Para proyectos de menor escala, también disponemos del <a href=\"https://iluminacioneseyg.com/producto/reflector-led-bvp090-led08-cw-10w-6500k-120-277v-ip65-wb-psu-philips/\">Reflector LED BVP090 de 10W</a>.</p>";
    wp_update_post( array( 'ID' => $p1_id, 'post_excerpt' => $p1_new ) );
    echo "Product 20065 updated.\n";
} else {
    echo "Product 20065 already updated.\n";
}

// 2. Spot de piso 9w (ID: 19731) -> Link to Spot de piso Nuvora (ID: 19010)
$p2_id = 19731;
$p2_excerpt = get_post_field( 'post_excerpt', $p2_id );
if ( strpos( $p2_excerpt, 'nuvora' ) === false ) {
    $p2_new = $p2_excerpt . "\n<p>Si buscas una opción sin LED integrado para colocar tus propias bombillas, consulta el <a href=\"https://iluminacioneseyg.com/producto/spot-de-piso-para-foco-par30-38-e27-nuvora/\">Spot de piso Nuvora para foco PAR30/38</a>.</p>";
    wp_update_post( array( 'ID' => $p2_id, 'post_excerpt' => $p2_new ) );
    echo "Product 19731 updated.\n";
} else {
    echo "Product 19731 already updated.\n";
}

// 3. Luminaria publico 50w (ID: 19131) -> Link to Luminaria publico Macroled (ID: 18841)
$p3_id = 19131;
$p3_excerpt = get_post_field( 'post_excerpt', $p3_id );
if ( strpos( $p3_excerpt, 'Macroled' ) === false ) {
    $p3_new = $p3_excerpt . "\n<p>Conoce también la alternativa de <a href=\"https://iluminacioneseyg.com/producto/luminaria-de-alumbrado-publico-led-sl-50w-857-ip65-macroled/\">Luminaria LED SL-50W para alumbrado público</a> de Macroled.</p>";
    wp_update_post( array( 'ID' => $p3_id, 'post_excerpt' => $p3_new ) );
    echo "Product 19131 updated.\n";
} else {
    echo "Product 19131 already updated.\n";
}

// Clear cache
if ( function_exists( 'wp_cache_flush' ) ) {
    wp_cache_flush();
}
echo "Interlinking complete.\n";
