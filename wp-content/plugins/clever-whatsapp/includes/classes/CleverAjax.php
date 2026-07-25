<?php

class CleverAjax {

	public function __construct () {

		add_action( 'wp_ajax_cleverwa_search_posts', array( $this, 'clever_search_posts' ) );
		add_action( 'wp_ajax_cleverwa_search_accounts', array( $this, 'clever_search_accounts' ) );

	}

	public function clever_search_posts(  ) {

		check_ajax_referer( 'cleverwa-search-nonce', 'security' );
		$title = sanitize_text_field( $_POST['title'] );

		$html = '';

		if ( filter_var( $_POST['title'], FILTER_VALIDATE_URL ) !== FALSE ) {
			$the_url = esc_url( $_POST['title'] );
			$html.= '<li data-id="' . esc_url($the_url) . '">
					<span class="cleverwa-title">' . esc_url($the_url) . '</span>
				</li>';
		}
		else {
			global $post;
			$args = array(
				'posts_per_page' => 50,
				's' => $title,
				'post_type' => 'any'
			);

			$result = get_posts( $args );

			foreach ( $result as $post ) {
				setup_postdata( $post );

				$post_title = '' !== get_the_title() ? get_the_title() : sprintf( esc_html__( '[No title with ID: %s]', 'cleverwa' ), get_the_ID() );
				$html.= '<li data-id="' . get_the_ID() . '">
					<span class="cleverwa-title">' . esc_html($post_title) . '</span>
					<span class="cleverwa-permalink">' . esc_url( get_the_permalink() ) . '</span>
				</li>';
			}
			wp_reset_postdata();
		}

		if ( '' === $html ) {
			$html.= '<li data-id="">' . esc_html__( 'No Result', 'cleverwa' ) . '</li>';
		}

		echo ent2ncr($html);

		wp_die();

	}

	public function clever_search_accounts(  ) {

		check_ajax_referer( 'cleverwa-search-nonce', 'security' );
		$title = sanitize_text_field( $_POST['title'] );

		global $post;
		$args = array(
			'posts_per_page' => 50,
			's' => $title,
			'post_type' => 'cleverwa_accounts'
		);

		$result = get_posts( $args );
		$html = '';

		foreach ( $result as $post ) {
			setup_postdata( $post );

			$name = get_post_meta( $post->ID, 'cleverwa_name', true );
			$account_title = get_post_meta( $post->ID, 'cleverwa_title', true );
			$avatar = get_the_post_thumbnail_url( $post->ID )
				? get_the_post_thumbnail_url( $post->ID )
				: CLEVERWA_PLUGIN_URL . 'assets/images/logo-green-small.png';


			$post_title = '' !== get_the_title() ? get_the_title() : sprintf( esc_html__( '[No title with ID: %s]', 'cleverwa' ), get_the_ID() );

			$html.= '<div class="cleverwa-item cleverwa-clearfix" data-id="' . get_the_ID() . '" data-name-title="' . esc_attr( $name . ' / ' . $account_title ) . '" data-remove-label="' . esc_attr__( 'Remove', 'cleverwa' ) . '">
						<div class="cleverwa-avatar"><img src="' . esc_url($avatar) . '" alt=""/></div>
						<div class="cleverwa-info cleverwa-clearfix">
							<div class="cleverwa-title">' . esc_html($post_title) . '</div>
							<div class="cleverwa-meta">
								' . esc_html($name . ' / ' . $account_title) . '
							</div>
						</div>
					</div>';
		}
		wp_reset_postdata();

		if ( '' === $html ) {
			$html.= '<div class="cleverwa-item cleverwa-clearfix">' . esc_html__( 'No Result', 'cleverwa' ) . '</div>';
		}

		echo ent2ncr($html);

		wp_die();

	}

}

?>
