<?php
/**
 * Main posts template.
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php get_template_part( 'template-parts/page-hero', null, array( 'eyebrow' => __( 'Spirit Assembly Church', 'sac' ), 'title' => is_home() ? __( 'Latest Updates', 'sac' ) : get_the_archive_title() ) ); ?>

	<div class="container py-5">
		<?php if ( have_posts() ) : ?>
			<div class="row g-4 py-lg-5">
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<div class="col-md-6 col-xl-4">
						<article <?php post_class( 'card h-100 border-0 rounded-4 overflow-hidden sac-content-card' ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<a class="ratio ratio-16x9" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large', array( 'class' => 'w-100 h-100 object-fit-cover' ) ); ?></a>
							<?php endif; ?>
							<div class="card-body p-4">
								<p class="small text-primary text-uppercase fw-bold tracking-wide mb-2"><?php echo esc_html( get_the_date() ); ?></p>
								<h2 class="h4"><a class="stretched-link text-dark text-decoration-none" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<div class="text-body-secondary"><?php the_excerpt(); ?></div>
							</div>
						</article>
					</div>
				<?php endwhile; ?>
			</div>
			<div class="pb-5"><?php the_posts_pagination( array( 'class' => 'pagination' ) ); ?></div>
		<?php else : ?>
			<div class="sac-empty-state rounded-4 p-5 my-5">
				<h2 class="h3"><?php esc_html_e( 'Nothing has been published yet.', 'sac' ); ?></h2>
			</div>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
