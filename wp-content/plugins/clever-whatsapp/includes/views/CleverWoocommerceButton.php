<div class="wrap">
	<h1><?php esc_html_e( 'WooCommerce Button', 'cleverwa' ); ?></h1>
	<?php settings_errors(); ?>

	<form action="" method="post" novalidate="novalidate">

		<p><?php esc_html_e( 'Use the form below to automatically display buttons on WooCommerce product page.', 'cleverwa' ); ?></p>

		<table class="form-table cleverwa-account-item">
			<tbody>
				<tr>
					<th scope="row"><label for="wc_button_position"><?php esc_html_e( 'Button position', 'cleverwa' ); ?></label></th>
					<td>
						<select name="wc_button_position" id="wc_button_position">
							<option value="after_short_description" <?php selected( 'after_short_description', CleverUtils::clever_get_setting( 'wc_button_position' ), true); ?>><?php esc_html_e( 'After short description', 'cleverwa' ); ?></option>
							<option value="after_long_description" <?php selected( 'after_long_description', CleverUtils::clever_get_setting( 'wc_button_position' ), true); ?>><?php esc_html_e( 'After long description', 'cleverwa' ); ?></option>
							<option value="before_atc" <?php selected( 'before_atc', CleverUtils::clever_get_setting( 'wc_button_position' ), true); ?>><?php esc_html_e( 'Before Add to Cart button', 'cleverwa' ); ?></option>
							<option value="after_atc" <?php selected( 'after_atc', CleverUtils::clever_get_setting( 'wc_button_position' ), true); ?>><?php esc_html_e( 'After Add to Cart button', 'cleverwa' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="wc_randomize_accounts_order"><?php esc_html_e( 'Randomize Accounts Order', 'cleverwa' ); ?></label></th>
					<td>
						<p><input type="checkbox" name="wc_randomize_accounts_order" value="on" id="wc_randomize_accounts_order" <?php checked( 'on', CleverUtils::clever_get_setting( 'wc_randomize_accounts_order' ), true ); ?> /> <label for="wc_randomize_accounts_order"><?php esc_html_e( 'Yes, randomize the order of accounts', 'cleverwa' ); ?></label></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="wc_total_accounts_shown"><?php esc_html_e( 'Total accounts shown', 'cleverwa' ); ?></label></th>
					<td>
						<p><input type="number" min="0" max="100" name="wc_total_accounts_shown" value="<?php echo filter_var( CleverUtils::clever_get_setting( 'wc_total_accounts_shown' ), FILTER_SANITIZE_NUMBER_INT ); ?>" id="wc_total_accounts_shown" /> </p>
						<p class="description"><?php esc_html_e( "If the value is zero (0), then all the selected accounts will be displayed.", "cleverwa" );?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="selected_accounts"><?php esc_html_e( 'Select accounts to display', 'cleverwa' ); ?></label></th>
					<td><?php CleverTemplates::clever_display_selected_accounts( 'selected_accounts_for_woocommerce' ); ?></td>
				</tr>
			</tbody>
		</table>

		<?php wp_nonce_field( 'cleverwa_woocommerce_button_form', 'cleverwa_woocommerce_button_form_nonce' ); ?>
		<input type="hidden" name="cleverwa_woocommerce_button" value="submit" />
		<input type="hidden" name="submit" value="submit" />
		<p class="submit"><input type="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save WooCommerce Button', 'cleverwa' ); ?>"></p>

	</form>

</div>
