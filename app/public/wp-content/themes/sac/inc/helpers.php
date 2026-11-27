<?php
/**
 * Shared template helpers.
 *
 * @package SAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the configured custom logo or SAC's bundled logo mark.
 *
 * The bundled file includes transparent canvas around the artwork, so its
 * wrapper receives a modifier class that crops it consistently with CSS.
 *
 * @param string $context Logo placement: navbar or footer.
 */
function sac_brand_logo( string $context = 'navbar' ): string {
	$context       = 'footer' === $context ? 'footer' : 'navbar';
	$wrapper_class = 'sac-brand-logo sac-brand-logo--' . $context;
	$custom_logo_id = (int) get_theme_mod( 'custom_logo' );
	$loading        = 'navbar' === $context ? 'eager' : 'lazy';

	if ( $custom_logo_id > 0 ) {
		$image = wp_get_attachment_image(
			$custom_logo_id,
			'full',
			false,
			array(
				'alt'      => '',
				'class'    => 'custom-logo',
				'decoding' => 'async',
				'loading'  => $loading,
			)
		);

		if ( $image ) {
			return sprintf(
				'<span class="%1$s sac-brand-logo--custom" aria-hidden="true">%2$s</span>',
				esc_attr( $wrapper_class ),
				$image
			);
		}
	}

	$logo_path = get_theme_file_path( '/assets/img/logo-gold.png' );

	if ( file_exists( $logo_path ) ) {
		$logo_url = add_query_arg( 'ver', (string) filemtime( $logo_path ), get_theme_file_uri( '/assets/img/logo-gold.png' ) );
		$style    = '--sac-logo-image:url("' . esc_url_raw( $logo_url ) . '")';

		return sprintf(
			'<span class="%1$s sac-brand-logo--theme" style="%2$s" aria-hidden="true"></span>',
			esc_attr( $wrapper_class ),
			esc_attr( $style )
		);
	}

	return '<span class="sac-brand-mark" aria-hidden="true">SA</span>';
}

/**
 * Return the translated front-page ID when WPML is available.
 */
function sac_front_page_id(): int {
	$page_id = (int) get_option( 'page_on_front' );

	if ( $page_id > 0 ) {
		$translated_id = apply_filters( 'wpml_object_id', $page_id, 'page', true );
		$page_id       = $translated_id ? (int) $translated_id : $page_id;
	}

	return $page_id;
}

/**
 * Read an ACF value and provide a safe fallback when ACF or a value is absent.
 *
 * @param string     $name     Field name.
 * @param mixed      $fallback Fallback value.
 * @param int|string $post_id  Optional ACF post ID.
 * @return mixed
 */
function sac_field( string $name, mixed $fallback = '', int|string $post_id = 0 ): mixed {
	if ( function_exists( 'get_field' ) ) {
		$acf_post_id = $post_id ?: get_the_ID();
		$value       = get_field( $name, $acf_post_id );

		if ( false !== $value && null !== $value && '' !== $value ) {
			return $value;
		}
	}

	return $fallback;
}

/**
 * Retrieve contact and social media information.
 * Prioritizes:
 * 1. Backend (BE) Contact Page ACF field (post meta).
 * 2. Backend (BE) SAC Settings option (wp_options).
 * 3. Environment variable (.env).
 * 4. Default fallback.
 *
 * @param string     $key_or_env Field name or env key (e.g. 'sac_contact_phone', 'CONTACT_EMAIL').
 * @param string     $acf_name   Optional explicit ACF field name.
 * @param mixed      $default    Default fallback value.
 * @param int|string $post_id    Optional post ID.
 * @return mixed
 */
