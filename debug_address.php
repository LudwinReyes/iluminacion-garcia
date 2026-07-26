<?php
require_once('wp-load.php');
// Let's run the actual WooCommerce countries check
$countries = new WC_Countries();
echo "Base address: " . $countries->get_base_address() . "\n";
echo "Base address 2: " . $countries->get_base_address_2() . "\n";
echo "Base city: " . $countries->get_base_city() . "\n";
echo "Base postcode: " . $countries->get_base_postcode() . "\n";
echo "Base country: " . $countries->get_base_country() . "\n";
echo "Base state: " . $countries->get_base_state() . "\n";

// Now check what local settings WooCommerce has for PE
$locale = $countries->get_country_locale();
$locale_settings = $locale['PE'] ?? [];
echo "Locale settings for PE: \n";
print_r($locale_settings);
