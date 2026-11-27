<?php
/**
 * Video library.
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" tabindex="-1" class="site-main sac-video-library">
	<header class="container py-5">
		<h1 class="display-2 fw-semibold mb-3"><?php esc_html_e( 'Videos', 'sac' ); ?></h1>
		<p class="lead mb-0"><?php esc_html_e( 'Watch recordings from Spirit Assembly Church.', 'sac' ); ?></p>
	</header>
	<div class="container pb-5">
		<?php if ( have_posts() ) : ?>
			<div class="sac-video-list mb-5">
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<?php get_template_part( 'template-parts/card-video' ); ?>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p class="sac-empty-state rounded-4 p-4 mb-0"><?php esc_html_e( 'No videos are published yet.', 'sac' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
