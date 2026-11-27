<?php
/**
 * Event archive.
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" tabindex="-1" class="site-main">
	<?php get_template_part( 'template-parts/page-hero', null, array( 'eyebrow' => __( 'Church Life', 'sac' ), 'title' => __( 'Events', 'sac' ), 'intro' => __( 'Gather, grow, and build community with Spirit Assembly Church.', 'sac' ) ) ); ?>

	<div class="container py-5">
		<?php if ( have_posts() ) : ?>
			<div class="row g-4 py-lg-5">
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<div class="col-md-6 col-xl-4"><?php get_template_part( 'template-parts/card', 'event', array( 'heading_level' => 2 ) ); ?></div>
				<?php endwhile; ?>
			</div>
			<div class="pb-5"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<div class="sac-empty-state rounded-4 p-5 my-5">
				<h2 class="h3 mb-2"><?php esc_html_e( 'No events are published yet.', 'sac' ); ?></h2>
				<p class="text-body-secondary mb-0"><?php esc_html_e( 'Please check back soon.', 'sac' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
