<?php

if ( isset( $_POST['cleverwa_woocommerce_button'] ) ) {
	$legit = true;

	/* Check if our nonce is set. */
	if ( ! isset( $_POST['cleverwa_woocommerce_button_form_nonce'] ) ) {
		$legit = false;
	}

	$nonce = $_POST['cleverwa_woocommerce_button_form_nonce'];

	/* Verify that the nonce is valid. */
	if ( ! wp_verify_nonce( $nonce, 'cleverwa_woocommerce_button_form' ) ) {
		$legit = false;
	}

	/* 	Something is wrong with the nonce. Redirect it to the
		settings page without processing any data.
		*/
	if ( ! $legit ) {
		wp_redirect( add_query_arg() );
		exit();
	}

	$wc_button_position = isset( $_POST['wc_button_position'] ) ? sanitize_text_field( trim( $_POST['wc_button_position'] ) ) : '';
	$wc_randomize_accounts_order = isset( $_POST['wc_randomize_accounts_order'] ) ? 'on' : 'off';
	$wc_total_accounts_shown = isset( $_POST['wc_total_accounts_shown'] ) ? ( int ) sanitize_text_field( trim( $_POST['wc_total_accounts_shown'] ) ) : 0;

	CleverUtils::clever_update_setting( 'wc_button_position', $wc_button_position );
	CleverUtils::clever_update_setting( 'wc_randomize_accounts_order', $wc_randomize_accounts_order );
	CleverUtils::clever_update_setting( 'wc_total_accounts_shown', $wc_total_accounts_shown );

	$ids = array();
	$the_posts = isset( $_POST['cleverwa_selected_account'] ) ? array_values( array_unique( $_POST['cleverwa_selected_account'] ) ) : array();
	foreach ( $the_posts as $k => $v ) {
		$ids[] = ( int ) $v;
	}

	CleverUtils::clever_update_setting( 'selected_accounts_for_woocommerce', json_encode( $ids ) );

	add_settings_error( 'cleverwa-settings', 'cleverwa-settings', __( 'WooCommerce button saved', 'cleverwa' ), 'updated' );

}

CleverUtils::clever_set_view( 'CleverWoocommerceButton' );

?>
