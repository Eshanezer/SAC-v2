<?php
/**
 * Message archive.
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php get_template_part( 'template-parts/page-hero', null, array( 'eyebrow' => __( 'Grow in Faith', 'sac' ), 'title' => __( 'Messages', 'sac' ), 'intro' => __( 'Watch teaching and encouragement from Spirit Assembly Church.', 'sac' ) ) ); ?>

	<div class="container py-5">
		<?php if ( have_posts() ) : ?>
			<div class="row g-4 py-lg-5">
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<div class="col-md-6 col-xl-4"><?php get_template_part( 'template-parts/card', 'sermon' ); ?></div>
				<?php endwhile; ?>
			</div>
			<div class="pb-5"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<div class="sac-empty-state rounded-4 p-5 my-5">
				<h2 class="h3 mb-2"><?php esc_html_e( 'Messages will be added soon.', 'sac' ); ?></h2>
				<p class="text-body-secondary mb-0"><?php esc_html_e( 'Please check back for new teaching.', 'sac' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
