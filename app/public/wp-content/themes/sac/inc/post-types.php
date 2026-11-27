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
 * Register events, messages, ministries, photo albums, and videos.
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

	register_post_type(
		'sac_ministry',
		array(
			'labels'        => array(
				'name'          => __( 'Ministries', 'sac' ),
				'singular_name' => __( 'Ministry', 'sac' ),
				'add_new_item'  => __( 'Add New Ministry', 'sac' ),
				'edit_item'     => __( 'Edit Ministry', 'sac' ),
				'view_item'     => __( 'View Ministry', 'sac' ),
				'search_items'  => __( 'Search Ministries', 'sac' ),
			),
			'public'        => true,
			'has_archive'   => false,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-groups',
			'menu_position' => 22,
			'rewrite'       => array( 'slug' => 'ministries', 'with_front' => false ),
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		)
	);

	register_post_type(
		'sac_album',
		array(
			'labels'        => array(
				'name'          => __( 'Albums', 'sac' ),
				'singular_name' => __( 'Album', 'sac' ),
				'add_new_item'  => __( 'Add New Album', 'sac' ),
				'edit_item'     => __( 'Edit Album', 'sac' ),
				'view_item'     => __( 'View Album', 'sac' ),
				'search_items'  => __( 'Search Albums', 'sac' ),
			),
			'public'        => true,
			'has_archive'   => 'gallery',
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-format-gallery',
			'menu_position' => 23,
			'rewrite'       => array( 'slug' => 'gallery', 'with_front' => false ),
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		)
	);

	register_post_type(
		'sac_video',
		array(
			'labels'        => array(
				'name'          => __( 'Videos', 'sac' ),
				'singular_name' => __( 'Video', 'sac' ),
				'add_new_item'  => __( 'Add New Video', 'sac' ),
				'edit_item'     => __( 'Edit Video', 'sac' ),
				'view_item'     => __( 'View Video', 'sac' ),
				'search_items'  => __( 'Search Videos', 'sac' ),
			),
			'public'        => true,
			'has_archive'   => 'videos',
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-video-alt2',
			'menu_position' => 24,
			'rewrite'       => array( 'slug' => 'videos', 'with_front' => false ),
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		)
	);
}
add_action( 'init', 'sac_register_post_types' );

add_filter(
	'query_vars',
	static function ( array $vars ): array {
		$vars[] = 'album_page';
		return $vars;
	}
);

add_action(
	'wp_loaded',
	static function (): void {
		if ( get_option( 'permalink_structure' ) && '2' !== get_option( 'sac_content_routes_version' ) ) {
			flush_rewrite_rules( false );
			update_option( 'sac_content_routes_version', '2' );
		}
	}
);
