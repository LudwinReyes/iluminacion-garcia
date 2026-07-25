<div class="wrap">

	<?php include_once( 'CleverFloatingWidgetHeader.php' ); ?>

	<form action="" method="post" novalidate="novalidate">

		<p><?php esc_html_e( 'Select one or more accounts to display on the floating widget.', 'cleverwa' ); ?></p>

		<?php CleverTemplates::clever_display_selected_accounts( 'selected_accounts_for_widget' ); ?>

		<?php wp_nonce_field( 'cleverwa_selected_accounts_form', 'cleverwa_selected_accounts_form_nonce' ); ?>
		<input type="hidden" name="cleverwa_selected_accounts" value="submit" />
		<input type="hidden" name="submit" value="submit" />
		<p class="submit"><input type="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Selected Accounts', 'cleverwa' ); ?>"></p>

	</form>
</div>
