<?php

class CleverWoocommerce {

	public function __construct () {

		if ( is_admin() ) {
			add_action( 'add_meta_boxes', array( $this, 'clever_add_meta_boxes' ) );
			add_action( 'save_post', array( $this, 'clever_save_meta_boxes' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'clever_admin_enqueue_scripts' ) );
		}
		else {
			add_action( 'woocommerce_before_add_to_cart_form', array( $this, 'clever_show_before_atc' ) );
			add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'clever_show_after_atc' ) );

			if ( 'after_long_description' === CleverUtils::clever_get_setting( 'wc_button_position' ) ) {
				add_filter( 'the_content', array( $this, 'clever_show_after_long_description' ) );
			}
			if ( 'after_short_description' === CleverUtils::clever_get_setting( 'wc_button_position' ) ) {
				add_filter( 'woocommerce_short_description', array( $this, 'clever_show_after_short_description' ), 10, 1 );
			}
		}

	}

	public function clever_show_before_atc () {

		if ( 'before_atc' !== CleverUtils::clever_get_setting( 'wc_button_position' ) || 'on' == get_post_meta( get_the_ID(), 'cleverwa_remove_button', true ) ) {
			return;
		}
		echo $this->clever_set_container();
	}

	public function clever_show_after_atc () {

		if ( 'after_atc' !== CleverUtils::clever_get_setting( 'wc_button_position' ) || 'on' == get_post_meta( get_the_ID(), 'cleverwa_remove_button', true ) ) {
			return;
		}
		echo $this->clever_set_container();
	}

	public function clever_show_after_long_description ( $content ) {
		if ( 'product' !== get_post_type()
				|| ! is_single()
				|| 'on' === get_post_meta( get_the_ID(), 'cleverwa_remove_button', true )
			) {
			return $content;
		}

		return $content . $this->clever_set_container();
	}

	public function clever_show_after_short_description ( $post_excerpt ) {

		if ( 'after_short_description' !== CleverUtils::clever_get_setting( 'wc_button_position' )
				|| 'on' === get_post_meta( get_the_ID(), 'cleverwa_remove_button', true )
				|| ! is_single()
			) {
			return $post_excerpt;
		}
		return $post_excerpt . $this->clever_set_container();
	}

	private function clever_set_container () {

		$selected_accounts = json_decode( CleverUtils::clever_get_setting( 'selected_accounts_for_woocommerce', '[]' ), true );
		$selected_accounts = is_array( $selected_accounts ) ? $selected_accounts : array();

		$custom_accounts = json_decode( get_post_meta( get_the_ID(), 'cleverwa_selected_accounts', true ) );
		$custom_accounts = is_array( $custom_accounts ) ? $custom_accounts : array();
		if ( count( $custom_accounts ) > 0 ) {
			$selected_accounts = $custom_accounts;
		}

		/*
		$result = array();

		if ( count( $selected_accounts ) > 0 ) {
			global $post;
			$the_accounts = get_posts( array(
				'posts_per_page' => -1,
				'post__in' => $selected_accounts,
				'post_type' => 'cleverwa_accounts',
				'orderby' => 'post__in'
			) );

			foreach ( $the_accounts as $post ) {
				setup_postdata( $post );
				$result[] = do_shortcode( '[cleverwa_button id="' . $post->ID . '"]' );
			}
			wp_reset_postdata();
		}
		*/
		$page_title = get_the_title();
		$page_url = get_permalink();

		return '<div class="cleverwa-wc-buttons-container" data-ids="' . implode( ',', $selected_accounts ) . '" data-page-title="' . $page_title . '" data-page-url="' . $page_url . '"></div>';

		//return implode( '', $result );

	}

	public function clever_add_meta_boxes () {

		add_meta_box(
			'cleverwa_wc_button',
			esc_html__( 'WhatsApp Contact Button', 'cleverwa' ),
			array( $this, 'clever_show_meta_box' ),
			array( 'product' )
		);

	}

	public function clever_show_meta_box ( $post ) {

		?>
		<p class="description"><?php esc_html_e( 'You can set a custom WhatsApp button for this product. Leave the following fields blank if you wish to use the default values.', 'cleverwa' ); ?></p>
		<table class="form-table">
			<tbody>
				<tr>
					<th><?php esc_html_e( 'Remove Button', 'cleverwa' ); ?></th>
					<td>
						<input type="checkbox" name="cleverwa_remove_button" id="cleverwa_remove_button" value="on" <?php echo 'on' === strtolower( get_post_meta( $post->ID, 'cleverwa_remove_button', true ) ) ? 'checked' : ''; ?> /> <label for="cleverwa_remove_button"><?php esc_html_e( 'Remove WhatsApp button for this product', 'cleverwa' ); ?></label>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table" id="cleverwa-custom-wc-button-settings">
			<tbody>
				<tr>
					<th><label for="cleverwa_account_number"><?php esc_html_e( 'Selected Accounts', 'cleverwa' ); ?></label></th>
					<td><?php CleverTemplates::clever_display_selected_accounts( 'selected_accounts_for_product', get_the_ID() ); ?></td>
				</tr>
			</tbody>
		</table>

		<?php

		wp_nonce_field( 'cleverwa_wc_meta_box', 'cleverwa_wc_meta_box_nonce' );

	}

	public function clever_save_meta_boxes ( $post_id ) {

		/* Check if our nonce is set. */
		if ( ! isset( $_POST['cleverwa_wc_meta_box_nonce'] ) ) {
			return;
		}

		$nonce = $_POST['cleverwa_wc_meta_box_nonce'];

		/* Verify that the nonce is valid. */
		if ( ! wp_verify_nonce( $nonce, 'cleverwa_wc_meta_box' ) ) {
			return;
		}

		$remove_button = isset( $_POST['cleverwa_remove_button'] ) ? 'on' : 'off';
		$ids = array();
		$the_posts = isset( $_POST['cleverwa_selected_account'] ) ? array_values( array_unique( $_POST['cleverwa_selected_account'] ) ) : array();
		foreach ( $the_posts as $k => $v ) {
			$ids[] = ( int ) $v;
		}

		update_post_meta( $post_id, 'cleverwa_selected_accounts', json_encode( $ids ));
		update_post_meta( $post_id, 'cleverwa_remove_button', $remove_button);

	}

	public function clever_admin_enqueue_scripts ( $hook ) {

		if ( 'post.php' != $hook || 'product' != get_current_screen()->post_type ) {
			return;
		}
		wp_enqueue_script( 'cleverwa-public', CLEVERWA_PLUGIN_URL . 'assets/js/admin.js', array( 'jquery' ), false, true );
		wp_enqueue_style( 'cleverwa-admin', CLEVERWA_PLUGIN_URL . 'assets/css/admin.css' );
	}

}

?>
