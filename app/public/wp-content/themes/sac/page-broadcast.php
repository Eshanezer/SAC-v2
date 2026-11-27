<?php
/**
 * Template Name: Broadcast
 * Template Post Type: page
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" tabindex="-1" class="site-main sac-video-library">
	<?php while ( have_posts() ) : ?>
		<?php
		the_post();
		$source = sac_active_broadcast();
		$title  = $source['title'] ?? '';
		$title  = $title ?: get_the_title();
		?>
		<article <?php post_class( 'container py-5' ); ?>>
			<header class="mb-4">
				<?php if ( $source ) : ?>
					<p class="sac-broadcast-live-label mb-3"><span class="sac-broadcast-dot" aria-hidden="true"></span><?php esc_html_e( 'Service is live', 'sac' ); ?></p>
				<?php endif; ?>
				<h1 class="display-4 fw-semibold mb-0"><?php echo esc_html( $title ); ?></h1>
				<?php if ( ! empty( $source['starts_at'] ) ) : ?>
					<p class="mt-3 mb-0">
						<time datetime="<?php echo esc_attr( $source['starts_at']->format( DATE_ATOM ) ); ?>">
							<?php echo esc_html( sac_broadcast_time_label( $source['starts_at'] ) ); ?>
						</time>
					</p>
				<?php endif; ?>
			</header>
			<?php if ( 'youtube' === ( $source['type'] ?? '' ) ) : ?>
				<?php get_template_part( 'template-parts/youtube-player', null, array( 'video_id' => $source['video_id'], 'title' => $title ) ); ?>
			<?php elseif ( $source ) : ?>
				<?php $is_hls = 'hls' === $source['type']; ?>
				<div class="sac-video-player">
					<video controls playsinline preload="none" aria-label="<?php esc_attr_e( 'Live broadcast player', 'sac' ); ?>" <?php if ( $is_hls ) : ?>data-sac-hls="<?php echo esc_url( $source['url'] ); ?>"<?php endif; ?>>
						<?php if ( ! $is_hls ) : ?><source src="<?php echo esc_url( $source['url'] ); ?>" type="<?php echo esc_attr( $source['mime'] ); ?>"><?php endif; ?>
					</video>
				</div>
				<?php if ( $is_hls ) : ?>
					<p class="mt-3 mb-0" role="status" data-sac-hls-status data-error="<?php esc_attr_e( 'The stream could not be played here. Try opening the stream directly.', 'sac' ); ?>"></p>
				<?php endif; ?>
				<p class="mt-3"><a href="<?php echo esc_url( $source['url'] ); ?>"><?php esc_html_e( 'Open stream directly', 'sac' ); ?></a></p>
			<?php else : ?>
				<div class="sac-empty-state rounded-4 p-4">
					<p><?php esc_html_e( 'No broadcast is live right now.', 'sac' ); ?></p>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'sac_video' ) ); ?>"><?php esc_html_e( 'Watch past recordings', 'sac' ); ?></a>
				</div>
			<?php endif; ?>
			<?php if ( trim( get_the_content() ) ) : ?>
				<div class="sac-entry-content sac-video-description mt-4"><?php the_content(); ?></div>
			<?php endif; ?>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
