<?php
/**
 * Bootstrap navigation integration and WPML language switcher.
 *
 * @package SAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Bootstrap classes to primary and footer menu items.
 *
 * @param string[] $classes Menu item classes.
 * @param WP_Post  $item    Menu item.
 * @param stdClass $args    Menu arguments.
 * @return string[]
 */
function sac_menu_item_classes( array $classes, WP_Post $item, stdClass $args ): array {
	if ( 'primary' === $args->theme_location ) {
		$classes[] = 'nav-item';

		if ( in_array( 'menu-item-has-children', $classes, true ) ) {
			$classes[] = 'dropdown';
		}
	}

	if ( 'footer' === $args->theme_location ) {
		$classes[] = 'mb-2';
	}

	return array_unique( $classes );
}
add_filter( 'nav_menu_css_class', 'sac_menu_item_classes', 10, 3 );

/**
 * Add Bootstrap classes and dropdown attributes to menu links.
 *
 * @param array    $atts  Link attributes.
 * @param WP_Post  $item  Menu item.
 * @param stdClass $args  Menu arguments.
 * @param int      $depth Menu depth.
 * @return array
 */
function sac_menu_link_attributes( array $atts, WP_Post $item, stdClass $args, int $depth ): array {
	if ( 'primary' === $args->theme_location ) {
		$link_classes = $depth > 0 ? array( 'dropdown-item' ) : array( 'nav-link' );

		if ( in_array( 'current-menu-item', $item->classes, true ) || in_array( 'current-menu-ancestor', $item->classes, true ) ) {
			$link_classes[] = 'active';
		}

		if ( in_array( 'current-menu-item', $item->classes, true ) ) {
			$atts['aria-current'] = 'page';
		}

		if ( 0 === $depth && in_array( 'menu-item-has-children', $item->classes, true ) ) {
			$link_classes[]        = 'dropdown-toggle';
			$atts['data-bs-toggle'] = 'dropdown';
			$atts['aria-expanded']  = 'false';
			$atts['role']           = 'button';
		}

		$atts['class'] = implode( ' ', $link_classes );
	}

	if ( 'footer' === $args->theme_location ) {
		$atts['class'] = 'link-light link-opacity-75-hover text-decoration-none';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'sac_menu_link_attributes', 10, 4 );

/**
 * Style submenus as Bootstrap dropdown menus.
 *
 * @param string[] $classes Submenu classes.
 * @param stdClass $args    Menu arguments.
 * @return string[]
 */
function sac_submenu_classes( array $classes, stdClass $args ): array {
	if ( 'primary' === $args->theme_location ) {
		$classes[] = 'dropdown-menu';
	}

	return array_unique( $classes );
}
add_filter( 'nav_menu_submenu_css_class', 'sac_submenu_classes', 10, 2 );

/**
 * In classic mode Donate is a dedicated navbar button, so omit its menu item.
 *
 * @param WP_Post[] $items Menu items.
 * @param stdClass  $args  Menu arguments.
 * @return WP_Post[]
 */
function sac_filter_classic_primary_menu( array $items, stdClass $args ): array {
	if ( 'primary' !== $args->theme_location || sac_premium_menu_enabled() ) {
		return $items;
	}

	$donate_url = untrailingslashit( sac_page_url( 'donate' ) );

	return array_values(
		array_filter(
			$items,
			static function ( WP_Post $item ) use ( $donate_url ): bool {
				return untrailingslashit( (string) $item->url ) !== $donate_url
					&& 'donate' !== sanitize_title( (string) $item->title );
			}
		)
	);
}
add_filter( 'wp_nav_menu_objects', 'sac_filter_classic_primary_menu', 10, 2 );

/**
 * Provide a usable navigation before a WordPress menu is assigned.
 */
function sac_primary_menu_fallback( mixed $args = null ): void {
	$items = array(
		array( 'label' => __( 'Home', 'sac' ), 'url' => home_url( '/' ) ),
		array( 'label' => __( 'New Here', 'sac' ), 'url' => sac_page_url( 'new-here' ) ),
		array( 'label' => __( 'About', 'sac' ), 'url' => sac_page_url( 'about' ) ),
		array( 'label' => __( 'Events', 'sac' ), 'url' => (string) get_post_type_archive_link( 'sac_event' ) ),
		array( 'label' => __( 'Messages', 'sac' ), 'url' => (string) get_post_type_archive_link( 'sac_sermon' ) ),
		array( 'label' => __( 'Gallery', 'sac' ), 'url' => (string) get_post_type_archive_link( 'sac_album' ) ),
		array( 'label' => __( 'Videos', 'sac' ), 'url' => (string) get_post_type_archive_link( 'sac_video' ) ),
		array( 'label' => __( 'Contact', 'sac' ), 'url' => sac_page_url( 'contact' ) ),
	);
	?>
	<ul class="navbar-nav ms-auto align-items-xl-center gap-xl-1">
		<?php foreach ( $items as $item ) : ?>
			<li class="nav-item"><a class="nav-link" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
		<?php endforeach; ?>
	</ul>
	<?php
}

/**
 * Render WPML's active languages as compact Bootstrap links.
 */
function sac_language_switcher(): void {
	$languages = apply_filters(
		'wpml_active_languages',
		null,
		array(
			'skip_missing' => 0,
			'orderby'      => 'code',
		)
	);

	if ( ! is_array( $languages ) || empty( $languages ) ) {
		return;
	}
	?>
	<nav class="sac-language-switcher d-flex align-items-center gap-2" aria-label="<?php esc_attr_e( 'Languages', 'sac' ); ?>">
		<?php foreach ( $languages as $language ) : ?>
			<?php
			$language_code = isset( $language['language_code'] ) ? strtolower( (string) $language['language_code'] ) : '';
			$native_name   = isset( $language['native_name'] ) ? (string) $language['native_name'] : strtoupper( $language_code );
			$flag_url      = isset( $language['country_flag_url'] ) ? (string) $language['country_flag_url'] : '';
			$is_current    = ! empty( $language['active'] );
			$flag          = $flag_url
				? sprintf(
					'<img src="%1$s" width="24" height="16" alt="%2$s">',
					esc_url( $flag_url ),
					esc_attr( $native_name )
				)
				: esc_html( strtoupper( $language_code ) );
			?>
			<?php if ( $is_current ) : ?>
				<span class="sac-language-flag is-current" lang="<?php echo esc_attr( $language_code ); ?>" title="<?php echo esc_attr( $native_name ); ?>" aria-current="page"><?php echo $flag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			<?php else : ?>
				<a class="sac-language-flag" href="<?php echo esc_url( (string) $language['url'] ); ?>" lang="<?php echo esc_attr( $language_code ); ?>" hreflang="<?php echo esc_attr( $language_code ); ?>" title="<?php echo esc_attr( $native_name ); ?>" aria-label="<?php echo esc_attr( $native_name ); ?>">
					<?php echo $flag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			<?php endif; ?>
		<?php endforeach; ?>
	</nav>
	<?php
}
