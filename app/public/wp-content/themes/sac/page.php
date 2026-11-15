<?php
/**
 * Standard page template.
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php while ( have_posts() ) : ?>
		<?php
		the_post();
		$eyebrow = (string) sac_field( 'sac_page_eyebrow', __( 'Spirit Assembly Church', 'sac' ) );
		$intro    = (string) sac_field( 'sac_page_intro', '' );
		$image    = sac_image_url( 'sac_page_image', 'full' );
		?>
		<?php get_template_part( 'template-parts/page-hero', null, array( 'eyebrow' => $eyebrow, 'title' => get_the_title(), 'intro' => $intro, 'image' => $image ) ); ?>

		<article <?php post_class( 'container py-5' ); ?>>
			<div class="row justify-content-center py-lg-5">
				<div class="col-lg-9 col-xl-8 sac-entry-content">
					<?php the_content(); ?>
				</div>
			</div>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