function sac_contact_info( string $key_or_env, string $acf_name = '', mixed $default = '', int|string $post_id = 0 ): mixed {
	$clean        = strtolower( (string) preg_replace( '/^(sac_)?(contact_|social_)?/i', '', $acf_name ?: $key_or_env ) );
	$is_social    = in_array( $clean, array( 'facebook', 'instagram', 'youtube', 'tiktok' ), true );
	$resolved_acf = $acf_name ?: ( 'sac_' . ( $is_social ? 'social_' : 'contact_' ) . $clean );
	$resolved_env = strtoupper( ( $is_social ? 'SOCIAL_' : 'CONTACT_' ) . $clean );

	// 1. Check Backend (BE) ACF field on the Contact Page
	if ( function_exists( 'get_field' ) ) {
		$target_id = $post_id ?: ( is_page_template( 'page-contact.php' ) ? get_the_ID() : sac_page_id( 'contact' ) );
		if ( $target_id > 0 ) {
			$acf_val = get_field( $resolved_acf, $target_id );
			if ( false !== $acf_val && null !== $acf_val && '' !== $acf_val ) {
				return $acf_val;
			}
		}
	}

	// 2. Check Backend (BE) Theme Settings (SAC Settings in WP-Admin)
	$option_val = get_option( $resolved_acf );
	if ( false !== $option_val && null !== $option_val && '' !== $option_val ) {
		return $option_val;
	}

	// 3. Fallback to .env configuration if unset in Backend
	if ( function_exists( 'env' ) ) {
		$env_val = env( $resolved_env );
		if ( false !== $env_val && null !== $env_val && '' !== $env_val ) {
			return $env_val;
		}
	}

	// 4. Default fallback
	return $default;
}

/**
 * Normalize an ACF link value.
 *
 * @param string $name     Field name.
 * @param array  $fallback Fallback link.
 * @param int    $post_id  Optional post ID.
 * @return array{url:string,title:string,target:string}
 */
function sac_link( string $name, array $fallback, int $post_id = 0 ): array {
	$value = sac_field( $name, array(), $post_id );

	if ( is_array( $value ) && ! empty( $value['url'] ) ) {
		return array(
			'url'    => (string) $value['url'],
			'title'  => ! empty( $value['title'] ) ? (string) $value['title'] : (string) ( $fallback['title'] ?? '' ),
			'target' => ! empty( $value['target'] ) ? (string) $value['target'] : '_self',
		);
	}

	return array(
		'url'    => (string) ( $fallback['url'] ?? '#' ),
		'title'  => (string) ( $fallback['title'] ?? '' ),
		'target' => (string) ( $fallback['target'] ?? '_self' ),
	);
}

/**
 * Return a page ID translated into the current language.
 */
function sac_page_id( string $slug ): int {
	$page = get_page_by_path( $slug );

	if ( ! $page instanceof WP_Post && 'donate' === $slug ) {
		$page = get_page_by_path( 'give' );
	}

	if ( ! $page instanceof WP_Post ) {
		return 0;
	}

	$translated_id = apply_filters( 'wpml_object_id', (int) $page->ID, 'page', true );
	return $translated_id ? (int) $translated_id : (int) $page->ID;
}

/**
 * Return a translated page URL by slug, with a home fallback.
 */
function sac_page_url( string $slug ): string {
	$page_id = sac_page_id( $slug );

	if ( $page_id ) {
		$url = get_permalink( $page_id );

		if ( $url ) {
			return $url;
		}
	}

	return home_url( '/' );
}

/**
 * Return an accessible, decorative social network icon.
 */
