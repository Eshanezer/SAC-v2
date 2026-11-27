<?php
/**
 * Live notice immediately below the main navigation.
 *
 * @package SAC
 */

$source = sac_active_broadcast();
if ( ! $source || is_page_template( 'page-broadcast.php' ) ) {
	return;
}

$url = sac_broadcast_page_url();
if ( ! $url ) {
	return;
}
?>
<aside class="sac-broadcast-banner" aria-label="<?php esc_attr_e( 'Live Broadcast', 'sac' ); ?>">
	<a class="container sac-broadcast-banner-link" href="<?php echo esc_url( $url ); ?>">
		<span class="sac-broadcast-banner-info">
			<span class="sac-broadcast-banner-status">
				<span class="sac-broadcast-dot" aria-hidden="true"></span>
				<?php esc_html_e( 'Service is live', 'sac' ); ?>
			</span>
			<?php if ( $source['title'] ) : ?>
				<span class="sac-broadcast-banner-title"><?php echo esc_html( $source['title'] ); ?></span>
			<?php endif; ?>
			<?php if ( $source['starts_at'] ) : ?>
				<time class="sac-broadcast-banner-time" datetime="<?php echo esc_attr( $source['starts_at']->format( DATE_ATOM ) ); ?>">
					<?php echo esc_html( sac_broadcast_time_label( $source['starts_at'] ) ); ?>
				</time>
			<?php endif; ?>
		</span>
		<span class="sac-broadcast-banner-cta">
			<?php esc_html_e( 'Watch live', 'sac' ); ?>
			<span class="sac-broadcast-banner-arrow" aria-hidden="true">&rarr;</span>
		</span>
	</a>
</aside>
