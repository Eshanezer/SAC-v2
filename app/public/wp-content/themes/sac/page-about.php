<?php
/**
 * Template Name: About Page
 * Template Post Type: page
 *
 * @package SAC
 */

get_header();

while ( have_posts() ) :
	the_post();

	$eyebrow     = (string) sac_field( 'sac_page_eyebrow', __( 'Our Church', 'sac' ) );
	$intro       = (string) sac_field( 'sac_page_intro', __( 'Discover the vision, beliefs, and story of Spirit Assembly Church.', 'sac' ) );
	$image       = sac_image_url( 'sac_page_image', 'full' );
	$vision_overline = (string) sac_field( 'sac_vision_eyebrow', __( 'Why we are here', 'sac' ) );
	$vision_title    = (string) sac_field( 'sac_vision_title', __( 'Church vision', 'sac' ) );
	$vision_intro    = (string) sac_field( 'sac_vision_intro', __( 'Our vision is to reveal God’s love and power, build mature believers, and equip every generation to fulfil their calling.', 'sac' ) );
	$visions = array(
		(string) sac_field( 'sac_vision_item_one', 'To establish God’s kingdom on Earth through reaching to the lost souls and demonstrating the reality of the love and power of God through Miracles, Signs and Wonders; bringing healing, deliverance, and transformation to men.' ),
		(string) sac_field( 'sac_vision_item_two', 'To bring the body of Christ into the revelatory and balanced truth of God’s Word until we all come to maturity and unity in the Faith.' ),
		(string) sac_field( 'sac_vision_item_three', 'To help the individual (both young and old) in the Body of Christ understand and fulfill their God-given purpose in the society, governance and the marketplace with integrity, professionalism and God’s anointing.' ),
	);
	$story_image_id = (int) sac_field( 'sac_about_story_image', 0 );
	$community_image = $story_image_id ? (string) wp_get_attachment_image_url( $story_image_id, 'large' ) : get_theme_file_uri( '/assets/img/placeholders/prayer-care.jpg' );
	$community_alt = $story_image_id ? (string) get_post_meta( $story_image_id, '_wp_attachment_image_alt', true ) : __( 'A church member offering compassionate prayer and support', 'sac' );
	$community_alt = $community_alt ?: ( $story_image_id ? get_the_title( $story_image_id ) : '' );
	$gallery_eyebrow = (string) sac_field( 'sac_about_gallery_eyebrow', __( 'Life together', 'sac' ) );
	$gallery_title = (string) sac_field( 'sac_about_gallery_title', __( 'Moments of faith, connection, and purpose.', 'sac' ) );
	$gallery_intro = (string) sac_field( 'sac_about_gallery_intro', __( 'Church life is made of shared moments—worship, friendship, prayer, service, and growing together.', 'sac' ) );
	$gallery_ids = sac_field( 'sac_about_gallery', array() );

	if ( ! is_array( $gallery_ids ) ) {
		$gallery_ids = array();
	}

	$gallery_fallbacks = array(
		array( 'url' => get_theme_file_uri( '/assets/img/placeholders/worship-hero.jpg' ), 'alt' => __( 'A multigenerational church congregation worshipping together', 'sac' ) ),
		array( 'url' => get_theme_file_uri( '/assets/img/placeholders/church-community.jpg' ), 'alt' => __( 'People enjoying conversation and community at church', 'sac' ) ),
		array( 'url' => get_theme_file_uri( '/assets/img/placeholders/prayer-care.jpg' ), 'alt' => __( 'Two church members sharing a moment of prayer', 'sac' ) ),
	);
	?>
	<main id="primary" tabindex="-1" class="site-main sac-about-page">
		<?php get_template_part( 'template-parts/page-hero', null, array( 'eyebrow' => $eyebrow, 'title' => get_the_title(), 'intro' => $intro, 'image' => $image ) ); ?>

		<?php if ( trim( (string) get_the_content() ) ) : ?>
			<article <?php post_class( 'container py-5' ); ?>><div class="row justify-content-center py-lg-4"><div class="col-lg-9 col-xl-8 sac-entry-content"><?php the_content(); ?></div></div></article>
		<?php endif; ?>

		<section class="sac-about-story py-5" aria-labelledby="sac-about-story-title">
			<div class="container py-lg-5">
				<div class="row align-items-center g-5">
					<div class="col-lg-6">
						<div class="sac-story-image rounded-4 overflow-hidden">
							<img class="w-100 h-100 object-fit-cover" src="<?php echo esc_url( $community_image ); ?>" alt="<?php echo esc_attr( $community_alt ); ?>" loading="lazy" decoding="async">
						</div>
					</div>
					<div class="col-lg-5 offset-lg-1">
						<p class="sac-eyebrow text-primary mb-3"><?php esc_html_e( 'Faith lived together', 'sac' ); ?></p>
						<h2 id="sac-about-story-title" class="display-5 fw-semibold mb-4"><?php esc_html_e( 'A church where people are known, loved, and strengthened.', 'sac' ); ?></h2>
						<p class="lead text-body-secondary mb-4"><?php esc_html_e( 'We believe church is more than a Sunday gathering. It is a family that worships, grows, prays, and walks through life together.', 'sac' ); ?></p>
						<a class="btn btn-primary" href="<?php echo esc_url( sac_page_url( 'new-here' ) ); ?>"><?php esc_html_e( 'Plan your first visit', 'sac' ); ?></a>
					</div>
				</div>
			</div>
		</section>

		<section class="sac-vision-section py-5" aria-labelledby="sac-vision-title">
			<div class="container py-lg-5">
				<div class="row align-items-end g-4 mb-5">
					<div class="col-lg-7">
						<p class="sac-eyebrow text-primary mb-3"><?php echo esc_html( $vision_overline ); ?></p>
						<h2 id="sac-vision-title" class="display-4 fw-semibold mb-0"><?php echo esc_html( $vision_title ); ?></h2>
					</div>
					<div class="col-lg-5"><p class="lead mb-0"><?php echo esc_html( $vision_intro ); ?></p></div>
				</div>
				<div class="row g-4">
					<?php foreach ( $visions as $index => $vision ) : ?>
						<?php if ( $vision ) : ?>
							<div class="col-lg-4">
								<article class="sac-vision-card h-100 rounded-4 p-4 p-xl-5">
									<span class="sac-vision-number mb-4"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
									<p class="mb-0"><?php echo esc_html( $vision ); ?></p>
								</article>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="sac-about-gallery-section py-5" aria-labelledby="sac-gallery-title">
			<div class="container py-lg-5">
				<div class="row align-items-end g-4 mb-5">
					<div class="col-lg-7"><p class="sac-eyebrow text-primary mb-3"><?php echo esc_html( $gallery_eyebrow ); ?></p><h2 id="sac-gallery-title" class="display-4 fw-semibold mb-0"><?php echo esc_html( $gallery_title ); ?></h2></div>
					<div class="col-lg-5"><p class="lead text-body-secondary mb-0"><?php echo esc_html( $gallery_intro ); ?></p></div>
				</div>

				<div class="sac-photo-grid" role="list">
					<?php if ( $gallery_ids ) : ?>
						<?php foreach ( $gallery_ids as $image_id ) : ?>
							<?php
							$image_id = is_array( $image_id ) ? (int) ( $image_id['ID'] ?? 0 ) : (int) $image_id;
							if ( ! $image_id ) { continue; }
							$alt = (string) get_post_meta( $image_id, '_wp_attachment_image_alt', true );
							$caption = (string) wp_get_attachment_caption( $image_id );
							$alt = $alt ?: ( $caption ?: get_the_title( $image_id ) );
							?>
							<figure class="sac-photo-grid-item mb-0" role="listitem">
								<?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'w-100 h-100 object-fit-cover', 'alt' => $alt, 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
								<?php if ( $caption ) : ?><figcaption><?php echo esc_html( $caption ); ?></figcaption><?php endif; ?>
							</figure>
						<?php endforeach; ?>
					<?php else : ?>
						<?php foreach ( $gallery_fallbacks as $fallback ) : ?>
							<figure class="sac-photo-grid-item mb-0" role="listitem"><img class="w-100 h-100 object-fit-cover" src="<?php echo esc_url( $fallback['url'] ); ?>" alt="<?php echo esc_attr( $fallback['alt'] ); ?>" loading="lazy" decoding="async"></figure>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</section>
	</main>
	<?php
endwhile;

get_footer();