function sac_social_icon( string $network ): string {
	$icons = array(
		'facebook'  => '<path d="M14 8.8h3V5.2c-.5-.1-2.1-.2-3.6-.2-3.5 0-5.9 2.1-5.9 6.1v3.4H4v4h3.5V28h4.3v-9.5h3.6l.6-4h-4.2v-3c0-1.2.3-2.7 2.2-2.7Z"/>',
		'instagram' => '<rect x="5" y="5" width="22" height="22" rx="6"/><circle cx="16" cy="16" r="5"/><circle cx="23.5" cy="8.8" r="1.2" class="sac-icon-fill"/>',
		'youtube'   => '<path d="M28.5 9.2a3.3 3.3 0 0 0-2.3-2.3C24.2 6.3 16 6.3 16 6.3s-8.2 0-10.2.6a3.3 3.3 0 0 0-2.3 2.3C3 11.2 3 16 3 16s0 4.8.5 6.8a3.3 3.3 0 0 0 2.3 2.3c2 .6 10.2.6 10.2.6s8.2 0 10.2-.6a3.3 3.3 0 0 0 2.3-2.3c.5-2 .5-6.8.5-6.8s0-4.8-.5-6.8Z"/><path d="m13 20.2 7-4.2-7-4.2v8.4Z" class="sac-icon-fill"/>',
		'tiktok'    => '<path d="M19 4c.5 3.1 2.3 5 5.5 5.2v4.1a11 11 0 0 1-5.5-1.7v8.1A7.7 7.7 0 1 1 12.3 12v4.2a3.6 3.6 0 1 0 2.5 3.5V4H19Z"/>',
	);
	$key = strtolower( $network );

	if ( ! isset( $icons[ $key ] ) ) {
		return '';
	}

	return '<svg class="sac-social-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false">' . $icons[ $key ] . '</svg>';
}

/**
 * Resolve an ACF image field to a URL.
 */
function sac_image_url( string $name, string $size = 'full', int $post_id = 0 ): string {
	$image = sac_field( $name, 0, $post_id );

	if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
		$image = (int) $image['ID'];
	}

	if ( is_numeric( $image ) ) {
		$url = wp_get_attachment_image_url( (int) $image, $size );
		return $url ? $url : '';
	}

	return is_string( $image ) ? $image : '';
}

/**
 * Return saved album photo IDs in editor order.
 */
function sac_album_photo_ids( int $post_id ): array {
	$saved_ids = (array) get_post_meta( $post_id, 'sac_album_photos', true );
	return array_values( array_unique( array_filter( array_map( 'absint', $saved_ids ) ) ) );
}

/**
 * Extract an ID from a YouTube watch, share, Short, livestream, or embed URL.
 */
function sac_youtube_video_id( string $url ): string {
	$parts = wp_parse_url( trim( $url ) );
	if ( ! is_array( $parts ) || ! in_array( strtolower( $parts['scheme'] ?? '' ), array( 'https', 'http' ), true ) || isset( $parts['user'] ) || isset( $parts['pass'] ) || isset( $parts['port'] ) ) {
		return '';
	}

	$host = strtolower( $parts['host'] ?? '' );
	$path = rtrim( $parts['path'] ?? '', '/' );
	$id   = '';

	if ( 'youtu.be' === $host ) {
		$id = substr( $path, 1 );
	} elseif ( in_array( $host, array( 'youtube.com', 'www.youtube.com', 'm.youtube.com', 'music.youtube.com', 'youtube-nocookie.com', 'www.youtube-nocookie.com' ), true ) ) {
		if ( '/watch' === $path ) {
			parse_str( $parts['query'] ?? '', $query );
			$id = $query['v'] ?? '';
		} elseif ( preg_match( '~^/(?:shorts|live|embed)/([^/]+)$~D', $path, $matches ) ) {
			$id = $matches[1];
		}
	}

	return is_string( $id ) && preg_match( '/^[A-Za-z0-9_-]{11}$/D', $id ) ? $id : '';
}

/**
 * Read a video ID from its saved URL, even when the editor plugin is inactive.
 */
function sac_saved_video_id( int $post_id ): string {
	$url = get_post_meta( $post_id, 'sac_video_youtube_url', true );
	return is_string( $url ) ? sac_youtube_video_id( $url ) : '';
}

/**
 * Format an ACF date-time value in the site's timezone.
 */
function sac_format_datetime( string $value, string $format = 'j M Y · H:i' ): string {
	if ( '' === $value ) {
		return '';
	}

	$date = DateTimeImmutable::createFromFormat( 'Y-m-d H:i:s', $value, wp_timezone() );

	if ( ! $date ) {
		$timestamp = strtotime( $value );
		return $timestamp ? wp_date( $format, $timestamp, wp_timezone() ) : '';
	}

	return wp_date( $format, $date->getTimestamp(), wp_timezone() );
}
