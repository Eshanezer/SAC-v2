<?php
/** Theme setup for Pastor Samson. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'pastor-samson', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 100, 'width' => 260, 'flex-height' => true, 'flex-width' => true ) );
	register_nav_menus( array( 'primary' => __( 'Primary Navigation', 'pastor-samson' ) ) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'ps-font', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap', array(), null );
	wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css', array(), '5.3.8' );
	wp_enqueue_style( 'pastor-samson', get_stylesheet_uri(), array( 'bootstrap' ), '1.0.0' );
	wp_enqueue_script( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js', array(), '5.3.8', true );
} );

function ps_value( $name, $fallback = '' ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name );
		if ( $value ) { return $value; }
	}
	return $fallback;
}

function ps_menu_fallback() {
	$items = array( 'about' => __( 'About', 'pastor-samson' ), 'ministry' => __( 'Ministry', 'pastor-samson' ), 'messages' => __( 'Messages', 'pastor-samson' ), 'contact' => __( 'Contact', 'pastor-samson' ) );
	echo '<ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">';
	foreach ( $items as $anchor => $label ) { printf( '<li class="nav-item"><a class="nav-link" href="#%s">%s</a></li>', esc_attr( $anchor ), esc_html( $label ) ); }
	echo '</ul>';
}
