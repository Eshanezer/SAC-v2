<?php
/**
 * Single standard post template.
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<header class="sac-page-hero text-white">
			<div class="container py-5">
				<div class="row justify-content-center py-5">
					<div class="col-lg-9 col-xl-8 text-center">
						<p class="sac-eyebrow text-primary mb-3"><?php echo esc_html( get_the_date() ); ?></p>
						<h1 class="display-3 fw-semibold mb-0"><?php the_title(); ?></h1>
					</div>
				</div>
			</div>
		</header>

		<article <?php post_class( 'container py-5' ); ?>>
			<div class="row justify-content-center py-lg-5">
				<div class="col-lg-9 col-xl-8 sac-entry-content">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded-4 mb-5' ) ); ?>
					<?php endif; ?>
					<?php the_content(); ?>
					<div class="mt-5 pt-4 border-top"><?php the_post_navigation(); ?></div>
				</div>
			</div>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
