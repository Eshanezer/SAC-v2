<?php
/**
 * Ministry detail page.
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" tabindex="-1" class="site-main">
	<?php while ( have_posts() ) : ?>
		<?php
		the_post();
		$image_id = (int) sac_field( 'sac_page_image', get_post_thumbnail_id() );
		$image    = wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'w-100 h-100 object-fit-cover', 'loading' => 'eager' ) );
		$intro    = (string) sac_field( 'sac_page_intro', has_excerpt() ? get_the_excerpt() : '' );
		$gallery  = (array) sac_field( 'sac_ministry_gallery', array() );
		?>
		<article <?php post_class( 'container py-5' ); ?>>
			<header class="sac-ministry-detail-hero">
				<div class="sac-ministry-detail-copy">
					<p class="sac-eyebrow mb-3"><?php echo esc_html( sac_field( 'sac_page_eyebrow', __( 'Ministries', 'sac' ) ) ); ?></p>
					<h1 class="display-3 fw-semibold mb-0"><?php the_title(); ?></h1>
					<?php if ( $intro ) : ?><div class="lead mt-3"><?php echo wp_kses_post( $intro ); ?></div><?php endif; ?>
				</div>
				<?php if ( $image ) : ?>
					<div class="sac-ministry-detail-photo"><?php echo $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<?php endif; ?>
			</header>
			<div class="sac-entry-content sac-ministry-story mx-auto py-5"><?php the_content(); ?></div>
			<?php if ( $gallery ) : ?>
				<?php get_template_part( 'template-parts/ministry-gallery', null, array( 'images' => $gallery ) ); ?>
			<?php endif; ?>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
