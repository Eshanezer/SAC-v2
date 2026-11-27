<?php
/**
 * Standard page template.
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" tabindex="-1" class="site-main">
	<?php while ( have_posts() ) : ?>
		<?php
		the_post();
		$eyebrow = (string) sac_field( 'sac_page_eyebrow', __( 'Spirit Assembly Church', 'sac' ) );
		$intro    = (string) sac_field( 'sac_page_intro', '' );
		$image    = sac_image_url( 'sac_page_image', 'full' );
		$is_ministries_page = get_the_ID() === sac_page_id( 'ministries' );
		?>
		<?php if ( $is_ministries_page ) : ?>
			<header class="sac-ministry-index-hero">
				<div class="container">
					<p class="sac-eyebrow mb-3"><?php echo esc_html( $eyebrow ); ?></p>
					<h1 class="display-2 fw-semibold mb-0"><?php the_title(); ?></h1>
					<?php if ( $intro ) : ?><div class="lead mt-3"><?php echo wp_kses_post( $intro ); ?></div><?php endif; ?>
					<?php if ( $image ) : ?><img class="sac-ministry-index-cover" src="<?php echo esc_url( $image ); ?>" alt=""><?php endif; ?>
				</div>
			</header>
		<?php else : ?>
			<?php get_template_part( 'template-parts/page-hero', null, array( 'eyebrow' => $eyebrow, 'title' => get_the_title(), 'intro' => $intro, 'image' => $image ) ); ?>
		<?php endif; ?>

		<?php if ( ! $is_ministries_page || trim( get_the_content() ) ) : ?>
			<article <?php post_class( 'container py-5' ); ?>>
				<div class="row justify-content-center py-lg-5">
					<div class="col-lg-9 col-xl-8 sac-entry-content">
						<?php the_content(); ?>
					</div>
				</div>
			</article>
		<?php endif; ?>
		<?php if ( $is_ministries_page ) : ?>
			<?php get_template_part( 'template-parts/ministry-list' ); ?>
		<?php endif; ?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
