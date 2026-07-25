<?php

class CleverScriptsAndStyles {

	public function __construct () {

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'clever_admin_enqueue_scripts' ) );
		}

	}

	/**
	 * Enqueue scripts and styles only for our plugin.
	 */
	public function clever_admin_enqueue_scripts ( $hook ) {

		global $pagenow;

		$settings_pages = array(
			CLEVERWA_PREFIX . '_settings',
			CLEVERWA_PREFIX . '_floating_widget',
			CLEVERWA_PREFIX . '_woocommerce_button'
		);

		$plugin_data = get_file_data( CLEVERWA_PLUGIN_BOOTSTRAP_FILE, array( 'version' ) );
		$plugin_version = isset( $plugin_data[0] ) ? $plugin_data[0] : false;

		if ( ( 'admin.php' === $pagenow && isset( $_GET['page'] ) && in_array( strtolower( $_GET['page'] ), $settings_pages ) ) ||
				'cleverwa_accounts' === get_post_type() ) {

			wp_enqueue_media();

			wp_enqueue_style( 'jquery-minicolors', CLEVERWA_PLUGIN_URL . 'assets/css/jquery-minicolors.css', array(), $plugin_version );
			wp_enqueue_style( 'cleverwa-admin', CLEVERWA_PLUGIN_URL . 'assets/css/admin.css', array(), $plugin_version );

			wp_enqueue_script( 'jquery-minicolors', CLEVERWA_PLUGIN_URL . 'assets/js/vendor/jquery.minicolors.min.js', array( 'jquery' ), $plugin_version, true );
			wp_enqueue_script( 'cleverwa-admin', CLEVERWA_PLUGIN_URL . 'assets/js/admin.js', array( 'jquery' ), $plugin_version, true );
		}

	}

}

?>
