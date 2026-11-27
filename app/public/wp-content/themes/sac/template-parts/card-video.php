<?php
/**
 * Video library card.
 *
 * @package SAC
 */

$post_id  = get_the_ID();
$video_id = sac_saved_video_id( $post_id );
$cover_id = absint( get_post_meta( $post_id, 'sac_video_thumbnail', true ) ) ?: get_post_thumbnail_id();
$cover    = wp_get_attachment_image( $cover_id, 'large', false, array( 'alt' => '', 'loading' => 'lazy' ) );
$summary  = trim( wp_strip_all_tags( get_the_excerpt() ) );
?>
<article <?php post_class( 'sac-video-card' ); ?>>
	<div class="sac-video-card-thumbnail">
		<?php if ( $cover ) : ?>
			<?php echo $cover; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php elseif ( $video_id ) : ?>
			<img src="<?php echo esc_url( 'https://i.ytimg.com/vi/' . $video_id . '/hqdefault.jpg' ); ?>" alt="" width="480" height="360" loading="lazy" decoding="async">
		<?php endif; ?>
		<?php if ( $video_id ) : ?><span class="sac-video-play" aria-hidden="true">&#9654;</span><?php endif; ?>
	</div>
	<div class="sac-video-card-copy">
		<h2 class="h4 mb-2"><a class="stretched-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php if ( $summary ) : ?><p class="mb-0 text-body-secondary"><?php echo esc_html( $summary ); ?></p><?php endif; ?>
	</div>
</article>
