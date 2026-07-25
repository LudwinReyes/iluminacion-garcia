<?php
$o = get_option('wpseo_titles');
if (!$o || !is_array($o)) {
    $o = array();
}
$o['title-home-wpseo'] = 'ILUMINACIONES GARCÍA | Confianza para tu trabajo diario';
$o['metadesc-home-wpseo'] = 'Encuentra en Iluminaciones García la mejor selección de artículos de iluminación profesional y soluciones eléctricas en el Perú. ¡Cotiza hoy por WhatsApp!';
update_option('wpseo_titles', $o);
echo "Yoast Homepage Title and Meta Description updated successfully!\n";
