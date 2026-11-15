<?php
/**
 * Event card.
 *
 * @package SAC
 */

$start    = (string) sac_field( 'sac_event_start', '' );
$location = (string) sac_field( 'sac_event_location', '' );
?>
<article <?php post_class( 'card h-100 border-0 rounded-4 overflow-hidden sac-content-card' ); ?>>
	<a class="ratio ratio-4x3 sac-card-media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'large', array( 'class' => 'w-100 h-100 object-fit-cover' ) ); ?>
		<?php else : ?>
			<span class="sac-card-placeholder d-block w-100 h-100"></span>
		<?php endif; ?>
	</a>
	<div class="card-body d-flex flex-column p-4">
		<?php if ( $start ) : ?>
			<p class="small text-primary text-uppercase fw-bold tracking-wide mb-2"><?php echo esc_html( sac_format_datetime( $start ) ); ?></p>
		<?php endif; ?>
		<h3 class="h4 mb-2"><a class="stretched-link text-dark text-decoration-none" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( $location ) : ?>
			<p class="text-body-secondary small mb-3"><?php echo esc_html( $location ); ?></p>
		<?php endif; ?>
		<?php if ( has_excerpt() ) : ?>
			<div class="text-body-secondary mt-auto"><?php the_excerpt(); ?></div>
		<?php endif; ?>
	</div>
</article>
