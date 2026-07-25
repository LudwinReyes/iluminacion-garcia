<?php
$o = get_option('wpseo');
if (!$o || !is_array($o)) {
    $o = array();
}
$o['company_or_person'] = 'company';
$o['company_name'] = 'ILUMINACIONES GARCÍA S.A.C.';
$o['company_logo'] = 'https://iluminacioneseyg.com/wp-content/uploads/2026/02/iluminaciones_logo.png';
update_option('wpseo', $o);
echo "Yoast Organization settings updated successfully!\n";
