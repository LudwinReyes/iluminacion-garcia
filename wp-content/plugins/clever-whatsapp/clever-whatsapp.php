<?php

/**
 * Plugin Name: Clever WhatsApp Chat
 * Plugin URI:  https://cleveraddon.com/clever-whatsapp/
 * Description: Clever WhatsApp Chat is the fastest way for your website visitors to get in touch with you. Stay always easy-to-reach for users via their favourite messenger. 
 * Version:     1.0.0
 * Author:      CleverSoft
 * Author URI:  https://cleversoft.co/
 * License:     GPLv2 or later
 * Text Domain: cleverwa
 */

/* Avoid directly access. */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/* Define the constants */
if ( ! defined( 'CLEVERWA_PREFIX' ) ) {
	define( 'CLEVERWA_PREFIX', 'cleverwa' );
}
if ( ! defined( 'CLEVERWA_PLUGIN_DIR' ) ) {
	define( 'CLEVERWA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'CLEVERWA_CLASSES_DIR' ) ) {
	define( 'CLEVERWA_CLASSES_DIR', CLEVERWA_PLUGIN_DIR . 'includes/classes' );
}
if ( ! defined( 'CLEVERWA_CONTROLLERS_DIR' ) ) {
	define( 'CLEVERWA_CONTROLLERS_DIR', CLEVERWA_PLUGIN_DIR . 'includes/controllers' );
}
if ( ! defined( 'CLEVERWA_VIEWS_DIR' ) ) {
	define( 'CLEVERWA_VIEWS_DIR', CLEVERWA_PLUGIN_DIR . 'includes/views' );
}
if ( ! defined( 'CLEVERWA_PLUGIN_BASENAME' ) ) {
	define( 'CLEVERWA_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'CLEVERWA_PLUGIN_URL' ) ) {
	define( 'CLEVERWA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'CLEVERWA_SETTINGS_NAME' ) ) {
	define( 'CLEVERWA_SETTINGS_NAME', 'cleverwa_settings' );
}
if ( ! defined( 'CLEVERWA_PLUGIN_BOOTSTRAP_FILE' ) ) {
	define( 'CLEVERWA_PLUGIN_BOOTSTRAP_FILE', __FILE__ );
}

/* Classes loaded automatically. */
if( ! function_exists( 'cleverwa_class_auto_loader' ) ) {

	function cleverwa_class_auto_loader( $class ) {
		$class_file = CLEVERWA_CLASSES_DIR . '/' . $class . '.php';
		if( is_file( $class_file ) && ! class_exists( $class ) ) {
			include_once( $class_file );
			return;
		}
	}

}
spl_autoload_register('cleverwa_class_auto_loader');

/* Load modules. */
new CleverDisplay();
new CleverShortcode();
new CleverActivation();
new CleverScriptsAndStyles();
new CleverMenuLink();
new CleverAccounts();
new CleverController();
new CleverAjax();
new CleverWoocommerce();

?>
