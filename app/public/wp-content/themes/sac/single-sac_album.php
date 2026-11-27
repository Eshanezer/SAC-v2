<?php
/**
 * Individual photo album.
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" tabindex="-1" class="site-main sac-gallery">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article <?php post_class( 'container py-5' ); ?>>
			<header class="sac-album-header mb-5">
				<h1 class="display-3 fw-semibold mb-0"><?php the_title(); ?></h1>
				<?php if ( trim( get_the_content() ) ) : ?>
					<div class="sac-entry-content mt-3"><?php the_content(); ?></div>
				<?php elseif ( has_excerpt() ) : ?>
					<div class="lead mt-3"><?php the_excerpt(); ?></div>
				<?php endif; ?>
			</header>
			<?php get_template_part( 'template-parts/album-photos' ); ?>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
