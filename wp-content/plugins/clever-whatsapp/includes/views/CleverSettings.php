<?php

/**
 * Controller: settings.php
 */

/* Stop immediately if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

?>
<div class="wrap">
	<h1><?php esc_html_e( 'General Settings', 'cleverwa' ); ?></h1>

	<?php settings_errors(); ?>

	<form action="" method="post" novalidate="novalidate">
		<p><?php esc_html_e( 'Use this form to set default style for shortcode buttons. You can reset the style for individual button when creating/editing a WhatsApp account.', 'cleverwa' ); ?></p>
		<table id="cleverwa-default-settings" class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="button_label"><?php esc_html_e( 'Button Label', 'cleverwa' ); ?></label></th>
					<td>
						<input name="button_label" type="text" id="button_label" class="regular-text" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'button_label' ) ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="button_style"><?php esc_html_e( 'Button Style', 'cleverwa' ); ?></label></th>
					<td>
						<select name="button_style" id="button_style">
							<option value="boxed" <?php selected( 'boxed', CleverUtils::clever_get_setting( 'button_style' ), true); ?>><?php esc_html_e( 'Boxed', 'cleverwa' );?></option>
							<option value="round" <?php selected( 'round', CleverUtils::clever_get_setting( 'button_style' ), true); ?>><?php esc_html_e( 'Round', 'cleverwa' );?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="button_background_color"><?php esc_html_e( 'Button Background Color', 'cleverwa' ); ?></label></th>
					<td>
						<input name="button_background_color" type="text" id="button_background_color" class="minicolors" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'button_background_color' ) ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="button_text_color"><?php esc_html_e( 'Button Text Color', 'cleverwa' ); ?></label></th>
					<td>
						<input name="button_text_color" type="text" id="button_text_color" class="minicolors" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'button_text_color' ) ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="button_background_color_on_hover"><?php esc_html_e( 'Button Background Color on Hover', 'cleverwa' ); ?></label></th>
					<td>
						<input name="button_background_color_on_hover" type="text" id="button_background_color_on_hover" class="minicolors" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'button_background_color_on_hover' ) ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="button_text_color_on_hover"><?php esc_html_e( 'Button Text Color on Hover', 'cleverwa' ); ?></label></th>
					<td>
						<input name="button_text_color_on_hover" type="text" id="button_text_color_on_hover" class="minicolors" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'button_text_color_on_hover' ) ); ?>">
					</td>
				</tr>

				<tr>
					<th scope="row"><label for="button_background_color_offline"><?php esc_html_e( 'Button Background Color When Offline', 'cleverwa' ); ?></label></th>
					<td>
						<input name="button_background_color_offline" type="text" id="button_background_color_offline" class="minicolors" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'button_background_color_offline' ) ); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="button_text_color_offline"><?php esc_html_e( 'Button Text Color When Offline', 'cleverwa' ); ?></label></th>
					<td>
						<input name="button_text_color_offline" type="text" id="button_text_color_offline" class="minicolors" value="<?php echo esc_attr( CleverUtils::clever_get_setting( 'button_text_color_offline' ) ); ?>">
					</td>
				</tr>
			</tbody>
		</table>

		<?php wp_nonce_field( 'cleverwa_settings_form', 'cleverwa_settings_form_nonce' ); ?>
		<input type="hidden" name="cleverwa_settings" value="submit" />
		<input type="hidden" name="submit" value="submit" />
		<p class="submit"><input type="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'cleverwa' ); ?>"></p>

	</form>
</div>
