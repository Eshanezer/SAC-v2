<?php
/**
 * Live broadcast settings and playback support.
 *
 * @package SAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Recognize a YouTube video or an HTTPS media stream.
 */
function sac_broadcast_source( string $url ): array {
	$video_id = sac_youtube_video_id( $url );
	if ( $video_id ) {
		return array( 'type' => 'youtube', 'video_id' => $video_id );
	}

	$parts = wp_parse_url( trim( $url ) );
	if ( ! is_array( $parts ) || 'https' !== strtolower( $parts['scheme'] ?? '' ) || empty( $parts['host'] ) || isset( $parts['user'] ) || isset( $parts['pass'] ) ) {
		return array();
	}

	$extension = strtolower( pathinfo( $parts['path'] ?? '', PATHINFO_EXTENSION ) );
	$types     = array( 'm3u8' => 'application/vnd.apple.mpegurl', 'mp4' => 'video/mp4', 'webm' => 'video/webm' );
	$url       = esc_url_raw( $url, array( 'https' ) );
	if ( ! $url || ! isset( $types[ $extension ] ) ) {
		return array();
	}

	return array(
		'type' => 'm3u8' === $extension ? 'hls' : 'video',
		'url'  => $url,
		'mime' => $types[ $extension ],
	);
}

function sac_broadcast_start_time( string $value ): ?DateTimeImmutable {
	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/D', $value ) ) {
		return null;
	}

	$format = 'Y-m-d\TH:i';
	$time   = DateTimeImmutable::createFromFormat( '!' . $format, $value, wp_timezone() );
	return $time && $time->format( $format ) === $value ? $time : null;
}

function sac_broadcast_time_label( DateTimeImmutable $time ): string {
	return (string) wp_date( get_option( 'date_format' ) . ' · ' . get_option( 'time_format' ) . ' T', $time->getTimestamp(), $time->getTimezone() );
}

function sac_active_broadcast(): array {
	$settings = (array) get_option( 'sac_broadcast', array() );
	$source   = ! empty( $settings['enabled'] ) && is_string( $settings['url'] ?? null )
		? sac_broadcast_source( $settings['url'] )
		: array();

	if ( ! $source ) {
		return array();
	}

	$source['title']     = (string) ( $settings['title'] ?? '' );
	$source['starts_at'] = sac_broadcast_start_time( (string) ( $settings['starts_at'] ?? '' ) );
	return $source;
}

function sac_broadcast_page_url(): string {
	$page_id = sac_page_id( 'broadcast' );
	return $page_id && 'publish' === get_post_status( $page_id ) ? (string) get_permalink( $page_id ) : '';
}

add_action(
	'admin_menu',
	static function (): void {
		add_submenu_page(
			'sac-settings',
			__( 'Broadcast', 'sac' ),
			__( 'Broadcast', 'sac' ),
			'manage_options',
			'sac-broadcast',
			'sac_render_broadcast_settings'
		);
	},
	20
);

add_action(
	'admin_init',
	static function (): void {
		register_setting(
			'sac_broadcast',
			'sac_broadcast',
			array(
				'type'              => 'array',
				'sanitize_callback' => static function ( $value ): array {
					$enabled = in_array( $value['enabled'] ?? null, array( true, 1, '1' ), true );
					$url     = is_string( $value['url'] ?? null ) ? esc_url_raw( trim( $value['url'] ), array( 'http', 'https' ) ) : '';

					if ( ( $enabled || $url ) && ! sac_broadcast_source( $url ) ) {
						add_settings_error( 'sac_broadcast', 'invalid_source', __( 'Enter a YouTube video or livestream link, or an HTTPS .m3u8, .mp4, or .webm URL.', 'sac' ) );
						$previous = (array) get_option( 'sac_broadcast', array() );
						if ( ! $enabled ) {
							$previous['enabled'] = false;
						}
						return $previous;
					}

					$title     = is_string( $value['title'] ?? null ) ? sanitize_text_field( $value['title'] ) : '';
					$starts_at = is_string( $value['starts_at'] ?? null ) ? trim( $value['starts_at'] ) : '';
					if ( '' !== $starts_at && ! sac_broadcast_start_time( $starts_at ) ) {
						add_settings_error( 'sac_broadcast', 'invalid_start_time', __( 'Enter a valid broadcast start date and time.', 'sac' ) );
						$previous = (array) get_option( 'sac_broadcast', array() );
						$starts_at = $previous['starts_at'] ?? '';
					}

					return array( 'enabled' => $enabled, 'url' => $url, 'title' => $title, 'starts_at' => $starts_at );
				},
			)
		);
	}
);

