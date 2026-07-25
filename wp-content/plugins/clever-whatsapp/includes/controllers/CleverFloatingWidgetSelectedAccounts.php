<?php

/* Stop immediately if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( isset( $_POST['cleverwa_selected_accounts'] ) ) {

	$legit = true;

	/* Check if our nonce is set. */
	if ( ! isset( $_POST['cleverwa_selected_accounts_form_nonce'] ) ) {
		$legit = false;
	}

	$nonce = isset( $_POST['cleverwa_selected_accounts_form_nonce'] ) ? $_POST['cleverwa_selected_accounts_form_nonce'] : '';

	/* Verify that the nonce is valid. */
	if ( ! wp_verify_nonce( $nonce, 'cleverwa_selected_accounts_form' ) ) {
		$legit = false;
	}

	/* 	Something is wrong with the nonce. Redirect it to the
		settings page without processing any data.
		*/
	if ( ! $legit ) {
		wp_redirect( add_query_arg() );
		exit();
	}

	$ids = array();
	$the_posts = isset( $_POST['cleverwa_selected_account'] ) ? array_values( array_unique( $_POST['cleverwa_selected_account'] ) ) : array();
	foreach ( $the_posts as $k => $v ) {
		$ids[] = ( int ) $v;
	}

	CleverUtils::clever_update_setting( 'selected_accounts_for_widget', json_encode( $ids ) );
	
	add_settings_error( 'cleverwa-settings', 'cleverwa-settings', __( 'Selected accounts saved', 'cleverwa' ), 'updated' );
}

CleverUtils::clever_set_view( 'CleverFloatingWidgetSelectedAccounts' );

?>
