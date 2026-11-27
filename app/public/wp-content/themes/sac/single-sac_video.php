<?php
/**
 * Video watch page.
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" tabindex="-1" class="site-main sac-video-library">
	<?php while ( have_posts() ) : ?>
		<?php
		the_post();
		$video_id = sac_saved_video_id( get_the_ID() );
		?>
		<article <?php post_class( 'container py-5' ); ?>>
			<header class="sac-video-watch-header mb-4">
				<h1 class="display-4 fw-semibold mb-0"><?php the_title(); ?></h1>
			</header>
			<?php if ( $video_id ) : ?>
				<?php get_template_part( 'template-parts/youtube-player', null, array( 'video_id' => $video_id ) ); ?>
			<?php else : ?>
				<p class="sac-empty-state rounded-4 p-4"><?php esc_html_e( 'This video is currently unavailable.', 'sac' ); ?></p>
			<?php endif; ?>
			<?php if ( trim( get_the_content() ) ) : ?>
				<div class="sac-entry-content sac-video-description mt-4"><?php the_content(); ?></div>
			<?php elseif ( has_excerpt() ) : ?>
				<div class="sac-video-description mt-4"><?php the_excerpt(); ?></div>
			<?php endif; ?>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
