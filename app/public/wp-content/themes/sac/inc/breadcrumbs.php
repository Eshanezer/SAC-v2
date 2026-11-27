<?php
/**
 * Breadcrumbs for the current WordPress route.
 *
 * @package SAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the label and URL of a content type's public listing.
 */
function sac_breadcrumb_listing( string $post_type ): array {
	if ( 'sac_ministry' === $post_type ) {
		$page_id = sac_page_id( 'ministries' );
		return $page_id && 'publish' === get_post_status( $page_id )
			? array( 'label' => get_the_title( $page_id ), 'url' => get_permalink( $page_id ) )
			: array();
	}

	if ( 'post' === $post_type ) {
		$page_id = (int) get_option( 'page_for_posts' );
		$page_id = $page_id ? (int) apply_filters( 'wpml_object_id', $page_id, 'page', true ) : 0;
		return $page_id && 'publish' === get_post_status( $page_id )
			? array( 'label' => get_the_title( $page_id ), 'url' => get_permalink( $page_id ) )
			: array();
	}

	$type = get_post_type_object( $post_type );
	$url  = get_post_type_archive_link( $post_type );
	if ( ! $type || ! $url ) {
		return array();
	}

	return array(
		'label' => 'sac_album' === $post_type ? __( 'Gallery', 'sac' ) : $type->labels->name,
		'url'   => $url,
	);
}

/**
 * Return ancestor links followed by the current page.
 */
function sac_breadcrumb_items(): array {
	if ( is_front_page() ) {
		return array();
	}

	$items = array( array( 'label' => __( 'Home', 'sac' ), 'url' => home_url( '/' ) ) );
	$object = get_queried_object();
	$current = '';
	$current_url = '';

	if ( is_singular() && $object instanceof WP_Post ) {
		$ancestors = array_reverse( get_post_ancestors( $object ) );
		$first_ancestor = $ancestors ? get_post( $ancestors[0] ) : $object;
		if ( $first_ancestor ) {
			$listing = sac_breadcrumb_listing( $first_ancestor->post_type );
			if ( $listing ) {
				$items[] = $listing;
			}
		}

		foreach ( $ancestors as $id ) {
			if ( 'publish' === get_post_status( $id ) && (int) get_option( 'page_on_front' ) !== $id ) {
				$items[] = array( 'label' => get_the_title( $id ), 'url' => get_permalink( $id ) );
			}
		}
		$current = get_the_title( $object );
		if ( 'sac_event' === $object->post_type ) {
			$current = (string) sac_field( 'sac_event_heading', $current, $object->ID );
		} elseif ( is_page_template( 'page-broadcast.php' ) ) {
			$current = ( sac_active_broadcast()['title'] ?? '' ) ?: $current;
		}
	} elseif ( is_post_type_archive() && $object instanceof WP_Post_Type ) {
		$listing = sac_breadcrumb_listing( $object->name );
		$current = $listing['label'] ?? $object->labels->name;
		$current_url = $listing['url'] ?? '';
	} elseif ( ( is_category() || is_tag() || is_tax() ) && $object instanceof WP_Term ) {
		foreach ( array_reverse( get_ancestors( $object->term_id, $object->taxonomy, 'taxonomy' ) ) as $id ) {
			$term = get_term( $id, $object->taxonomy );
			if ( $term instanceof WP_Term ) {
				$url = get_term_link( $term );
				if ( ! is_wp_error( $url ) ) {
					$items[] = array( 'label' => $term->name, 'url' => $url );
				}
			}
		}
		$current = $object->name;
	} elseif ( is_search() ) {
		$current = __( 'Search results', 'sac' );
	} elseif ( is_404() ) {
		$current = __( 'Page not found', 'sac' );
	} elseif ( is_home() ) {
		$current = $object instanceof WP_Post ? get_the_title( $object ) : __( 'Posts', 'sac' );
	} elseif ( is_archive() ) {
		$current = wp_strip_all_tags( get_the_archive_title() );
	}

	$current = $current ?: __( 'Untitled', 'sac' );
	$page_number = is_paged() ? (int) get_query_var( 'paged' ) : 1;
	if ( $page_number > 1 ) {
		$items[] = array( 'label' => $current, 'url' => $current_url ?: get_pagenum_link( 1 ) );
		/* translators: %s: page number. */
		$current = sprintf( __( 'Page %s', 'sac' ), number_format_i18n( $page_number ) );
	}

	$items[] = array( 'label' => $current, 'url' => '' );
	return $items;
}
