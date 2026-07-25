<?php

/**
 * This class is meant to bundle miscellaneous functionalities
 */

class CleverUtils {

	private static $stateOptionName = CLEVERWA_SETTINGS_NAME;
	private static $states = array();
	private static $view;
	private static $impressions = array();
	private static $itIsMobileDevice = null;

	/**
	 * Setting a vew file to use. This method is used in
	 * controller files.
	 */
	public static function clever_set_view ( $view ) {
		self::$view = $view;
	}

	/**
	 * Getting the view file. Used in CleverMenuLink().
	 */
	public static function clever_get_view () {

		$view = self::$view;

		$path_to_view = CLEVERWA_VIEWS_DIR . '/' . $view . '.php';

		if ( file_exists( $path_to_view ) ) {
			include_once( $path_to_view );
		}
		else {
			if ( ! self::$view ) {
				echo '<p style="color: red;">' . esc_html__( 'Something is wrong: The view is not set yet. Please contact the developer.', 'cleverwa' ) . '</p>';
			}
			else {
				echo '<p style="color: red;">' . esc_html__( 'Something is wrong: The view not found. Please contact the developer.', 'cleverwa' ) . '</p>';
			}
		}

	}

	/**
	 * Used only once during plugin activation. Making sure that
	 * we have the option.
	 */
	public static function clever_prepare_settings () {
		add_option( self::$stateOptionName );
	}

	public static function clever_update_setting ( $key, $value ) {
		$option = get_option( self::$stateOptionName );
		$data = array();

		if ( $option ) {
			$data = json_decode( $option, true );
		}
		$data[ $key ] = $value;

		update_option( self::$stateOptionName, json_encode( $data ), true );
	}

	public static function clever_get_setting ( $key, $default = '' ) {
		$option = get_option( self::$stateOptionName );
		$data = json_decode( $option, true );
		if ( $data && isset( $data[ $key ] ) ) {
			return stripslashes( $data[ $key ] );
		}
		return $default;
	}

	public static function clever_generate_custom_css () {
		$css = '
			.cleverwa-container .cleverwa-toggle .cleverwa-toggle-icon,
			.cleverwa-container .cleverwa-mobile-close,
			.cleverwa-container .cleverwa-description,
			.cleverwa-container .cleverwa-description a {
				background-color: ' . CleverUtils::clever_get_setting( 'toggle_background_color', '#0DC152' ) . ';
				color: ' . CleverUtils::clever_get_setting( 'toggle_text_color', '#ffffff' ) . ';
			}
			.cleverwa-container .cleverwa-description p {
				color: ' . CleverUtils::clever_get_setting( 'toggle_text_color', '#ffffff' ) . ';
			}
			.cleverwa-container .cleverwa-toggle svg {
				fill: ' . CleverUtils::clever_get_setting( 'toggle_text_color', '#ffffff' ) . ';
			}
			.cleverwa-container .cleverwa-box {
				background-color: ' . CleverUtils::clever_get_setting( 'container_background_color', '#ffffff' ) . ';
			}
			.cleverwa-container .cleverwa-gdpr,
			.cleverwa-container .cleverwa-account {
				color: ' . CleverUtils::clever_get_setting( 'container_text_color', '#555555' ) . ';
			}
			.cleverwa-container .cleverwa-account:hover {
				background-color: ' . CleverUtils::clever_get_setting( 'account_hover_background_color', '#f5f5f5' ) . ';
				border-color: ' . CleverUtils::clever_get_setting( 'account_hover_background_color', '#f5f5f5' ) . ';
				color: ' . CleverUtils::clever_get_setting( 'account_hover_text_color', '#555555' ) . ';
			}
			.cleverwa-box .cleverwa-account,
			.cleverwa-container .cleverwa-account.cleverwa-offline:hover {
				border-color: ' . CleverUtils::clever_get_setting( 'border_color_between_accounts', '#f5f5f5' ) . ';
			}
			.cleverwa-container .cleverwa-account.cleverwa-offline:hover {
				border-radius: 0;
			}

			.cleverwa-container .cleverwa-box:before,
			.cleverwa-container .cleverwa-box:after {
				background-color: ' . CleverUtils::clever_get_setting( 'container_background_color', '#ffffff' ) . ';
				border-color: ' . CleverUtils::clever_get_setting( 'container_background_color', '#ffffff' ) . ';
			}
			.cleverwa-container .cleverwa-close:before,
			.cleverwa-container .cleverwa-close:after {
				background-color: ' . CleverUtils::clever_get_setting( 'toggle_text_color', '#ffffff' ) . ';
			}

			.cleverwa-button {
				background-color: ' . CleverUtils::clever_get_setting( 'button_background_color' ) . ' !important;
				color: ' . CleverUtils::clever_get_setting( 'button_text_color' ) . ' !important;
			}
			.cleverwa-button:hover {
				background-color: ' . CleverUtils::clever_get_setting( 'button_background_color_on_hover' ) . ' !important;
				color: ' . CleverUtils::clever_get_setting( 'button_text_color_on_hover' ) . ' !important;
			}

			.cleverwa-button.cleverwa-offline,
			.cleverwa-button.cleverwa-offline:hover {
				background-color: ' . CleverUtils::clever_get_setting( 'button_background_color_offline' ) . ' !important;
				color: ' . CleverUtils::clever_get_setting( 'button_text_color_offline' ) . ' !important;
			}

			@keyframes toast {
				from {
					background: ' . CleverUtils::clever_get_setting( 'consent_alert_background_color', '#ff0000' ) . ';
					}

				to {
					background: ' . CleverUtils::clever_get_setting( 'container_background_color', '#ffffff' ) . ';
					}
			}
	';

	$css_file = CLEVERWA_PLUGIN_DIR . 'assets/css/auto-generated-cleverwa.css';
	file_put_contents( $css_file, trim( $css ) );
	}

}

?>
