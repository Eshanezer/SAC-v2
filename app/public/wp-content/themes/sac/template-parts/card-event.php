<?php
/**
 * Event card.
 *
 * @package SAC
 */

$start    = (string) sac_field( 'sac_event_start', '' );
$location = (string) sac_field( 'sac_event_location', '' );
$heading  = (string) sac_field( 'sac_event_heading', get_the_title() );
$summary  = (string) sac_field( 'sac_event_summary', '' );
$image_attrs = array( 'class' => 'w-100 h-100 object-fit-cover', 'alt' => '' );
$cover    = wp_get_attachment_image( (int) sac_field( 'sac_event_cover', 0 ), 'large', false, $image_attrs );
$heading_tag = 2 === ( $args['heading_level'] ?? 3 ) ? 'h2' : 'h3';
?>
<article <?php post_class( 'card h-100 border-0 rounded-4 overflow-hidden sac-content-card' ); ?>>
	<div class="ratio ratio-4x3 sac-card-media">
		<?php if ( $cover ) : ?>
			<?php echo $cover; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php elseif ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'large', $image_attrs ); ?>
		<?php else : ?>
			<span class="sac-card-placeholder d-block w-100 h-100"></span>
		<?php endif; ?>
	</div>
	<div class="card-body d-flex flex-column p-4">
		<?php if ( $start ) : ?>
			<p class="small text-primary text-uppercase fw-bold tracking-wide mb-2"><?php echo esc_html( sac_format_datetime( $start ) ); ?></p>
		<?php endif; ?>
		<<?php echo esc_html( $heading_tag ); ?> class="h4 mb-2"><a class="stretched-link text-dark text-decoration-none" href="<?php the_permalink(); ?>"><?php echo esc_html( $heading ); ?></a></<?php echo esc_html( $heading_tag ); ?>>
		<?php if ( $location ) : ?>
			<p class="text-body-secondary small mb-3"><?php echo esc_html( $location ); ?></p>
		<?php endif; ?>
		<?php if ( $summary ) : ?>
			<p class="text-body-secondary mt-auto mb-0"><?php echo esc_html( $summary ); ?></p>
		<?php elseif ( has_excerpt() ) : ?>
			<div class="text-body-secondary mt-auto"><?php the_excerpt(); ?></div>
		<?php endif; ?>
	</div>
</article>
