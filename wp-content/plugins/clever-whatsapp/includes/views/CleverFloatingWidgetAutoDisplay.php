<div class="wrap">

	<?php include_once( 'CleverFloatingWidgetHeader.php' ); ?>

	<form action="" method="post" novalidate="novalidate">

		<p><?php esc_html_e( 'The fields below should have a numeric value of more than 0 for the feature to work.', 'cleverwa' ); ?></p>

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="delay_time"><?php esc_html_e( 'Delay Time', 'cleverwa' ); ?></label></th>
					<td>
						<input name="delay_time" type="number" min="0" max="999" id="delay_time" value="<?php echo filter_var( CleverUtils::clever_get_setting( 'delay_time' ), FILTER_SANITIZE_NUMBER_INT ); ?>"> <?php esc_html_e( 'second(s)', 'cleverwa' ); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="inactivity_time"><?php esc_html_e( 'Inactivity Time', 'cleverwa' ); ?></label></th>
					<td>
						<input name="inactivity_time" type="number" min="0" max="999" id="inactivity_time" value="<?php echo filter_var( CleverUtils::clever_get_setting( 'inactivity_time' ), FILTER_SANITIZE_NUMBER_INT ); ?>"> <?php esc_html_e( 'second(s)', 'cleverwa' ); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="scroll_length"><?php esc_html_e( 'Scroll Length', 'cleverwa' ); ?></label></th>
					<td>
						<input name="scroll_length" type="number" min="0" max="100" id="scroll_length" value="<?php echo filter_var( CleverUtils::clever_get_setting( 'scroll_length' ), FILTER_SANITIZE_NUMBER_INT ); ?>">  <?php esc_html_e( '%', 'cleverwa' ); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="disable_auto_display_on_small_screen"><?php esc_html_e( 'Disable on mobile', 'cleverwa' ); ?></label></th>
					<td>
						<input name="disable_auto_display_on_small_screen" type="checkbox" id="disable_auto_display_on_small_screen" value="on" <?php echo 'on' === CleverUtils::clever_get_setting( 'disable_auto_display_on_small_screen' ) ? 'checked' : ''; ?>>  <label for="disable_auto_display_on_small_screen"><?php esc_html_e( 'Yes, disable auto display on small screen.', 'cleverwa' ); ?></label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="disable_auto_display_when_no_one_online"><?php esc_html_e( 'Disable when no one is online', 'cleverwa' ); ?></label></th>
					<td>
						<input name="disable_auto_display_when_no_one_online" type="checkbox" id="disable_auto_display_when_no_one_online" value="on" <?php echo 'on' === CleverUtils::clever_get_setting( 'disable_auto_display_when_no_one_online' ) ? 'checked' : ''; ?>>  <label for="disable_auto_display_when_no_one_online"><?php esc_html_e( 'Yes, disable auto display when no one is online.', 'cleverwa' ); ?></label>
					</td>
				</tr>
			</tbody>
		</table>

		<?php wp_nonce_field( 'cleverwa_auto_display_form', 'cleverwa_auto_display_form_nonce' ); ?>
		<input type="hidden" name="cleverwa_auto_display" value="submit" />
		<input type="hidden" name="submit" value="submit" />
		<p class="submit"><input type="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Auto Display', 'cleverwa' ); ?>"></p>

	</form>
</div>
