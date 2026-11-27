<?php
/**
 * Single message.
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" tabindex="-1" class="site-main">
	<?php while ( have_posts() ) : ?>
		<?php
		the_post();
		$speaker   = (string) sac_field( 'sac_sermon_speaker', '' );
		$date      = (string) sac_field( 'sac_sermon_date', '' );
		$scripture = (string) sac_field( 'sac_sermon_scripture', '' );
		$video_url = (string) sac_field( 'sac_sermon_video_url', '' );
		?>
		<header class="sac-page-hero text-white">
			<div class="container py-5">
				<div class="row justify-content-center py-5">
					<div class="col-lg-9 text-center">
						<p class="sac-eyebrow text-primary mb-3"><?php echo esc_html( $speaker ?: __( 'Message', 'sac' ) ); ?></p>
						<h1 class="display-3 fw-semibold mb-3"><?php the_title(); ?></h1>
						<?php if ( $scripture ) : ?><p class="lead text-white-75 mb-0"><?php echo esc_html( $scripture ); ?></p><?php endif; ?>
					</div>
				</div>
			</div>
		</header>

		<article <?php post_class( 'container py-5' ); ?>>
			<div class="row justify-content-center py-lg-5">
				<div class="col-lg-10">
					<?php if ( $video_url ) : ?>
						<div class="ratio ratio-16x9 rounded-4 overflow-hidden bg-dark mb-5"><?php echo wp_oembed_get( esc_url( $video_url ) ) ?: ''; ?></div>
					<?php elseif ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid w-100 rounded-4 mb-5' ) ); ?>
					<?php endif; ?>
					<div class="row justify-content-center">
						<div class="col-lg-9 sac-entry-content">
							<?php if ( $date ) : ?><p class="text-body-secondary small"><?php echo esc_html( wp_date( get_option( 'date_format' ), strtotime( $date ) ) ); ?></p><?php endif; ?>
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
