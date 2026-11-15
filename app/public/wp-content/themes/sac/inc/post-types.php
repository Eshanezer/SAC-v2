<?php
/**
 * Church content types.
 *
 * @package SAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register event and message content types.
 */
function sac_register_post_types(): void {
	register_post_type(
		'sac_event',
		array(
			'labels' => array(
				'name'          => __( 'Events', 'sac' ),
				'singular_name' => __( 'Event', 'sac' ),
				'add_new_item'  => __( 'Add New Event', 'sac' ),
				'edit_item'     => __( 'Edit Event', 'sac' ),
				'view_item'     => __( 'View Event', 'sac' ),
				'search_items'  => __( 'Search Events', 'sac' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-calendar-alt',
			'menu_position'=> 20,
			'rewrite'      => array( 'slug' => 'events' ),
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		)
	);

	register_post_type(
		'sac_sermon',
		array(
			'labels' => array(
				'name'          => __( 'Messages', 'sac' ),
				'singular_name' => __( 'Message', 'sac' ),
				'add_new_item'  => __( 'Add New Message', 'sac' ),
				'edit_item'     => __( 'Edit Message', 'sac' ),
				'view_item'     => __( 'View Message', 'sac' ),
				'search_items'  => __( 'Search Messages', 'sac' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-video-alt3',
			'menu_position'=> 21,
			'rewrite'      => array( 'slug' => 'messages' ),
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		)
	);
}
add_action( 'init', 'sac_register_post_types' );
