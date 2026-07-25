<?php

class CleverTemplates {

	static public function clever_display_selected_accounts ( $category, $product_id = 0 ) {
		$selected_accounts = json_decode( CleverUtils::clever_get_setting( $category, '' ), true );

		if ( 'selected_accounts_for_product' === $category ) {
			$selected_accounts = json_decode( get_post_meta( $product_id, 'cleverwa_selected_accounts', true ) );
		}

		$selected_accounts_html = '';

		$selected_accounts = is_array( $selected_accounts ) ? $selected_accounts : array();

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

				$name = get_post_meta( $post->ID, 'cleverwa_name', true );
				$account_title = get_post_meta( $post->ID, 'cleverwa_title', true );
				$avatar = get_the_post_thumbnail_url( $post->ID )
					? get_the_post_thumbnail_url( $post->ID )
					: CLEVERWA_PLUGIN_URL . 'assets/images/logo-green-small.png';


				$post_title = '' !== get_the_title() ? get_the_title() : sprintf( esc_html__( '[No title with ID: %s]', 'cleverwa' ), get_the_ID() );

				$selected_accounts_html.= '<div class="cleverwa-item cleverwa-clearfix" data-id="' . get_the_ID() . '" data-name-title="' . esc_attr( $name . ' / ' . $account_title ) . '" >
								<div class="cleverwa-avatar"><img src="' . esc_url($avatar) . '" alt=""/></div>
								<div class="cleverwa-info cleverwa-clearfix">
									<a href="post.php?post=' . get_the_ID() . '&action=edit" target="_blank" class="cleverwa-title">' . esc_html($post_title) . '</a>
									<div class="cleverwa-meta">
										' . esc_html($name) . ' / ' . esc_html($account_title) . ' <br/>
										<span class="cleverwa-remove-account">' . esc_html__( 'Remove', 'cleverwa' ) . '</span>
									</div>
								</div>
								<div class="cleverwa-updown"><span class="cleverwa-up dashicons dashicons-arrow-up-alt2"></span><span class="cleverwa-down dashicons dashicons-arrow-down-alt2"></span></div>
								<input type="hidden" name="cleverwa_selected_account[]" value="' . get_the_ID() . '"/>
							</div>';

			}
			wp_reset_postdata();
		}
		?>
		<div class="cleverwa-account-search">
			<div class="cleverwa-search-box">
				<input type="text" class="widefat" placeholder="<?php esc_attr_e( 'Type the title of the accounts you want to display', 'cleverwa' ); ?>"  data-nonce="<?php echo wp_create_nonce( 'cleverwa-search-nonce' ); ?>" />
			</div>
			<div class="cleverwa-account-list"></div>
		</div>

		<div class="cleverwa-account-result">
			<h4><?php esc_html_e( 'Selected Accounts:', 'cleverwa' ); ?></h4>
			<div class="cleverwa-account-list"><?php echo ent2ncr($selected_accounts_html); ?></div>
		</div>
		<?php
	}

}

?>
