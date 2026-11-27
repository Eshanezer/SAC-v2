<?php
/**
 * Single event.
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" tabindex="-1" class="site-main">
	<?php while ( have_posts() ) : ?>
		<?php
		the_post();
		$start        = (string) sac_field( 'sac_event_start', '' );
		$end          = (string) sac_field( 'sac_event_end', '' );
		$location     = (string) sac_field( 'sac_event_location', '' );
		$address      = (string) sac_field( 'sac_event_address', '' );
		$heading      = (string) sac_field( 'sac_event_heading', get_the_title() );
		$summary      = (string) sac_field( 'sac_event_summary', '' );
		$information  = (string) sac_field( 'sac_event_information', '' );
		$cover        = sac_image_url( 'sac_event_cover', 'full' );
		$gallery      = (array) sac_field( 'sac_event_gallery', array() );
		$registration = sac_link(
			'sac_event_link',
			array(
				'url'    => '#',
				'title'  => __( 'Register', 'sac' ),
				'target' => '_self',
			)
		);
		get_template_part(
			'template-parts/page-hero',
			null,
			array(
				'eyebrow' => $start ? sac_format_datetime( $start ) : __( 'Event', 'sac' ),
				'title'   => $heading,
				'intro'   => esc_html( $location ),
				'image'   => $cover,
			)
		);
		?>

		<article <?php post_class( 'container py-5' ); ?>>
			<div class="row g-5 py-lg-5">
				<div class="col-lg-8 sac-entry-content">
					<?php if ( ! $cover && has_post_thumbnail() ) : ?><?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded-4 mb-5' ) ); ?><?php endif; ?>
					<?php if ( $summary ) : ?><p class="lead"><?php echo esc_html( $summary ); ?></p><?php endif; ?>
					<?php echo wp_kses_post( $information ); ?>
					<?php the_content(); ?>
				</div>
				<aside class="col-lg-4">
					<div class="card border-0 rounded-4 shadow-sm sticky-lg-top sac-event-details">
						<div class="card-body p-4">
							<h2 class="h5 mb-4"><?php esc_html_e( 'Event Details', 'sac' ); ?></h2>
							<?php if ( $start ) : ?><p class="mb-2"><strong><?php esc_html_e( 'Starts:', 'sac' ); ?></strong><br><?php echo esc_html( sac_format_datetime( $start ) ); ?></p><?php endif; ?>
							<?php if ( $end ) : ?><p class="mb-2"><strong><?php esc_html_e( 'Ends:', 'sac' ); ?></strong><br><?php echo esc_html( sac_format_datetime( $end ) ); ?></p><?php endif; ?>
							<?php if ( $location ) : ?><p class="mb-2"><strong><?php esc_html_e( 'Location:', 'sac' ); ?></strong><br><?php echo esc_html( $location ); ?></p><?php endif; ?>
							<?php if ( $address ) : ?><div class="text-body-secondary small mb-4"><?php echo wp_kses_post( nl2br( esc_html( $address ) ) ); ?></div><?php endif; ?>
							<?php if ( '#' !== $registration['url'] ) : ?><a class="btn btn-primary w-100 mt-3" href="<?php echo esc_url( $registration['url'] ); ?>" target="<?php echo esc_attr( $registration['target'] ); ?>"><?php echo esc_html( $registration['title'] ); ?></a><?php endif; ?>
						</div>
					</div>
				</aside>
			</div>
			<?php if ( $gallery ) : ?>
				<?php get_template_part( 'template-parts/event-gallery', null, array( 'images' => $gallery ) ); ?>
			<?php endif; ?>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