function sac_render_broadcast_settings(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$settings = (array) get_option( 'sac_broadcast', array() );
	$page_url = sac_broadcast_page_url();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Broadcast', 'sac' ); ?></h1>
		<?php settings_errors(); ?>
		<form action="options.php" method="post">
			<?php settings_fields( 'sac_broadcast' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Live status', 'sac' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="sac_broadcast[enabled]" value="1" <?php checked( ! empty( $settings['enabled'] ) ); ?>>
							<?php esc_html_e( 'Enable broadcast and show the live banner', 'sac' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Turn this on when your service starts and off when it ends.', 'sac' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="sac_broadcast_url"><?php esc_html_e( 'Broadcast URL', 'sac' ); ?></label></th>
					<td>
						<input class="regular-text" id="sac_broadcast_url" name="sac_broadcast[url]" type="url" value="<?php echo esc_attr( $settings['url'] ?? '' ); ?>" aria-describedby="sac-broadcast-url-help">
						<p class="description" id="sac-broadcast-url-help"><?php esc_html_e( 'Paste the share link for the specific YouTube broadcast, or a direct HTTPS .m3u8, .mp4, or .webm URL.', 'sac' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="sac_broadcast_title"><?php esc_html_e( 'Broadcast title', 'sac' ); ?></label></th>
					<td>
						<input class="regular-text" id="sac_broadcast_title" name="sac_broadcast[title]" type="text" value="<?php echo esc_attr( $settings['title'] ?? '' ); ?>" aria-describedby="sac-broadcast-title-help">
						<p class="description" id="sac-broadcast-title-help"><?php esc_html_e( 'Optional. Shown on the live banner and Broadcast page.', 'sac' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="sac_broadcast_starts_at"><?php esc_html_e( 'Start date and time', 'sac' ); ?></label></th>
					<td>
						<input id="sac_broadcast_starts_at" name="sac_broadcast[starts_at]" type="datetime-local" value="<?php echo esc_attr( $settings['starts_at'] ?? '' ); ?>" aria-describedby="sac-broadcast-time-help">
						<p class="description" id="sac-broadcast-time-help">
							<?php
							/* translators: %s: the WordPress site time zone. */
							echo esc_html( sprintf( __( 'Optional. Uses the site time zone (%s). The live switch still controls when the broadcast appears.', 'sac' ), wp_timezone_string() ) );
							?>
						</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
		<?php if ( $page_url ) : ?>
			<p><a href="<?php echo esc_url( $page_url ); ?>"><?php esc_html_e( 'View Broadcast page', 'sac' ); ?></a></p>
		<?php endif; ?>
	</div>
	<?php
}

add_action(
	'wp_enqueue_scripts',
	static function (): void {
		if ( ! is_page_template( 'page-broadcast.php' ) || 'hls' !== ( sac_active_broadcast()['type'] ?? '' ) ) {
			return;
		}

		wp_enqueue_script( 'sac-hls', 'https://cdn.jsdelivr.net/npm/hls.js@1.7.4/dist/hls.min.js', array(), null, true );
		$player = '/assets/js/broadcast.js';
		wp_enqueue_script( 'sac-broadcast', get_theme_file_uri( $player ), array( 'sac-hls' ), (string) filemtime( get_theme_file_path( $player ) ), true );
	}
);
