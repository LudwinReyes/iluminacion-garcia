<?php

class CleverActivation {

	public function __construct () {

		if ( is_admin() ) {
			register_activation_hook( CLEVERWA_PLUGIN_BOOTSTRAP_FILE, array( $this, 'clever_activation' ) );
		}

		add_action( 'plugins_loaded', array( $this, 'clever_load_text_domain' ) );

	}

	public function clever_activation () {

		/* Add options to WordPress specific for CLEVERWA */
		if ( ! get_option( CLEVERWA_SETTINGS_NAME ) ) {
			CleverUtils::clever_prepare_settings();
			CleverUtils::clever_update_setting( 'toggle_text', esc_html__( 'Chat with us on WhatsApp', 'cleverwa' ) );
			CleverUtils::clever_update_setting( 'toggle_text_color', 'rgba(255, 255, 255, 1)' );
			CleverUtils::clever_update_setting( 'toggle_background_color', '#0DC152' );
			CleverUtils::clever_update_setting( 'description', esc_html__( 'Hi there! Click one of our representatives below and we will get back to you as soon as possible.', 'cleverwa' ) );
			CleverUtils::clever_update_setting( 'mobile_close_button_text', esc_html__( 'Close and go back to page', 'cleverwa' ) );
			CleverUtils::clever_update_setting( 'container_text_color', 'rgba(85, 85, 85, 1)' );
			CleverUtils::clever_update_setting( 'container_background_color', 'rgba(255, 255, 255, 1)' );
			CleverUtils::clever_update_setting( 'account_hover_background_color', 'rgba(245, 245, 245, 1)' );
			CleverUtils::clever_update_setting( 'account_hover_text_color', 'rgba(85, 85, 85, 1)' );
			CleverUtils::clever_update_setting( 'border_color_between_accounts', '#f5f5f5' );
			CleverUtils::clever_update_setting( 'box_position', 'right' );

			CleverUtils::clever_update_setting( 'consent_alert_background_color', 'rgba(255, 0, 0, 1)' );

			CleverUtils::clever_update_setting( 'button_label', 'Need help? Chat via WhatsApp' );
			CleverUtils::clever_update_setting( 'button_background_color', '#0DC152' );
			CleverUtils::clever_update_setting( 'button_text_color', '#ffffff' );
			CleverUtils::clever_update_setting( 'button_background_color_on_hover', '#0DC152' );
			CleverUtils::clever_update_setting( 'button_text_color_on_hover', '#ffffff' );

			CleverUtils::clever_update_setting( 'button_background_color_offline', '#a0a0a0' );
			CleverUtils::clever_update_setting( 'button_text_color_offline', '#ffffff' );

			CleverUtils::clever_update_setting( 'hide_on_large_screen', 'off' );
			CleverUtils::clever_update_setting( 'hide_on_small_screen', 'off' );

			CleverUtils::clever_update_setting( 'delay_time', '0' );
			CleverUtils::clever_update_setting( 'inactivity_time', '0' );
			CleverUtils::clever_update_setting( 'scroll_length', '0' );

			CleverUtils::clever_update_setting( 'total_accounts_shown', '0' );

			CleverUtils::clever_generate_custom_css();
		}
		else {
			CleverUtils::clever_generate_custom_css();
		}

	}

	public function clever_load_text_domain () {
		load_plugin_textdomain( 'cleverwa', false, plugin_basename( CLEVERWA_PLUGIN_DIR ) . '/languages' );
	}

}

?>
