<?php

/**
 * This class catches the admin_init hook and decide which controller
 * file to load based on the query string.
 */

class CleverController {

	public function __construct () {

		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'clever_get_controller' ) );
		}
	}

	public function clever_get_controller () {
		$page = isset( $_GET['page'] ) ? strtolower( $_GET['page'] ) : '';
		$prefix = CLEVERWA_PREFIX . '_';
		$file_name = substr( $page, 0, strlen( $prefix ) ) === $prefix
			? substr( $page, strlen( $prefix ), strlen( $page ) )
			: $page
			;
		$file_name = str_replace('_', ' ', $file_name);
		$file_name = "Clever".ucwords($file_name);
		$file_name = str_replace(' ', '', $file_name);
		$path_to_controller = CLEVERWA_CONTROLLERS_DIR . '/' . $file_name . '.php';

		if ( file_exists( $path_to_controller ) ) {
			include_once( $path_to_controller );
		}

	}

}

?>
