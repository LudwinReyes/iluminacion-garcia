<?php
require_once('wp-load.php');
if (class_exists('Yoast\WP\Lib\Dependency_Injection\Container_Registry')) {
    $yoast_container = Yoast\WP\SEO\Main::get_container(); // Just loading wp-load is enough
}

// Get the Google Listings and Ads container
if (class_exists('Automattic\WooCommerce\GoogleListingsAndAds\Proxies\WC')) {
    echo "GLA proxy class exists!\n";
}

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

// Let's check how the plugin's validation behaves
$address = new Automattic\WooCommerce\GoogleListingsAndAds\Vendor\Google\Service\ShoppingContent\AccountAddress();
$address->setPostalCode($countries->get_base_postcode());
$address->setLocality($countries->get_base_city());
$address->setCountry($countries->get_base_country());
$address->setRegion($countries->get_base_state());

$street_address = sprintf('%s%s%s', $countries->get_base_address(), "\n", $countries->get_base_address_2());
$address->setStreetAddress($street_address);

$fields_to_validate = [
    'address_1' => $address->getStreetAddress(),
    'city'      => $address->getLocality(),
    'country'   => $address->getCountry(),
    'postcode'  => $address->getPostalCode(),
];

echo "Fields to validate: \n";
print_r($fields_to_validate);

$errors = array_filter(
    $fields_to_validate,
    function ( $field ) use ( $locale_settings, $fields_to_validate ) {
        $is_required = $locale_settings[ $field ]['required'] ?? true;
        $val = $fields_to_validate[ $field ];
        echo "Field $field (required: " . ($is_required ? 'yes' : 'no') . "), Value: '$val'\n";
        return $is_required && empty( $fields_to_validate[ $field ] );
    },
    ARRAY_FILTER_USE_KEY
);

echo "Errors: \n";
print_r(array_keys($errors));
