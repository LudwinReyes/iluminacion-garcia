<?php

/* Stop immediately if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( isset( $_POST['cleverwa_auto_display'] ) ) {

	$legit = true;

	if ( ! isset( $_POST['cleverwa_auto_display_form_nonce'] ) ) {
		$legit = false;
	}

	$nonce = isset( $_POST['cleverwa_auto_display_form_nonce'] ) ? $_POST['cleverwa_auto_display_form_nonce'] : '';

	if ( ! wp_verify_nonce( $nonce, 'cleverwa_auto_display_form' ) ) {
		$legit = false;
	}

	if ( ! $legit ) {
		wp_redirect( add_query_arg() );
		exit();
	}

	$delay_time = isset( $_POST['delay_time'] ) ? sanitize_text_field( trim( $_POST['delay_time'] ) ) : '';
	$inactivity_time = isset( $_POST['inactivity_time'] ) ? sanitize_text_field( trim( $_POST['inactivity_time'] ) ) : '';
	$scroll_length = isset( $_POST['scroll_length'] ) ? sanitize_text_field( trim( $_POST['scroll_length'] ) ) : '';
	$disable_auto_display_on_small_screen = isset( $_POST['disable_auto_display_on_small_screen'] ) ? 'on' : 'off';
	$disable_auto_display_when_no_one_online = isset( $_POST['disable_auto_display_when_no_one_online'] ) ? 'on' : 'off';

	CleverUtils::clever_update_setting( 'delay_time', $delay_time );
	CleverUtils::clever_update_setting( 'inactivity_time', $inactivity_time );
	CleverUtils::clever_update_setting( 'scroll_length', $scroll_length );
	CleverUtils::clever_update_setting( 'disable_auto_display_on_small_screen', $disable_auto_display_on_small_screen );
	CleverUtils::clever_update_setting( 'disable_auto_display_when_no_one_online', $disable_auto_display_when_no_one_online );

	add_settings_error( 'cleverwa-settings', 'cleverwa-settings', __( 'Auto display saved', 'cleverwa' ), 'updated' );
}

CleverUtils::clever_set_view( 'CleverFloatingWidgetAutoDisplay' );

?>
