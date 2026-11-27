<?php
/**
 * Gallery album card.
 *
 * @package SAC
 */

$photo_ids = sac_album_photo_ids( get_the_ID() );
$cover_id  = get_post_thumbnail_id() ?: ( $photo_ids[0] ?? 0 );
$cover     = wp_get_attachment_image( $cover_id, 'large', false, array( 'class' => 'sac-album-card-cover', 'alt' => '' ) );
$count     = count( $photo_ids );
?>
<article <?php post_class( 'sac-album-card' ); ?>>
	<?php if ( $cover ) : ?>
		<?php echo $cover; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php endif; ?>
	<div class="sac-album-card-caption">
		<h2 class="h4 mb-1"><a class="stretched-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php if ( $count ) : ?>
			<p class="small mb-0">
				<?php
				/* translators: %s: number of photos in the album. */
				echo esc_html( sprintf( _n( '%s photo', '%s photos', $count, 'sac' ), number_format_i18n( $count ) ) );
				?>
			</p>
		<?php endif; ?>
	</div>
</article>
