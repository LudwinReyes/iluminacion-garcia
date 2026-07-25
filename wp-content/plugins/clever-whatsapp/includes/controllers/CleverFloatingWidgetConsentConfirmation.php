<?php

/* Stop immediately if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( isset( $_POST['cleverwa_consent_confirmation'] ) ) {

	$legit = true;

	if ( ! isset( $_POST['cleverwa_consent_confirmation_form_nonce'] ) ) {
		$legit = false;
	}

	$nonce = isset( $_POST['cleverwa_consent_confirmation_form_nonce'] ) ? $_POST['cleverwa_consent_confirmation_form_nonce'] : '';

	if ( ! wp_verify_nonce( $nonce, 'cleverwa_consent_confirmation_form' ) ) {
		$legit = false;
	}

	if ( ! $legit ) {
		wp_redirect( add_query_arg() );
		exit();
	}

	$consent_description = isset( $_POST['consent_description'] ) ? wp_kses_post( $_POST['consent_description'] ) : '';
	$consent_checkbox_text_label = isset( $_POST['consent_checkbox_text_label'] ) ? wp_kses_post( $_POST['consent_checkbox_text_label'] ) : '';
	$consent_alert_background_color = isset( $_POST['consent_alert_background_color'] ) ? sanitize_text_field( trim( $_POST['consent_alert_background_color'] ) ) : '';

	CleverUtils::clever_update_setting( 'consent_description', $consent_description );
	CleverUtils::clever_update_setting( 'consent_checkbox_text_label', $consent_checkbox_text_label );
	CleverUtils::clever_update_setting( 'consent_alert_background_color', $consent_alert_background_color );

	/* WPML if installed and active */
	do_action( 'wpml_register_single_string', 'WhatsApp Click to Chat', 'Consent Description', $consent_description );
	do_action( 'wpml_register_single_string', 'WhatsApp Click to Chat', 'Consent Checkbox Text Label', $consent_checkbox_text_label );

	/* Recreate CSS file */
	CleverUtils::clever_generate_custom_css();

	add_settings_error( 'cleverwa-settings', 'cleverwa-settings', __( 'Consent confirmation saved', 'cleverwa' ), 'updated' );
}

CleverUtils::clever_set_view( 'CleverFloatingWidgetConsentConfirmation' );

?>
