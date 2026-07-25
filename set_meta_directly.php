<?php
require_once('wp-load.php');
update_post_meta(4179, '_yoast_wpseo_title', 'Iluminaciones García | Artículos de Iluminación y Soluciones Eléctricas');
update_post_meta(4179, '_yoast_wpseo_metadesc', 'Encuentra en Iluminaciones García la mejor selección de artículos de iluminación profesional y soluciones eléctricas en el Perú. ¡Cotiza hoy por WhatsApp!');
clean_post_cache(4179);
echo "Updated successfully!\n";
