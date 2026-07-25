<?php

/* Stop immediately if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( isset( $_POST['cleverwa_settings'] ) ) {

	$legit = true;

	/* Check if our nonce is set. */
	if ( ! isset( $_POST['cleverwa_settings_form_nonce'] ) ) {
		$legit = false;
	}

	$nonce = $_POST['cleverwa_settings_form_nonce'];

	/* Verify that the nonce is valid. */
	if ( ! wp_verify_nonce( $nonce, 'cleverwa_settings_form' ) ) {
		$legit = false;
	}

	/* 	Something is wrong with the nonce. Redirect it to the
		settings page without processing any data.
		*/
	if ( ! $legit ) {
		wp_redirect( add_query_arg() );
		exit();
	}

	$button_label = isset( $_POST['button_label'] ) ? sanitize_text_field( trim( $_POST['button_label'] ) ) : '';
	$button_style = isset( $_POST['button_style'] ) ? sanitize_text_field( trim( $_POST['button_style'] ) ) : '';
	$button_background_color = isset( $_POST['button_background_color'] ) ? sanitize_text_field( trim( $_POST['button_background_color'] ) ) : '';
	$button_text_color = isset( $_POST['button_text_color'] ) ? sanitize_text_field( trim( $_POST['button_text_color'] ) ) : '';
	$button_background_color_on_hover = isset( $_POST['button_background_color_on_hover'] ) ? sanitize_text_field( trim( $_POST['button_background_color_on_hover'] ) ) : '';
	$button_text_color_on_hover = isset( $_POST['button_text_color_on_hover'] ) ? sanitize_text_field( trim( $_POST['button_text_color_on_hover'] ) ) : '';

	$button_background_color_offline = isset( $_POST['button_background_color_offline'] ) ? sanitize_text_field( trim( $_POST['button_background_color_offline'] ) ) : '';
	$button_text_color_offline = isset( $_POST['button_text_color_offline'] ) ? sanitize_text_field( trim( $_POST['button_text_color_offline'] ) ) : '';

	CleverUtils::clever_update_setting( 'button_label', $button_label );
	CleverUtils::clever_update_setting( 'button_style', $button_style );
	CleverUtils::clever_update_setting( 'button_background_color', $button_background_color );
	CleverUtils::clever_update_setting( 'button_text_color', $button_text_color );
	CleverUtils::clever_update_setting( 'button_background_color_on_hover', $button_background_color_on_hover );
	CleverUtils::clever_update_setting( 'button_text_color_on_hover', $button_text_color_on_hover );

	CleverUtils::clever_update_setting( 'button_background_color_offline', $button_background_color_offline );
	CleverUtils::clever_update_setting( 'button_text_color_offline', $button_text_color_offline );

	/* Recreate CSS file */
	CleverUtils::clever_generate_custom_css();

	add_settings_error( 'cleverwa-settings', 'cleverwa-settings', __( 'Settings saved', 'cleverwa' ), 'updated' );
}

CleverUtils::clever_set_view( 'CleverSettings' );

?>
