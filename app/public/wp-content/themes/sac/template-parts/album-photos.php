<?php
/**
 * Paginated album photos in saved order.
 *
 * @package SAC
 */

$photo_ids = sac_album_photo_ids( get_the_ID() );
if ( $photo_ids ) {
	$photo_ids = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'post_mime_type' => 'image',
			'post__in'       => $photo_ids,
			'orderby'        => 'post__in',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);
}

if ( ! $photo_ids ) {
	echo '<p class="sac-empty-state rounded-4 p-4">' . esc_html__( 'No photos have been added to this album yet.', 'sac' ) . '</p>';
	return;
}

$per_page    = 24;
$total_pages = (int) ceil( count( $photo_ids ) / $per_page );
$requested   = get_query_var( 'album_page', '1' );
$page        = is_scalar( $requested ) ? max( 1, min( $total_pages, (int) $requested ) ) : 1;
$offset      = ( $page - 1 ) * $per_page;
$visible     = array_slice( $photo_ids, $offset, $per_page );
?>
<div id="album-photos" class="sac-album-photos">
	<?php foreach ( $visible as $index => $photo_id ) : ?>
		<?php
		$caption = wp_get_attachment_caption( $photo_id );
		$alt     = trim( (string) get_post_meta( $photo_id, '_wp_attachment_image_alt', true ) );
		/* translators: %s: photo position in the album. */
		$label = $alt ?: ( $caption ?: sprintf( __( 'Open photo %s', 'sac' ), number_format_i18n( $offset + $index + 1 ) ) );
		?>
		<figure class="sac-album-photo">
			<a href="<?php echo esc_url( wp_get_attachment_image_url( $photo_id, 'full' ) ); ?>" aria-label="<?php echo esc_attr( $label ); ?>">
				<?php echo wp_get_attachment_image( $photo_id, 'large', false, array( 'loading' => 'lazy', 'sizes' => '(min-width: 992px) 30vw, (min-width: 576px) 46vw, 95vw' ) ); ?>
			</a>
			<?php if ( $caption ) : ?><figcaption><?php echo esc_html( $caption ); ?></figcaption><?php endif; ?>
		</figure>
	<?php endforeach; ?>
</div>
<?php if ( $total_pages > 1 ) : ?>
	<nav class="sac-album-pagination mt-5" aria-label="<?php esc_attr_e( 'Album photo pages', 'sac' ); ?>">
		<?php
		echo wp_kses_post(
			paginate_links(
				array(
					'base'         => str_replace( '999999999', '%#%', add_query_arg( 'album_page', '999999999', get_permalink() ) ),
					'format'       => '',
					'total'        => $total_pages,
					'current'      => $page,
					'type'         => 'list',
					'add_fragment' => '#album-photos',
				)
			)
		);
		?>
	</nav>
<?php endif; ?>
