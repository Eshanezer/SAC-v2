<?php
/**
 * Ministry cards on the existing Ministries page.
 *
 * @package SAC
 */

$ministries = new WP_Query(
	array(
		'post_type'      => 'sac_ministry',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);
?>
<section class="container py-5" aria-labelledby="sac-ministry-list-title">
	<h2 id="sac-ministry-list-title" class="display-6 fw-semibold mb-4"><?php esc_html_e( 'Explore our ministries', 'sac' ); ?></h2>
	<?php if ( $ministries->posts ) : ?>
		<div class="sac-ministry-list">
			<?php foreach ( $ministries->posts as $ministry ) : ?>
				<?php
				$title = get_the_title( $ministry );
				$summary = trim( wp_strip_all_tags( get_the_excerpt( $ministry ) ) );
				$image_id = get_post_thumbnail_id( $ministry ) ?: (int) sac_field( 'sac_page_image', 0, $ministry->ID );
				$image = wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'w-100 h-100 object-fit-cover' ) );
				?>
				<article <?php post_class( 'sac-ministry-row', $ministry ); ?>>
					<?php if ( $image ) : ?>
						<div class="sac-ministry-row-photo"><?php echo $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
					<?php endif; ?>
					<div class="sac-ministry-row-copy">
						<h3 class="display-6 fw-semibold mb-3">
							<a class="stretched-link" href="<?php echo esc_url( get_permalink( $ministry ) ); ?>"><?php echo esc_html( $title ); ?></a>
						</h3>
						<?php if ( $summary ) : ?><p class="lead mb-3"><?php echo esc_html( $summary ); ?></p><?php endif; ?>
						<span class="sac-ministry-row-arrow" aria-hidden="true">&rarr;</span>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	<?php else : ?>
		<p class="text-body-secondary mb-0"><?php esc_html_e( 'Ministry details will be available soon.', 'sac' ); ?></p>
	<?php endif; ?>
</section>
