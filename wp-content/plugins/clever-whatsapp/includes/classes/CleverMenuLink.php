<?php

class CleverMenuLink {

	private static $menus = array();

	public function __construct () {
		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'clever_add_menu_links' ) );
			add_filter( 'plugin_action_links_' . CLEVERWA_PLUGIN_BASENAME, array( $this, 'clever_add_plugin_action_links' ) );
			add_filter( 'plugin_row_meta', array( $this, 'clever_plugin_row_meta' ), 10, 4 );
			add_filter( 'admin_footer_text', array( $this, 'clever_admin_footer_text' ) );
		}
	}

	public function clever_add_menu_links () {

		$parent_slug = 'cleverwa_parent';

		$this->clever_add_menu_item(
			esc_html__( 'WhatsApp', 'cleverwa' ),
			'',
			$parent_slug,
			'',
			'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAABP0lEQVQoz2XRO0gVcBTH8ZNDVzEpNFIicIpa06VBIQgSDFzcnAJpiCKCwEBuiEi6+KBwikiscNDu0NLQEgpNQctFe4C9aEgjscQX6OfvcB+gcobDOb8vvx+cE6JYTcbl/bbkowmtpX2hZQzju3E33TBiQTLpRAnIyNlxx7GyW8Y1a+bUFIBBSVtZLNUFW56LcN6ue0K7nIZ9SJfkUhiypFqlvKRnH3BE3ovwzpRw3A/JwwMxQxbDN/eF8ETScgDo9id81SeE035675RQoa4IXLccZr0sjhf9M++KrF+yaoRRn0LWX/VFpNkHSZJsqldh0ePQaENvObVKlxmvXRVuSZrDSStuHzpTaJOMidBh22Wd7jpTFmv12pVTKcIjyX/r1qx6ZdCAacu2PHC08Kxnnup2VqMeb3z2xVv9zpXc9gBr2VaI0t5EZgAAAABJRU5ErkJggg=='
		);

		$this->clever_add_menu_item(
			esc_html__( 'Add New Account', 'cleverwa' ),
			'',
			'post-new.php?post_type=cleverwa_accounts',
			$parent_slug
		);

		$this->clever_add_menu_item(
			esc_html__( 'Floating Widget', 'cleverwa' ),
			array( $this, 'clever_get_view' ),
			'cleverwa_floating_widget',
			$parent_slug
		);

		$this->clever_add_menu_item(
			esc_html__( 'WooCommerce Button', 'cleverwa' ),
			array( $this, 'clever_get_view' ),
			'cleverwa_woocommerce_button',
			$parent_slug
		);

		$this->clever_add_menu_item(
			esc_html__( 'General Settings', 'cleverwa' ),
			array( $this, 'clever_get_view' ),
			'cleverwa_settings',
			$parent_slug
		);
	}

	private function clever_add_menu_item ( $title, $callback, $slug, $parent_slug = '', $icon = '' ) {

		if ( '' === $parent_slug ) {
			add_menu_page(
				$title,
				$title,
				'manage_options',
				$slug,
				$callback,
				$icon
			);
		}
		else {
			add_submenu_page(
				$parent_slug,
				$title,
				$title,
				'manage_options',
				$slug,
				$callback,
				null
			);

			self::$menus[$title] = $slug;
		}

	}

	public function clever_get_view () {
		CleverUtils::clever_get_view();
	}

	public static function clever_get_menus () {
		return self::$menus;
	}

	/**
	 * Add 'Settings' link to the plugin page.
	 * This link will only displayed if the plugin is active.
	 */
	public function clever_add_plugin_action_links ( $links ) {
		$settings_link = sprintf( '<a href="admin.php?page=cleverwa_settings">%1$s</a>', esc_html__( 'General Settings', 'cleverwa' ) );
		array_unshift( $links, $settings_link );
		return $links;
	}

	public function clever_plugin_row_meta ( $links, $file ) {
		if ( CLEVERWA_PLUGIN_BASENAME == $file ) {
			$links[] = '<a href="https://doc.cleveraddon.com/clever-whatsapp/" target="_blank">' . esc_html__( 'Read Documentation', 'cleverwa' ) . '</a>';
			$links[] = '<a href="https://support.cleversoft.co/" target="_blank">' . esc_html__( 'Get Support', 'cleverwa' ) . '</a>';
		}
		return $links;
	}

	/**
	 * Ask for some stars at the bottom of admin page
	 */
	public function clever_admin_footer_text ( $default ) {
		global $pagenow;

		$setting_pages = array(
			CLEVERWA_PREFIX . '_settings',
			CLEVERWA_PREFIX . '_floating_widget',
			CLEVERWA_PREFIX . '_woocommerce_button'
		);


		$post_type = filter_input( INPUT_GET, 'post_type' );
		if ( ! $post_type ) {
			$post_type = get_post_type( filter_input( INPUT_GET, 'post' ) );
		}

		if ( 'admin.php' === $pagenow && isset( $_GET['page'] ) && in_array( $_GET['page'], $setting_pages ) ||
				'cleverwa_accounts' === $post_type ) {

			$plugin_data = get_plugin_data( CLEVERWA_PLUGIN_BOOTSTRAP_FILE, false, true );
			echo esc_html__( 'WhatsApp Click to Chat Version', 'cleverwa') . ' ' . $plugin_data['Version'];
			echo ' ' . esc_html__( 'by', 'cleverwa' ) . ' <a href="https://cleveraddon.com/" target="_blank">Clever Addon</a>' ;
		}
		else {
			echo ent2ncr($default);
		}
	}

}

?>
