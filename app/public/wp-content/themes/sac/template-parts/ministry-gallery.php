<?php
/**
 * Ministry photo gallery.
 *
 * @package SAC
 */

$images = array_filter( array_map( 'absint', $args['images'] ?? array() ), 'wp_attachment_is_image' );
if ( ! $images ) {
	return;
}
?>
<section class="sac-ministry-gallery" aria-labelledby="sac-ministry-gallery-title">
	<h2 id="sac-ministry-gallery-title" class="display-6 fw-semibold mb-4"><?php esc_html_e( 'Ministry Photos', 'sac' ); ?></h2>
	<div class="sac-ministry-gallery-grid">
		<?php foreach ( $images as $image_id ) : ?>
			<figure class="mb-0">
				<div class="sac-ministry-gallery-photo">
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
