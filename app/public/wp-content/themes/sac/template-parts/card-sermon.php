<?php
/**
 * Message card.
 *
 * @package SAC
 */

$speaker   = (string) sac_field( 'sac_sermon_speaker', '' );
$scripture = (string) sac_field( 'sac_sermon_scripture', '' );
?>
<article <?php post_class( 'card h-100 border-0 rounded-4 overflow-hidden sac-content-card' ); ?>>
	<a class="ratio ratio-16x9 sac-card-media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'large', array( 'class' => 'w-100 h-100 object-fit-cover' ) ); ?>
		<?php else : ?>
			<span class="sac-card-placeholder d-block w-100 h-100"></span>
		<?php endif; ?>
	</a>
	<div class="card-body d-flex flex-column p-4">
		<p class="small text-primary text-uppercase fw-bold tracking-wide mb-2"><?php echo esc_html( $speaker ?: __( 'Message', 'sac' ) ); ?></p>
		<h3 class="h4 mb-2"><a class="stretched-link text-dark text-decoration-none" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( $scripture ) : ?>
			<p class="text-body-secondary small mb-0"><?php echo esc_html( $scripture ); ?></p>
		<?php endif; ?>
	</div>
</article>
