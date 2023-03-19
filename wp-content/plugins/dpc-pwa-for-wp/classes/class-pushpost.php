<?php

namespace PWAForWP;

class PushPost {

	public function __construct() {
	}

	public function run() {

		if ( ! pwa_push_set() ) {
			return;
		}

		add_action( 'add_meta_boxes', [ $this, 'meta_box' ] );

		add_action( 'admin_init', [ $this, 'save_post_types' ], 50 );
		add_action( 'pwa_settings', [ $this, 'settings' ] );
		add_filter( 'pwa_admin_footer_js', [ $this, 'post_types_footer' ] );
	}

	public function meta_box() {

		foreach ( get_option( 'pwa_post_types' ) as $pt => $values ) {
			if ( ! pwa_get_setting( "pwa_pushpost_active_{$pt}" ) ) {
				continue;
			}
			add_meta_box( 'pushpost-meta-box', __( '📢 Push Notifications', 'pwa' ), function ( $post ) use ( $pt ) {
				$class = '';
				if ( get_post_meta( $post->ID, 'pwa_pushpost', true ) == 'done' ) {
					$class = 'pushpost-done';
				}
				echo '<div class="pushpost-meta-container ' . $class . '">';
				echo '<div class="pushpost-meta pushpost-meta--send">';
				echo '<p>' . __( 'This function opens the push notification modal for this post.', 'pwa' ) . '</p>';
				echo pwa_get_instance()->Push->render_push_modal( get_the_title( $post ), 'New Post Published!', get_permalink( $post ), get_post_thumbnail_id( $post ), '', $post->ID );
				echo '</div>';

				echo '<div class="pushpost-meta pushpost-meta--done">';
				echo '<p>' . __( 'Push notification has already been sent. Do you want to send it again?', 'pwa' ) . '</p>';
				echo '<p><a class="pushpost-meta__sendagain" data-confirmation="' . esc_attr( __( 'Are you sure you want to send a new push notification?', 'pwa' ) ) . '">' . __( 'Send again', 'pwa' ) . '</a></p>';
				echo '</div>';
				echo '</div>';
			}, $pt, 'side' );
		}
	}

	public function save_post_types() {

		$post_types_builtin = get_post_types( [
			'public'   => true,
			'show_ui'  => true,
			'_builtin' => true,
		] );

		$post_types = get_post_types( [
			'public'   => true,
			'show_ui'  => true,
			'_builtin' => false,
		] );

		$post_types = array_merge( $post_types_builtin, $post_types );
		unset( $post_types['attachment'] );

		$save = [];
		foreach ( $post_types as $pt ) {
			$obj         = get_post_type_object( $pt );
			$save[ $pt ] = [
				'name'          => $obj->labels->name,
			];
		}

		update_option( 'pwa_post_types', $save );
	}

	public function settings() {

		$post_types = get_option( 'pwa_post_types' );

		if ( ! is_array( $post_types ) ) {
			return;
		}

		$section_desc = __( 'Add a meta box to the post edit screen from where you can easily send a push notifications to all users with this post details', 'pwa' );
		$section      = pwa_settings()->add_section( pwa_settings_page_push(), 'pwa_pushpost', __( '📌 Push Notification Meta Box', 'pwa' ), $section_desc );

		foreach ( $post_types as $pt => $labels ) {

			if ( ! is_array( $labels ) ) {
				continue;
			}

			$label = $labels['name'];

			$name = sprintf( __( 'Add Meta Box For "%s"', 'pwa' ), $label );
			pwa_settings()->add_checkbox( $section, "pwa_pushpost_active_{$pt}", $name );
		}
	}

	public function post_types_footer( $atts ) {
		$atts['post_types'] = get_option( 'pwa_post_types' );

		return $atts;
	}
}