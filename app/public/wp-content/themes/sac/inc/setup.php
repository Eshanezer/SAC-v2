<?php
/**
 * Theme setup and assets.
 *
 * @package SAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Configure theme defaults and supported WordPress features.
 */
function sac_setup(): void {
	load_theme_textdomain( 'sac', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 140,
			'width'       => 420,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'search-form',
			'style',
			'script',
			'navigation-widgets',
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary menu', 'sac' ),
			'footer'  => __( 'Footer menu', 'sac' ),
		)
	);
}
add_action( 'after_setup_theme', 'sac_setup' );

/**
 * Localize the starter tagline while allowing editors to replace it later.
 *
 * @param mixed $description Saved site description.
 * @return mixed
 */
function sac_localize_starter_description( mixed $description ): mixed {
	if ( 'A church for Riga and the nations.' !== $description ) {
		return $description;
	}

	return __( 'A church for Riga and the nations.', 'sac' );
}
add_filter( 'option_blogdescription', 'sac_localize_starter_description' );

/**
 * Migrate the original English Give page to its new Donate identity once.
 */
function sac_migrate_donate_page(): void {
	if ( get_option( 'sac_donate_page_migrated' ) ) {
		return;
	}

	$page = get_page_by_path( 'give' );

	if ( ! $page instanceof WP_Post ) {
		return;
	}

	wp_update_post(
		array(
			'ID'            => $page->ID,
			'post_title'    => 'Donate',
			'post_name'     => 'donate',
			'page_template' => 'page-donate.php',
		)
	);

	$locations = get_nav_menu_locations();

	if ( isset( $locations['primary'] ) ) {
		$items = wp_get_nav_menu_items( $locations['primary'] );

		foreach ( is_array( $items ) ? $items : array() as $item ) {
			if ( (int) $item->object_id === (int) $page->ID ) {
				wp_update_post( array( 'ID' => $item->ID, 'post_title' => 'Donate' ) );
			}
		}
	}

	update_option( 'sac_donate_page_migrated', 1, false );
}
add_action( 'init', 'sac_migrate_donate_page', 30 );

/**
 * Preserve links to the former English Give page URL.
 */
function sac_redirect_legacy_give_url(): void {
	$path = trim( (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ), PHP_URL_PATH ), '/' );

	if ( 'give' === $path ) {
		wp_safe_redirect( sac_page_url( 'donate' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'sac_redirect_legacy_give_url' );

/**
 * Load Bootstrap and the SAC design layer.
 */
function sac_enqueue_assets(): void {
	$stylesheet_path = get_stylesheet_directory() . '/style.css';
	$stylesheet_ver  = file_exists( $stylesheet_path ) ? (string) filemtime( $stylesheet_path ) : SAC_THEME_VERSION;
	$theme_script_path = get_theme_file_path( '/assets/js/theme.js' );

	wp_enqueue_style(
		'sac-bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@' . SAC_BOOTSTRAP_VERSION . '/dist/css/bootstrap.min.css',
		array(),
		SAC_BOOTSTRAP_VERSION
	);

	wp_enqueue_style(
		'sac-style',
		get_stylesheet_uri(),
		array( 'sac-bootstrap' ),
		$stylesheet_ver
	);

	wp_enqueue_script(
		'sac-bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@' . SAC_BOOTSTRAP_VERSION . '/dist/js/bootstrap.bundle.min.js',
		array(),
		SAC_BOOTSTRAP_VERSION,
		true
	);

	wp_enqueue_script(
		'sac-theme',
		get_theme_file_uri( '/assets/js/theme.js' ),
		array(),
		file_exists( $theme_script_path ) ? (string) filemtime( $theme_script_path ) : SAC_THEME_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'sac_enqueue_assets' );

/**
 * Use the bundled gold logo as the favicon until a WordPress Site Icon is set.
 */
function sac_fallback_site_icon(): void {
	if ( has_site_icon() ) {
		return;
	}

	$icon_path = get_theme_file_path( '/assets/img/logo-gold.png' );

	if ( ! file_exists( $icon_path ) ) {
		return;
	}

	$icon_url = add_query_arg(
		'ver',
		(string) filemtime( $icon_path ),
		get_theme_file_uri( '/assets/img/logo-gold.png' )
	);
	?>
	<link rel="icon" href="<?php echo esc_url( $icon_url ); ?>" type="image/png">
	<link rel="apple-touch-icon" href="<?php echo esc_url( $icon_url ); ?>">
	<?php
}
add_action( 'wp_head', 'sac_fallback_site_icon', 2 );

/**
 * Add Subresource Integrity attributes to the pinned Bootstrap CDN files.
 *
 * @param string $html   Generated stylesheet tag.
 * @param string $handle Enqueued stylesheet handle.
 * @return string
 */
function sac_bootstrap_style_integrity( string $html, string $handle ): string {
	if ( 'sac-bootstrap' !== $handle || str_contains( $html, 'integrity=' ) ) {
		return $html;
	}

	return str_replace(
		' href=',
		' integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" href=',
		$html
	);
}
add_filter( 'style_loader_tag', 'sac_bootstrap_style_integrity', 10, 2 );

/**
 * Add Subresource Integrity attributes to the pinned Bootstrap script.
 *
 * @param string $tag    Generated script tag.
 * @param string $handle Enqueued script handle.
 * @return string
 */
function sac_bootstrap_script_integrity( string $tag, string $handle ): string {
	if ( 'sac-bootstrap' !== $handle || str_contains( $tag, 'integrity=' ) ) {
		return $tag;
	}

	return str_replace(
		' src=',
		' integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous" src=',
		$tag
	);
}
add_filter( 'script_loader_tag', 'sac_bootstrap_script_integrity', 10, 2 );

/**
 * Apply SAC branding to the standard WordPress login screen.
 */
function sac_login_assets(): void {
	$stylesheet_path = get_theme_file_path( '/assets/css/login.css' );
	$custom_logo_id  = (int) get_theme_mod( 'custom_logo' );
	$login_logo_url  = $custom_logo_id > 0 ? wp_get_attachment_image_url( $custom_logo_id, 'full' ) : false;
	$login_logo_size = $login_logo_url ? 'contain' : '14rem auto';

	if ( ! $login_logo_url ) {
		$bundled_logo_path = get_theme_file_path( '/assets/img/logo-gold.png' );

		if ( file_exists( $bundled_logo_path ) ) {
			$login_logo_url = add_query_arg(
				'ver',
				(string) filemtime( $bundled_logo_path ),
				get_theme_file_uri( '/assets/img/logo-gold.png' )
			);
		}
	}

	wp_enqueue_style(
		'sac-login',
		get_theme_file_uri( '/assets/css/login.css' ),
		array(),
		file_exists( $stylesheet_path ) ? (string) filemtime( $stylesheet_path ) : SAC_THEME_VERSION
	);

	wp_add_inline_style(
		'sac-login',
		':root{--sac-login-logo:' . ( $login_logo_url ? 'url(' . wp_json_encode( $login_logo_url ) . ')' : 'none' ) . ';--sac-login-logo-size:' . esc_html( $login_logo_size ) . ';}'
	);
}
add_action( 'login_enqueue_scripts', 'sac_login_assets' );

/**
 * Point the login logo to the website.
 */
function sac_login_header_url(): string {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'sac_login_header_url' );

/**
 * Use the site name as the login logo label.
 */
function sac_login_header_text(): string {
	return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'sac_login_header_text' );

/**
 * Keep archive excerpts concise.
 */
function sac_excerpt_length(): int {
	return 24;
}
add_filter( 'excerpt_length', 'sac_excerpt_length' );
