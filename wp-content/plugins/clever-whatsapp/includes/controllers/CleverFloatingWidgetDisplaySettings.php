<?php

/* Stop immediately if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( isset( $_POST['cleverwa_display_settings'] ) ) {
	$legit = true;

	/* Check if our nonce is set. */
	if ( ! isset( $_POST['cleverwa_display_settings_form_nonce'] ) ) {
		$legit = false;
	}

	$nonce = isset( $_POST['cleverwa_display_settings_form_nonce'] ) ? $_POST['cleverwa_display_settings_form_nonce'] : '';

	/* Verify that the nonce is valid. */
	if ( ! wp_verify_nonce( $nonce, 'cleverwa_display_settings_form' ) ) {
		$legit = false;
	}

	/* 	Something is wrong with the nonce. Redirect it to the
		settings page without processing any data.
		*/
	if ( ! $legit ) {
		wp_redirect( add_query_arg() );
		exit();
	}


	$toggle_text = isset( $_POST['toggle_text'] ) ? sanitize_text_field( trim( $_POST['toggle_text'] ) ) : '';
	$widget_title_text = isset( $_POST['widget_title_text'] ) ? sanitize_text_field( trim( $_POST['widget_title_text'] ) ) : '';
	$toggle_text_color = isset( $_POST['toggle_text_color'] ) ? sanitize_text_field( trim( $_POST['toggle_text_color'] ) ) : '';
	$toggle_background_color = isset( $_POST['toggle_background_color'] ) ? sanitize_text_field( trim( $_POST['toggle_background_color'] ) ) : '';
	$toggle_round_on_desktop = isset( $_POST['toggle_round_on_desktop'] ) ? 'on' : 'off';
	$toggle_round_on_mobile = isset( $_POST['toggle_round_on_mobile'] ) ? 'on' : 'off';
	$description = isset( $_POST['description'] ) ? wp_kses_post( $_POST['description'] ) : '';
	$container_text_color = isset( $_POST['container_text_color'] ) ? sanitize_text_field( trim( $_POST['container_text_color'] ) ) : '';
	$container_background_color = isset( $_POST['container_background_color'] ) ? sanitize_text_field( trim( $_POST['container_background_color'] ) ) : '';
	$account_hover_background_color = isset( $_POST['account_hover_background_color'] ) ? sanitize_text_field( trim( $_POST['account_hover_background_color'] ) ) : '';
	$account_hover_text_color = isset( $_POST['account_hover_text_color'] ) ? sanitize_text_field( trim( $_POST['account_hover_text_color'] ) ) : '';
	$border_color_between_accounts = isset( $_POST['border_color_between_accounts'] ) ? sanitize_text_field( trim( $_POST['border_color_between_accounts'] ) ) : '';
	$box_position = isset( $_POST['box_position'] ) ? sanitize_text_field( trim( $_POST['box_position'] ) ) : '';
	$toggle_center_on_mobile = isset( $_POST['toggle_center_on_mobile'] ) ? 'on' : 'off';
	$randomize_accounts_order = isset( $_POST['randomize_accounts_order'] ) ? 'on' : 'off';
	$total_accounts_shown = isset( $_POST['total_accounts_shown'] ) ? ( int ) sanitize_text_field( trim( $_POST['total_accounts_shown'] ) ) : 0;

	CleverUtils::clever_update_setting( 'toggle_text', $toggle_text );
	CleverUtils::clever_update_setting( 'widget_title_text', $widget_title_text );
	CleverUtils::clever_update_setting( 'toggle_text_color', $toggle_text_color );
	CleverUtils::clever_update_setting( 'toggle_background_color', $toggle_background_color );
	CleverUtils::clever_update_setting( 'toggle_round_on_desktop', $toggle_round_on_desktop );
	CleverUtils::clever_update_setting( 'toggle_round_on_mobile', $toggle_round_on_mobile );
	CleverUtils::clever_update_setting( 'description', $description );
	CleverUtils::clever_update_setting( 'container_text_color', $container_text_color );
	CleverUtils::clever_update_setting( 'container_background_color', $container_background_color );
	CleverUtils::clever_update_setting( 'account_hover_background_color', $account_hover_background_color );
	CleverUtils::clever_update_setting( 'account_hover_text_color', $account_hover_text_color );
	CleverUtils::clever_update_setting( 'border_color_between_accounts', $border_color_between_accounts );
	CleverUtils::clever_update_setting( 'box_position', $box_position );
	CleverUtils::clever_update_setting( 'toggle_center_on_mobile', $toggle_center_on_mobile );
	CleverUtils::clever_update_setting( 'randomize_accounts_order', $randomize_accounts_order );
	CleverUtils::clever_update_setting( 'total_accounts_shown', $total_accounts_shown );

	/* WPML if installed and active */
	do_action( 'wpml_register_single_string', 'WhatsApp Click to Chat', 'Toggle Text', $toggle_text );
	do_action( 'wpml_register_single_string', 'WhatsApp Click to Chat', 'Description', $description );

	/* Recreate CSS file */
	CleverUtils::clever_generate_custom_css();

	add_settings_error( 'cleverwa-settings', 'cleverwa-settings', __( 'Display settings saved', 'cleverwa' ), 'updated' );
}

CleverUtils::clever_set_view( 'CleverFloatingWidgetDisplaySettings' );

?>
