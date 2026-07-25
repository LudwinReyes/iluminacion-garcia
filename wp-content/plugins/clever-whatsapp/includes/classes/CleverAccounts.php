<?php

class CleverAccounts {

	public function __construct () {

		add_action( 'init', array( $this, 'clever_register_post_type_accounts' ) );

		if ( ! is_admin() ) {
			return;
		}

		add_filter( 'manage_cleverwa_accounts_posts_columns', array( $this, 'clever_accounts_post_type_columns' ) );
		add_action( 'manage_cleverwa_accounts_posts_custom_column', array( $this, 'clever_accounts_post_type_columns_data' ), 10, 2 );

		add_filter( 'manage_edit-cleverwa_accounts_sortable_columns', array( $this, 'clever_accounts_sortable_columns' ) );

		add_action( 'add_meta_boxes', array( $this, 'clever_add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'clever_save_meta_boxes' ) );

	}

	public function clever_register_post_type_accounts () {
		$labels = array(
			'name'               => _x( 'WhatsApp Accounts', 'post type general name', 'cleverwa' ),
			'singular_name'      => _x( 'WhatsApp Account', 'post type singular name', 'cleverwa' ),
			'menu_name'          => _x( 'Accounts', 'admin menu', 'cleverwa' ),
			'name_admin_bar'     => _x( 'Account', 'add new on admin bar', 'cleverwa' ),
			'add_new'            => _x( 'Add New', 'book', 'cleverwa' ),
			'add_new_item'       => __( 'Add New Account', 'cleverwa' ),
			'new_item'           => __( 'New Account', 'cleverwa' ),
			'edit_item'          => __( 'Edit Account', 'cleverwa' ),
			'view_item'          => __( 'View Account', 'cleverwa' ),
			'all_items'          => __( 'All Accounts', 'cleverwa' ),
			'search_items'       => __( 'Search Accounts', 'cleverwa' ),
			'parent_item_colon'  => __( 'Parent Accounts:', 'cleverwa' ),
			'not_found'          => __( 'No accounts found.', 'cleverwa' ),
			'not_found_in_trash' => __( 'No accounts found in Trash.', 'cleverwa' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'WhatsApp Accounts', 'cleverwa' ),
			'public'             => false,
			'exclude_from_search'=> true,
			'show_ui'            => true,
			'show_in_menu'       => 'cleverwa_parent',
			'query_var'          => false,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'menu_position'      => null,
			'supports'           => array( 'title', 'thumbnail' )
		);

		register_post_type( 'cleverwa_accounts', $args );
	}

	public function clever_accounts_post_type_columns ( $defaults ) {
		unset( $defaults['title'] );
		unset( $defaults['date'] );
		$defaults['title']  = esc_html__( 'Account Title', 'cleverwa' );
		$defaults['picture']  = esc_html__( 'Picture', 'cleverwa' );
		$defaults['number']  = esc_html__( 'Number', 'cleverwa' );
		$defaults['role']  = esc_html__( 'Role Title', 'cleverwa' );
		$defaults['pinned']  = esc_html__( 'Pin Account', 'cleverwa' );
		return $defaults;
	}

	public function clever_accounts_post_type_columns_data ( $column_name, $post_id ) {
		if ( $column_name == 'picture' ) {
			if ( has_post_thumbnail( $post_id ) ) {
				echo '<img src="' . get_the_post_thumbnail_url() . '" style="max-width: 40px;"/>';
			}
		}
		if ( $column_name == 'number' ) {
			echo get_post_meta( $post_id, 'cleverwa_number', true );
		}
		if ( $column_name == 'role' ) {
			echo get_post_meta( $post_id, 'cleverwa_title', true );
		}
		if ( $column_name == 'pinned' ) {
			echo get_post_meta( $post_id, 'cleverwa_pin_account', true ) === 'on' ? esc_html__( 'Yes', 'cleverwa' ) : esc_html__( 'No', 'cleverwa' );
		}
	}

	public function clever_accounts_sortable_columns ( $columns ) {
		$columns['number'] = 'number';
		$columns['time'] = 'time';
		return $columns;
	}

	public function clever_add_meta_boxes () {

		$screen = get_current_screen();

		add_meta_box(
			'cleverwa-links',
			esc_html__( 'Links', 'cleverwa' ),
			array( $this, 'clever_links' ),
			array( 'cleverwa_accounts' ),
			'side'
		);

		if( 'add' !== $screen->action ) {
			add_meta_box(
				'cleverwa-copy-shortcode',
				esc_html__( 'Shortcode for this account', 'cleverwa' ),
				array( $this, 'clever_copy_shortcode' ),
				array( 'cleverwa_accounts' ),
				'side'
			);
		}

		add_meta_box(
			'cleverwa-account-information',
			esc_html__( 'WhatsApp Account Information', 'cleverwa' ),
			array( $this, 'clever_account_information' ),
			array( 'cleverwa_accounts' ),
			'normal'
		);

		add_meta_box(
			'cleverwa-page-targeting',
			esc_html__( 'Page Targeting', 'cleverwa' ),
			array( $this, 'clever_page_targeting' ),
			array( 'cleverwa_accounts' ),
			'normal'
		);

		add_meta_box(
			'cleverwa-button-style',
			esc_html__( 'Button Style', 'cleverwa' ),
			array( $this, 'clever_button_style' ),
			array( 'cleverwa_accounts' ),
			'normal'
		);

	}

	public function clever_account_information ( $post ) {

		global $pagenow;

		$new = 'post-new.php' === $pagenow ? true : false;

		$number = sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_number', true ) );
		$name = sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_name', true ) );
		$title = sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_title', true ) );
		$predefined_text = sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_predefined_text', true ) );
		if ( function_exists( 'sanitize_textarea_field' ) ) {
			$predefined_text = sanitize_textarea_field( get_post_meta( $post->ID, 'cleverwa_predefined_text', true ) );
		}

		$button_label = sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_button_label', true ) );

		$hour_start = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_hour_start', true ) ) : '';
		$minute_start = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_minute_start', true ) ) : '';
		$hour_end = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_hour_end', true ) ) : '23';
		$minute_end = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_minute_end', true ) ) : '59';

		$sunday = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_sunday', true ) ) : 'on';
		$monday = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_monday', true ) ) : 'on';
		$tuesday = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_tuesday', true ) ) : 'on';
		$wednesday = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_wednesday', true ) ) : 'on';
		$thursday = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_thursday', true ) ) : 'on';
		$friday = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_friday', true ) ) : 'on';
		$saturday = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_saturday', true ) ) : 'on';

		$hide_on_large_screen = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_hide_on_large_screen', true ) ) : 'off';
		$hide_on_small_screen = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_hide_on_small_screen', true ) ) : 'off';

		$pin_account = ! $new ? sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_pin_account', true ) ) : 'off';

		$offline_text = sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_offline_text', true ) );

		$availability = array(
			'sunday' => array(
				'label' => esc_html( 'Sunday', 'cleverwa' ),
				'enable' => 0,
				'hour_start' => 0,
				'minute_start' => 0,
				'hour_end' => 23,
				'minute_end' => 59
			)
			,
			'monday' => array(
				'label' => esc_html( 'Monday', 'cleverwa' ),
				'enable' => 1,
				'hour_start' => 0,
				'minute_start' => 0,
				'hour_end' => 23,
				'minute_end' => 59
			)
			,
			'tuesday' => array(
				'label' => esc_html( 'Tuesday', 'cleverwa' ),
				'enable' => 1,
				'hour_start' => 0,
				'minute_start' => 0,
				'hour_end' => 23,
				'minute_end' => 59
			)
			,
			'wednesday' => array(
				'label' => esc_html( 'Wednesday', 'cleverwa' ),
				'enable' => 1,
				'hour_start' => 0,
				'minute_start' => 0,
				'hour_end' => 23,
				'minute_end' => 59
			)
			,
			'thursday' => array(
				'label' => esc_html( 'Thursday', 'cleverwa' ),
				'enable' => 1,
				'hour_start' => 0,
				'minute_start' => 0,
				'hour_end' => 23,
				'minute_end' => 59
			)
			,
			'friday' => array(
				'label' => esc_html( 'Friday', 'cleverwa' ),
				'enable' => 1,
				'hour_start' => 0,
				'minute_start' => 0,
				'hour_end' => 23,
				'minute_end' => 59
			)
			,
			'saturday' => array(
				'label' => esc_html( 'Saturday', 'cleverwa' ),
				'enable' => 0,
				'hour_start' => 0,
				'minute_start' => 0,
				'hour_end' => 23,
				'minute_end' => 59
			)
		);

		$existing_availability = json_decode( sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_availability', true ) ), true );
		$existing_availability = is_array( $existing_availability ) ? $existing_availability : array();
		foreach ( $existing_availability as $k => $v ) {
			if ( 	isset( $availability[ $k ] ) &&
					isset( $availability[ $k ][ 'enable' ]) &&
					isset( $availability[ $k ][ 'hour_start' ] ) &&
					isset( $availability[ $k ][ 'minute_start' ] ) &&
					isset( $availability[ $k ][ 'hour_end' ] ) &&
					isset( $availability[ $k ][ 'minute_end' ] )
				) {

				$availability[ $k ][ 'enable' ] = (isset($v[ 'enable' ])) ? $v[ 'enable' ] : 0;
				$availability[ $k ][ 'hour_start' ] = $v[ 'hour_start' ];
				$availability[ $k ][ 'minute_start' ] = $v[ 'minute_start' ];
				$availability[ $k ][ 'hour_end' ] = $v[ 'hour_end' ];
				$availability[ $k ][ 'minute_end' ] = $v[ 'minute_end' ];

			}
		}

		?>

		<table class="form-table" id="cleverwa-custom-wc-button-settings">
			<tbody>
				<tr>
					<th scope="row"><label for="cleverwa_number"><?php esc_html_e( 'Account Number or group chat URL', 'cleverwa' ); ?></label></th>
					<td>
						<p>
							<input type="text" class="widefat" id="cleverwa_number" name="cleverwa_number" value="<?php echo esc_attr( $number ); ?>" />
							<p class="description"><?php printf( esc_html__( 'Refer to %s for a detailed explanation.', 'cleverwa' ), '<a href="https://faq.whatsapp.com/en/general/21016748" target="_blank">https://faq.whatsapp.com/en/general/21016748</a>' ); ?></p>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="cleverwa_name"><?php esc_html_e( 'Name', 'cleverwa' ); ?></label></th>
					<td>
						<input type="text" id="cleverwa_name" name="cleverwa_name" value="<?php echo esc_attr( $name ); ?>" class="widefat" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="cleverwa_title"><?php esc_html_e( 'Title', 'cleverwa' ); ?></label></th>
					<td>
						<input type="text" id="cleverwa_title" name="cleverwa_title" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="cleverwa_predefined_text"><?php esc_html_e( 'Predefined Text', 'cleverwa' ); ?></label></th>
					<td>
						<textarea name="cleverwa_predefined_text" id="cleverwa_predefined_text" rows="3" class="widefat"><?php echo esc_textarea( $predefined_text ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Use [cleverwa_page_title] and [cleverwa_page_url] shortcodes to output the page\'s title and URL respectively. ', 'cleverwa' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="cleverwa_button_label"><?php esc_html_e( 'Button Label', 'cleverwa' ); ?></label></th>
					<td>
						<input type="text" id="cleverwa_button_label" name="cleverwa_button_label" value="<?php echo esc_attr( $button_label ); ?>" placeholder="<?php echo CleverUtils::clever_get_setting( 'button_label', esc_html__( 'Need help? Chat via WhatsApp', 'cleverwa' ) ); ?>" class="widefat" />
						<p class="description"><?php esc_html_e( 'This text applies only on shortcode button. Leave empty to use the default label.', 'cleverwa' ); ?></p>
					</td>
				</tr>

				<tr>
					<th scope="row"><label for="cleverwa_availability"><?php esc_html_e( 'Availability', 'cleverwa' ); ?></label></th>
					<td>
						<?php foreach ( $availability as $k => $v ) : ?>

							<p>
								<span style="display: inline-block; min-width: 150px;"><?php $this->clever_display_availability_enable($k, $v['enable']); ?><strong><label for="clever_display_availability_enable_<?php echo esc_html($k); ?>"><?php echo esc_html($v['label']); ?></a></strong></span>
								<span style="display: inline-block; margin-right: 15px;">
									<select name="cleverwa_availability[<?php echo esc_html($k); ?>][hour_start]">
										<?php $this->clever_display_availability_options( 'hour', $v['hour_start'] ); ?>
									</select> :
									<select name="cleverwa_availability[<?php echo esc_html($k); ?>][minute_start]">
										<?php $this->clever_display_availability_options( 'minute', $v['minute_start'] ); ?>
									</select> <?php esc_html_e( 'to', 'cleverwa' ); ?>
									<select name="cleverwa_availability[<?php echo esc_html($k); ?>][hour_end]">
										<?php $this->clever_display_availability_options( 'hour', $v['hour_end'] ); ?>
									</select> :
									<select name="cleverwa_availability[<?php echo esc_html($k); ?>][minute_end]">
										<?php $this->clever_display_availability_options( 'minute', $v['minute_end'] ); ?>
									</select>
								</span>
								<?php if ($k=="sunday"): ?>
									<span>
										<input data-day="<?php echo esc_html($k); ?>" id="cleverwa_availability_apply_to_add_days" class="button" type="button" value="<?php echo esc_html_e('Apply to All Days', 'cleverwa'); ?>" />
									</span>
								<?php endif; ?>
							</p><br/>

						<?php endforeach; ?>

						<?php if ( '' === trim( get_option( 'timezone_string' ) ) && '' === get_option( 'gmt_offset' ) ) : ?>

							<p><a href="options-general.php"><?php esc_html_e( 'Please set your time zone first so we can have an accurate time availability.', 'cleverwa' ); ?></a></p>

						<?php else : ?>

							<p class="description"><?php printf( esc_html__( 'Note that the timezone currently in use is %s', 'cleverwa' ), '<a href="options-general.php#timezone_string" target="_blank">' . ( '' !== get_option( 'timezone_string' ) ? get_option( 'timezone_string' ) : get_option( 'gmt_offset' ) ) . '</a>' ); ?></p>

						<?php endif; ?>
					</td>
				</tr>

				<tr>
					<th scope="row"><label for=""><?php esc_html_e( 'Pin this account', 'cleverwa' ); ?></label></th>
					<td>
						<p><input type="checkbox" name="cleverwa_pin_account" value="on" id="cleverwa_pin_account" <?php checked( 'on', $pin_account ); ?> /> <label for="cleverwa_pin_account"><?php esc_html_e( 'Yes, pin this account.', 'cleverwa' ); ?></label></p>
						<p class="description"><?php esc_html_e( 'If checked, this account will always be placed on top even when the list is randomized.', 'cleverwa' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for=""><?php esc_html_e( 'Display based on screen width', 'cleverwa' ); ?></label></th>
					<td>
						<p><input type="checkbox" name="cleverwa_hide_on_large_screen" value="on" id="cleverwa_hide_on_large_screen" <?php checked( 'on', $hide_on_large_screen ); ?> /> <label for="cleverwa_hide_on_large_screen"><?php esc_html_e( 'Hide on large screen (wider than 782px)', 'cleverwa' ); ?></label></p>
						<p><input type="checkbox" name="cleverwa_hide_on_small_screen" value="on" id="cleverwa_hide_on_small_screen" <?php checked( 'on', $hide_on_small_screen ); ?> /> <label for="cleverwa_hide_on_small_screen"><?php esc_html_e( 'Hide on small screen (narrower than 783px)', 'cleverwa' ); ?></label></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="cleverwa_offline_text"><?php esc_html_e( 'Description text when offline', 'cleverwa' ); ?></label></th>
					<td>
						<input type="text" id="cleverwa_offline_text" name="cleverwa_offline_text" value="<?php echo esc_attr( $offline_text ); ?>" class="widefat" />
						<p class="description"><?php esc_html_e( 'If this field is left blank, the account will be hidden when not available.', 'cleverwa' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>

		<?php

		wp_nonce_field( 'cleverwa_account_meta_box', 'cleverwa_account_meta_box_nonce' );
	}

	public function clever_display_availability_options ( $time, $value ) {
		$limit = 'hour' === $time ? 23 : 59;

		for ( $i = 0; $i <= $limit; $i++ ) {
			$text_number = strlen( $i ) < 2 ? '0' . $i : $i;
			$selected = intval( $value ) === $i ? 'selected' : '';
			echo '<option value="' . htmlspecialchars($text_number) . '" ' . esc_html($selected) . '>' . esc_html($text_number) . '</option>';
		}

	}

	public function clever_display_availability_enable ( $date, $value ) {
		if ($value==1) {
			echo '<input value="1" type="checkbox" name="cleverwa_availability['. esc_html($date) . '][enable]" id="clever_display_availability_enable_'.esc_html($date).'" checked />';
		} else {
			echo '<input value="1" type="checkbox" name="cleverwa_availability['. esc_html($date) . '][enable]" id="clever_display_availability_enable_'.esc_html($date).'" />';
		}
	}

	public function clever_get_inclusion ( $ids, $category ) {

		$ids = is_array( $ids ) ? $ids : array();
		$html = '';
		$category = 'included' === strtolower( $category ) ? 'included' : 'excluded';

		foreach ( $ids as $k => $v ) {
			if ( filter_var( $v, FILTER_VALIDATE_URL ) !== FALSE ) {
				$the_url = esc_url( $v );
				$html.= '
				<li id="cleverwa-included-url-' . esc_html($k) . '">
					<p class="cleverwa-permalink"><a href="' . esc_url($the_url) . '" target="_blank">' .esc_html($the_url) . '</a></p>
					<span class="dashicons dashicons-no"></span>
					<input type="hidden" name="cleverwa_' . esc_html($category) . '[]" value="' . esc_html($the_url) . '"/>
				</li>';
				unset( $ids[ $k ] );
			}
		}

		if ( count( $ids ) > 0 ) {
			global $post;
			$included_posts = get_posts( array(
				'posts_per_page' => -1,
				'post__in' => $ids,
				'post_type' => 'any'
			) );

			foreach ( $included_posts as $post ) {

				setup_postdata( $post );

				$html.= '
				<li id="cleverwa-included-' . get_the_ID() . '">
					<p class="cleverwa-title">' . get_the_title() . '</p>
					<p class="cleverwa-permalink"><a href="' . esc_url( get_the_permalink() ) . '" target="_blank">' . esc_url( get_the_permalink() ) . '</a></p>
					<span class="dashicons dashicons-no"></span>
					<input type="hidden" name="cleverwa_' . esc_html($category) . '[]" value="' . get_the_ID() . '"/>
				</li>';

			}
			wp_reset_postdata();
		}
		return $html;
	}

	public function clever_page_targeting ( $post ) {

		global $pagenow;

		$new = 'post-new.php' === $pagenow ? true : false;

		if ( $new ) {
			$target = array( 'home', 'blog', 'archive', 'page', 'post' );
		}
		else {
			$target = json_decode( get_post_meta( $post->ID, 'cleverwa_target', true ) );
			$target = is_array( $target ) ? $target : array();
		}

		/* Include and exclude ids */

		$included_html = $this->clever_get_inclusion ( json_decode( get_post_meta( $post->ID, 'cleverwa_included_ids', true ) ), 'included' );
		$excluded_html = $this->clever_get_inclusion ( json_decode( get_post_meta( $post->ID, 'cleverwa_excluded_ids', true ) ), 'excluded' );


		/* WPML languages */

		$current_target_languages = json_decode( get_post_meta( $post->ID, 'cleverwa_target_languages', true ) );
		$current_target_languages = is_array( $current_target_languages ) ? $current_target_languages : array();

		$languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );

		?>
		<p class="description"><?php esc_html_e( 'Page targeting applies only to accounts inside the floating widget. It will be ignored on shortcode buttons. Make sure to clear the cache after saving this post if you use a caching plugin.', 'cleverwa' ); ?></p>

		<table class="form-table" id="cleverwa-custom-wc-button-settings">
			<tbody>
				<tr>
					<th scope="row"><label for=""><?php esc_html_e( 'Show on these post types', 'cleverwa' ); ?></label></th>
					<td>
						<p>
							<input type="checkbox" name="cleverwa_target[home]" id="cleverwa_target[home]" value="home" <?php echo in_array( 'home', $target ) ? 'checked' : '' ?> />
							<label for="cleverwa_target[home]"><?php esc_html_e( 'Homepage', 'cleverwa' ); ?></label>
						</p>
						<p>
							<input type="checkbox" name="cleverwa_target[blog]" id="cleverwa_target[blog]" value="blog" <?php echo in_array( 'blog', $target ) ? 'checked' : '' ?> />
							<label for="cleverwa_target[blog]"><?php esc_html_e( 'Blog Index', 'cleverwa' ); ?></label>
						</p>
						<p>
							<input type="checkbox" name="cleverwa_target[archive]" id="cleverwa_target[archive]" value="archive" <?php echo in_array( 'archive', $target ) ? 'checked' : '' ?> />
							<label for="cleverwa_target[archive]"><?php esc_html_e( 'Archives', 'cleverwa' ); ?></label>
						</p>
						<p>
							<input type="checkbox" name="cleverwa_target[page]" id="cleverwa_target[page]" value="page" <?php echo in_array( 'page', $target ) ? 'checked' : '' ?> />
							<label for="cleverwa_target[page]"><?php esc_html_e( 'Pages', 'cleverwa' ); ?></label>
						</p>
						<p>
							<input type="checkbox" name="cleverwa_target[post]" id="cleverwa_target[post]" value="post" <?php echo in_array( 'post', $target ) ? 'checked' : '' ?> />
							<label for="cleverwa_target[post]"><?php esc_html_e( 'Blog posts', 'cleverwa' ); ?></label>
						</p>
						<?php foreach ( get_post_types( array( '_builtin' => false ), 'objects' ) as $post_type ) : ?>
						<p>
							<input type="checkbox" name="cleverwa_target[<?php echo esc_html($post_type->name); ?>]" id="cleverwa_target[<?php echo esc_html($post_type->name); ?>]" value="<?php echo esc_html($post_type->name); ?>" <?php echo in_array( $post_type->name, $target ) ? 'checked' : '' ?>/>
							<label for="cleverwa_target[<?php echo esc_html($post_type->name); ?>]"><?php echo esc_html( $post_type->label ); ?></label>
						</p>
						<?php endforeach; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Include Pages' , 'cleverwa'); ?></th>
					<td>
						<div class="cleverwa-search-posts">
							<input type="text" class="regular-text" placeholder="<?php esc_attr_e( 'Type the title of page/post to include', 'cleverwa' ); ?>" data-nonce="<?php echo wp_create_nonce( 'cleverwa-search-nonce' ); ?>" />
							<div class="cleverwa-search-result">
								<ul></ul>
							</div>
						</div>
						<p class="cleverwa-listing-info"><span><?php esc_html_e( 'Included pages:', 'cleverwa' ); ?></span></p>

						<ul class="cleverwa-inclusion cleverwa-included-posts" data-delete-label="<?php esc_attr_e( 'Delete', 'cleverwa' ); ?>">
							<?php echo ent2ncr($included_html); ?>
							<li class="cleverwa-placeholder"><?php esc_html_e( 'No specific page is included.', 'cleverwa' ); ?></li>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Exclude Pages' , 'cleverwa'); ?></th>
					<td>
						<div class="cleverwa-search-posts">
							<input type="text" class="regular-text" placeholder="<?php esc_attr_e( 'Type the title of page/post to exclude', 'cleverwa' ); ?>" data-nonce="<?php echo wp_create_nonce( 'cleverwa-search-nonce' ); ?>" />
							<div class="cleverwa-search-result">
								<ul></ul>
							</div>
						</div>
						<p class="cleverwa-listing-info"><span><?php esc_html_e( 'Excluded pages:', 'cleverwa' ); ?></span></p>

						<ul class="cleverwa-inclusion cleverwa-excluded-posts" data-delete-label="<?php esc_attr_e( 'Delete', 'cleverwa' ); ?>">
							<?php echo ent2ncr($excluded_html); ?>
							<li class="cleverwa-placeholder"><?php esc_html_e( 'None. All pages from checked post types above are included.', 'cleverwa' ); ?></li>
						</ul>
					</td>
				</tr>

				<?php if ( is_array( $languages ) ) : ?>
					<tr>
						<th scope="row"><?php esc_html_e( 'WPML Languages' , 'cleverwa'); ?></th>
						<td>
							<?php foreach ( $languages as $k => $v ) : ?>
							<p>
								<input type="checkbox" name="cleverwa_target_languages[<?php echo esc_html($v['code']); ?>]" id="cleverwa_target_languages[<?php echo esc_html($v['code']); ?>]" value="<?php echo esc_html($v['code']); ?>" <?php echo in_array( $v['code'], $current_target_languages ) ? 'checked' : '' ?>/>
								<label for="cleverwa_target_languages[<?php echo esc_html($v['code']); ?>]"><?php echo esc_html( $v['translated_name'] ); ?></label>
							</p>
							<?php endforeach;?>
							<p class="description"><span><?php esc_html_e( 'If none are selected, then the account will be displayed on all languages.', 'cleverwa' ); ?></span></p>
						</td>
					</tr>
				<?php endif; ?>

			</tbody>
		</table>

		<?php

	}

	public function clever_button_style ( $post ) {

		global $pagenow;

		$new = 'post-new.php' === $pagenow ? true : false;

		$background_color = sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_background_color', true ) );
		$background_color_on_hover = sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_background_color_on_hover', true ) );
		$text_color = sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_text_color', true ) );
		$text_color_on_hover = sanitize_text_field( get_post_meta( $post->ID, 'cleverwa_text_color_on_hover', true ) );

		?>
		<p class="description"><?php printf( esc_html__( 'This styling applies only to the shortcode buttons for this account. Floating widget has its own styling. If left blank (recommended for consistency), then the button will use the %1$s.', 'cleverwa' ), '<a href="admin.php?page=cleverwa_settings#cleverwa-default-settings">' . esc_html__( 'default styles set on the settings page', 'cleverwa' ) . '</a>' ); ?></p>
		<table class="form-table" id="cleverwa-custom-wc-button-settings">
			<tbody>
				<tr>
					<th scope="row"><label for="cleverwa_background_color"><?php esc_html_e( 'Button Background Color', 'cleverwa' ); ?></label></th>
					<td><input name="cleverwa_background_color" type="text" id="cleverwa_background_color" class="minicolors" value="<?php echo esc_html($background_color); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="cleverwa_text_color"><?php esc_html_e( 'Button Text Color', 'cleverwa' ); ?></label></th>
					<td><input name="cleverwa_text_color" type="text" id="cleverwa_text_color" class="minicolors" value="<?php echo esc_html($text_color); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="cleverwa_background_color_on_hover"><?php esc_html_e( 'Button Background Color on Hover', 'cleverwa' ); ?></label></th>
					<td><input name="cleverwa_background_color_on_hover" type="text" id="cleverwa_background_color_on_hover" class="minicolors" value="<?php echo esc_html($background_color_on_hover); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="cleverwa_text_color_on_hover"><?php esc_html_e( 'Button Text Color on Hover', 'cleverwa' ); ?></label></th>
					<td><input name="cleverwa_text_color_on_hover" type="text" id="cleverwa_text_color_on_hover" class="minicolors" value="<?php echo esc_html($text_color_on_hover); ?>"></td>
				</tr>
			</tbody>
		</table>

		<?php
	}

	public function clever_copy_shortcode ( $post ) {

		?>

		<p><?php esc_html_e( 'Copy the shortcode below and paste it into the editor to display the button.', 'cleverwa' ); ?></p>
		<p><input type="text" value='[cleverwa_button id="<?php echo get_the_ID(); ?>"]' class="widefat" onkeypress="return event.keyCode != 13;" readonly /></p>
		<?php

	}

	public function clever_links ( $post ) {

		echo '	<ul>
					<li><a href="https://doc.cleveraddon.com/clever-whatsapp/#/" target="_blank">' . esc_html__( 'Documentation', 'cleverwa' ) . '</a></li>
					<li><a href="http://anon.wp1.zootemplate.com/" target="_blank">' . esc_html__( 'Live Demo', 'cleverwa' ) . '</a></li>
					<li><a href="https://support.cleversoft.co/" target="_blank">' . esc_html__( 'Support', 'cleverwa' ) . '</a></li>
				</ul>';

	}

	public function clever_save_meta_boxes ( $post_id ) {

		/* Check if our nonce is set. */
		if ( ! isset( $_POST['cleverwa_account_meta_box_nonce'] ) ) {
			return;
		}

		$nonce = $_POST['cleverwa_account_meta_box_nonce'];

		/* Verify that the nonce is valid. */
		if ( ! wp_verify_nonce( $nonce, 'cleverwa_account_meta_box' ) ) {
			return;
		}

		/* WhatsApp Account Information */

		$number = isset( $_POST['cleverwa_number'] ) ? sanitize_text_field( trim( $_POST['cleverwa_number'] ) ) : '';
		$name = isset( $_POST['cleverwa_name'] ) ? sanitize_text_field( trim( $_POST['cleverwa_name'] ) ) : '';
		$title = isset( $_POST['cleverwa_title'] ) ? sanitize_text_field( trim( $_POST['cleverwa_title'] ) ) : '';
		$predefined_text = isset( $_POST['cleverwa_predefined_text'] ) ? sanitize_text_field( trim( $_POST['cleverwa_predefined_text'] ) ) : '';
		if ( function_exists( 'sanitize_textarea_field' ) ) {
			$predefined_text = isset( $_POST['cleverwa_predefined_text'] ) ? sanitize_textarea_field( trim( $_POST['cleverwa_predefined_text'] ) ) : '';
		}

		$button_label = isset( $_POST['cleverwa_button_label'] ) ? sanitize_text_field( trim( $_POST['cleverwa_button_label'] ) ) : '';
		$availability = isset( $_POST['cleverwa_availability'] ) ? json_encode( $_POST['cleverwa_availability'] ) : json_encode( array() );

		$offline_text = isset( $_POST['cleverwa_offline_text'] ) ? sanitize_text_field( trim( $_POST['cleverwa_offline_text'] ) ) : '';

		$hide_on_large_screen = isset( $_POST['cleverwa_hide_on_large_screen'] ) ? 'on' : 'off';
		$hide_on_small_screen = isset( $_POST['cleverwa_hide_on_small_screen'] ) ? 'on' : 'off';

		$pin_account = isset( $_POST['cleverwa_pin_account'] ) ? 'on' : 'off';

		update_post_meta( $post_id, 'cleverwa_number', $number );
		update_post_meta( $post_id, 'cleverwa_name', $name );
		update_post_meta( $post_id, 'cleverwa_title', $title );
		update_post_meta( $post_id, 'cleverwa_predefined_text', $predefined_text );
		update_post_meta( $post_id, 'cleverwa_button_label', $button_label );
		update_post_meta( $post_id, 'cleverwa_availability', $availability );
		update_post_meta( $post_id, 'cleverwa_offline_text', $offline_text );

		update_post_meta( $post_id, 'cleverwa_hide_on_large_screen', $hide_on_large_screen );
		update_post_meta( $post_id, 'cleverwa_hide_on_small_screen', $hide_on_small_screen );

		update_post_meta( $post_id, 'cleverwa_pin_account', $pin_account );


		/* Button Style */

		$background_color = isset( $_POST['cleverwa_background_color'] ) ? sanitize_text_field( trim( $_POST['cleverwa_background_color'] ) ) : '';
		$background_color_on_hover = isset( $_POST['cleverwa_background_color_on_hover'] ) ? sanitize_text_field( trim( $_POST['cleverwa_background_color_on_hover'] ) ) : '';
		$text_color = isset( $_POST['cleverwa_text_color'] ) ? sanitize_text_field( trim( $_POST['cleverwa_text_color'] ) ) : '';
		$text_color_on_hover = isset( $_POST['cleverwa_text_color_on_hover'] ) ? sanitize_text_field( trim( $_POST['cleverwa_text_color_on_hover'] ) ) : '';

		update_post_meta( $post_id, 'cleverwa_background_color', $background_color );
		update_post_meta( $post_id, 'cleverwa_background_color_on_hover', $background_color_on_hover );
		update_post_meta( $post_id, 'cleverwa_text_color', $text_color );
		update_post_meta( $post_id, 'cleverwa_text_color_on_hover', $text_color_on_hover );

		/* Page Targeting */

		if ( isset( $_POST['cleverwa_target'] ) ) {
			$t = array();
			foreach ( $_POST['cleverwa_target'] as $value ) {
				$t[] = sanitize_text_field( $value );
			}
			update_post_meta( $post_id, 'cleverwa_target', json_encode( $t ) );
		}
		else {
			update_post_meta( $post_id, 'cleverwa_target', json_encode( array() ) );
		}

		/* Included pages */
		if ( isset( $_POST['cleverwa_included'] ) ) {
			$in_ids = array();
			foreach ( $_POST['cleverwa_included'] as $value ) {
				$in_ids[] = sanitize_text_field( $value );
			}
			update_post_meta( $post_id, 'cleverwa_included_ids', json_encode( $in_ids ) );
		}
		else {
			update_post_meta( $post_id, 'cleverwa_included_ids', json_encode( array() ) );
		}

		/* Excluded pages */
		if ( isset( $_POST['cleverwa_excluded'] ) ) {
			$ex_ids = array();
			foreach ( $_POST['cleverwa_excluded'] as $value ) {
				$ex_ids[] = sanitize_text_field( $value );
			}
			update_post_meta( $post_id, 'cleverwa_excluded_ids', json_encode( $ex_ids ) );
		}
		else {
			update_post_meta( $post_id, 'cleverwa_excluded_ids', json_encode( array() ) );
		}

		/* WPML languages */
		if ( isset( $_POST['cleverwa_target_languages'] ) ) {
			$t = array();
			foreach ( $_POST['cleverwa_target_languages'] as $value ) {
				$t[] = sanitize_text_field( $value );
			}
			update_post_meta( $post_id, 'cleverwa_target_languages', json_encode( $t ) );
		}
		else {
			update_post_meta( $post_id, 'cleverwa_target_languages', json_encode( array() ) );
		}

	}

}

?>
