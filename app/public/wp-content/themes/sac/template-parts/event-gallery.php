<?php
/**
 * Responsive event photo gallery.
 *
 * @package SAC
 */

$images = array_filter( array_map( 'absint', $args['images'] ?? array() ), 'wp_attachment_is_image' );
if ( ! $images ) {
	return;
}
?>
<section class="sac-event-gallery mt-5" aria-labelledby="sac-event-gallery-title">
	<h2 id="sac-event-gallery-title" class="h3 mb-4"><?php esc_html_e( 'Event Photos', 'sac' ); ?></h2>
	<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
		<?php foreach ( $images as $image_id ) : ?>
			<figure class="col mb-0">
				<div class="ratio ratio-4x3 overflow-hidden rounded-4">
					<?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'w-100 h-100 object-fit-cover', 'loading' => 'lazy' ) ); ?>
				</div>
				<?php $caption = wp_get_attachment_caption( $image_id ); ?>
				<?php if ( $caption ) : ?>
					<figcaption class="small text-body-secondary mt-2"><?php echo esc_html( $caption ); ?></figcaption>
				<?php endif; ?>
			</figure>
		<?php endforeach; ?>
	</div>
</section>
