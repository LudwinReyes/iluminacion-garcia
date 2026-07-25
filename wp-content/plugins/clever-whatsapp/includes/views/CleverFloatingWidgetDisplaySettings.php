<?php

$box_position = '' === CleverUtils::clever_get_setting( 'box_position' ) ? 'right' : CleverUtils::clever_get_setting( 'box_position' );

?>

<div class="wrap">

	<?php include_once( 'CleverFloatingWidgetHeader.php' ); ?>

	<form action="" method="post" novalidate="novalidate">

		<p><?php esc_html_e( 'Use the form below to set the text and style for the floating widget.', 'cleverwa' ); ?></p>

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="toggle_text"><?php esc_html_e( 'Toggle Text', 'cleverwa' ); ?></label></th>
					<td>
						<input name="toggle_text" type="text" id="toggle_text" class="regular-text" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'toggle_text' ) ); ?>">
						<p class="description"><?php esc_html_e( "If left blank, the toggle will be round regardless of the Toggle Type by Device fields' values.", "cleverwa" );?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="widget_title_text"><?php esc_html_e( 'Widget Title Text', 'cleverwa' ); ?></label></th>
					<td>
						<input name="widget_title_text" type="text" id="widget_title_text" class="regular-text" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'widget_title_text' ) ); ?>">
						<p class="description"><?php esc_html_e( "This field is displayed as the title of the opened box!", "cleverwa" );?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="toggle_text_color"><?php esc_html_e( 'Toggle Text Color', 'cleverwa' ); ?></label></th>
					<td>
						<input name="toggle_text_color" type="text" id="toggle_text_color" class="minicolors" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'toggle_text_color' ) ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="toggle_background_color"><?php esc_html_e( 'Toggle Background Color', 'cleverwa' ); ?></label></th>
					<td>
						<input name="toggle_background_color" type="text" id="toggle_background_color" class="minicolors" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'toggle_background_color' ) ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label><?php esc_html_e( 'Toggle Type by Device', 'cleverwa' ); ?></label></th>
					<td>
						<p><input name="toggle_round_on_desktop" type="checkbox" id="toggle_round_on_desktop" value="on" <?php echo 'on' === CleverUtils::clever_get_setting( 'toggle_round_on_desktop' ) ? 'checked' : ''; ?>> <label for="toggle_round_on_desktop"><?php esc_html_e( 'Show rounded toggle on desktop', 'cleverwa' ); ?></label></p>
						<p><input name="toggle_round_on_mobile" type="checkbox" id="toggle_round_on_mobile" value="on" <?php echo 'on' === CleverUtils::clever_get_setting( 'toggle_round_on_mobile' ) ? 'checked' : ''; ?>> <label for="toggle_round_on_mobile"><?php esc_html_e( 'Show rounded toggle on mobile', 'cleverwa' ); ?></label></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="description"><?php esc_html_e( 'Description', 'cleverwa' ); ?></label></th>
					<td>
						<?php wp_editor( CleverUtils::clever_get_setting( 'description' ), 'description', array(
							'media_buttons' => false,
							'textarea_name' => 'description',
							'textarea_rows' => 3,
							'teeny' => true,
							'quicktags' => false
						) ); ?>

					</td>
				</tr>
				<tr>
					<th scope="row"><label for="container_text_color"><?php esc_html_e( 'Container Text Color', 'cleverwa' ); ?></label></th>
					<td>
						<input name="container_text_color" type="text" id="container_text_color" class="minicolors" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'container_text_color' ) ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="container_background_color"><?php esc_html_e( 'Container Background Color', 'cleverwa' ); ?></label></th>
					<td>
						<input name="container_background_color" type="text" id="container_background_color" class="minicolors" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'container_background_color' ) ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="account_hover_background_color"><?php esc_html_e( 'Account Item Background Color on Hover', 'cleverwa' ); ?></label></th>
					<td>
						<input name="account_hover_background_color" type="text" id="account_hover_background_color" class="minicolors" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'account_hover_background_color' ) ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="account_hover_text_color"><?php esc_html_e( 'Account Item Text Color on Hover', 'cleverwa' ); ?></label></th>
					<td>
						<input name="account_hover_text_color" type="text" id="account_hover_text_color" class="minicolors" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'account_hover_text_color' ) ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="border_color_between_accounts"><?php esc_html_e( 'Border Color Between Accounts', 'cleverwa' ); ?></label></th>
					<td>
						<input name="border_color_between_accounts" type="text" id="border_color_between_accounts" class="minicolors" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'border_color_between_accounts' ) ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="box_position"><?php esc_html_e( 'Box Position', 'cleverwa' ); ?></label></th>
					<td>
						<p><input type="radio" name="box_position" value="left" id="box_position_left" <?php echo 'left' === $box_position ? 'checked' : ''; ?> /> <label for="box_position_left"><?php esc_html_e( 'Bottom Left', 'cleverwa' ); ?></label></p>
						<p><input type="radio" name="box_position" value="right" id="box_position_right" <?php echo 'right' === $box_position ? 'checked' : ''; ?> /> <label for="box_position_right"><?php esc_html_e( 'Bottom Right', 'cleverwa' ); ?></label></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="toggle_center_on_mobile"><?php esc_html_e( 'Center Toggle on Small Screen', 'cleverwa' ); ?></label></th>
					<td>
						<p><input type="checkbox" name="toggle_center_on_mobile" value="on" id="toggle_center_on_mobile" <?php checked( 'on', CleverUtils::clever_get_setting( 'toggle_center_on_mobile' ), true ); ?> /> <label for="toggle_center_on_mobile"><?php esc_html_e( 'Yes, put the toggle at the bottom center on small screen', 'cleverwa' ); ?></label></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="randomize_accounts_order"><?php esc_html_e( 'Randomize Accounts Order', 'cleverwa' ); ?></label></th>
					<td>
						<p><input type="checkbox" name="randomize_accounts_order" value="on" id="randomize_accounts_order" <?php checked( 'on', CleverUtils::clever_get_setting( 'randomize_accounts_order' ), true ); ?> /> <label for="randomize_accounts_order"><?php esc_html_e( 'Yes, randomize the order of accounts', 'cleverwa' ); ?></label></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="total_accounts_shown"><?php esc_html_e( 'Total accounts shown', 'cleverwa' ); ?></label></th>
					<td>
						<p><input type="number" min="0" max="100" name="total_accounts_shown" value="<?php echo filter_var( CleverUtils::clever_get_setting( 'total_accounts_shown' ), FILTER_SANITIZE_NUMBER_INT ); ?>" id="total_accounts_shown" /> </p>
						<p class="description"><?php esc_html_e( "If the value is zero (0), then all the selected accounts will be displayed.", "cleverwa" );?></p>
					</td>
				</tr>
			</tbody>
		</table>

		<?php wp_nonce_field( 'cleverwa_display_settings_form', 'cleverwa_display_settings_form_nonce' ); ?>
		<input type="hidden" name="cleverwa_display_settings" value="submit" />
		<input type="hidden" name="submit" value="submit" />
		<p class="submit"><input type="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Display Settings', 'cleverwa' ); ?>"></p>

	</form>
</div>
