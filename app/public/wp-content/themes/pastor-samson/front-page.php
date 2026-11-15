<?php
/** Pastor portfolio landing page. */
get_header();
$portrait = get_the_post_thumbnail_url( get_queried_object_id(), 'full' );
if ( ! $portrait ) {
	$portrait = get_template_directory_uri() . '/assets/img/samson-4.jpg';
}
?>
<main id="main">
	<section class="ps-hero d-flex align-items-center">
		<div class="container"><div class="row align-items-center g-5">
			<div class="col-lg-7 ps-hero-copy">
				<span class="ps-kicker"><?php echo esc_html( ps_value( 'ps_hero_kicker', __( 'Pastor · Teacher · Leader', 'pastor-samson' ) ) ); ?></span>
				<h1><?php esc_html_e( 'Faith that', 'pastor-samson' ); ?> <span><?php esc_html_e( 'moves', 'pastor-samson' ); ?></span> <?php esc_html_e( 'people forward.', 'pastor-samson' ); ?></h1>
				<p class="lead"><?php echo esc_html( ps_value( 'ps_hero_intro', __( 'Equipping people to encounter God, live with purpose and influence their world through the transforming power of faith.', 'pastor-samson' ) ) ); ?></p>
				<div class="d-flex flex-wrap gap-3 mt-4"><a class="btn btn-ps" href="#about"><?php esc_html_e( 'Discover the Story', 'pastor-samson' ); ?></a><a class="btn btn-ps btn-ps-outline" href="#messages"><?php esc_html_e( 'Watch Messages', 'pastor-samson' ); ?></a></div>
			</div>
			<div class="col-lg-5"><div class="ps-portrait"><img src="<?php echo esc_url( $portrait ); ?>" alt="<?php esc_attr_e( 'Dr. Samson Ajikobi speaking at an event', 'pastor-samson' ); ?>"><span class="ps-signature"><?php esc_html_e( 'Dr. Samson Ajikobi', 'pastor-samson' ); ?></span></div></div>
		</div></div>
	</section>

	<section class="ps-section ps-intro" id="about"><div class="container"><div class="row g-5 align-items-start">
		<div class="col-lg-8"><span class="ps-kicker"><?php esc_html_e( 'The calling', 'pastor-samson' ); ?></span><h2 class="ps-display mt-3"><?php echo esc_html( ps_value( 'ps_about_title', __( 'Medicine, ministry and a burden for revival in Europe.', 'pastor-samson' ) ) ); ?></h2></div>
		<div class="col-lg-4"><p class="ps-copy"><?php echo esc_html( ps_value( 'ps_about_text', __( 'Born and raised in Kwara State, Nigeria, Dr. Samson Ajikobi studied medicine in Russia before moving to Latvia in 2018. A pastor, physician and author, his ministry is centred on prayer, the Word of God, the supernatural and raising purposeful leaders.', 'pastor-samson' ) ) ); ?></p><div class="ps-stat"><strong><?php esc_html_e( 'Latvia', 'pastor-samson' ); ?></strong><span><?php esc_html_e( 'Serving locally, reaching Europe and the nations', 'pastor-samson' ); ?></span></div></div>
	</div></div></section>

	<section class="ps-section ps-story"><div class="container">
		<div class="row g-4 align-items-end mb-5"><div class="col-lg-8"><span class="ps-kicker"><?php esc_html_e( 'Life and calling', 'pastor-samson' ); ?></span><h2 class="ps-display mt-3 mb-0"><?php esc_html_e( 'Faith expressed in every sphere.', 'pastor-samson' ); ?></h2></div><div class="col-lg-4"><p class="ps-copy mb-0"><?php esc_html_e( 'From leading worship and planting churches to medicine and missions, his story joins spiritual conviction with professional excellence.', 'pastor-samson' ); ?></p></div></div>
		<div class="ps-story-grid">
			<figure class="ps-story-image ps-story-image--tall"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/samson-3.jpg' ); ?>" alt="<?php esc_attr_e( 'Dr. Samson Ajikobi leading worship at the keyboard', 'pastor-samson' ); ?>"><figcaption><?php esc_html_e( 'Worship and ministry', 'pastor-samson' ); ?></figcaption></figure>
			<figure class="ps-story-image"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/samson-1.jpg' ); ?>" alt="<?php esc_attr_e( 'Dr. Samson Ajikobi attending a worship gathering', 'pastor-samson' ); ?>"><figcaption><?php esc_html_e( 'A life of faith', 'pastor-samson' ); ?></figcaption></figure>
			<figure class="ps-story-image"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/samson-5.jpg' ); ?>" alt="<?php esc_attr_e( 'Dr. Samson Ajikobi representing AmberLife Cancer Clinic', 'pastor-samson' ); ?>"><figcaption><?php esc_html_e( 'Medicine and professional service', 'pastor-samson' ); ?></figcaption></figure>
		</div>
		<p class="ps-photo-credit mt-3"><?php esc_html_e( 'Archive photography:', 'pastor-samson' ); ?> <a href="https://thewordheralds.wordpress.com/2020/01/08/i-see-god-cooking-my-brothers-and-sisters-in-nigeria-in-real-fire-the-word-heralds-interview-with-dr-samson-ajikobi/" target="_blank" rel="noopener noreferrer">The Word Herald interview</a></p>
	</div></section>

	<section class="ps-section ps-ministry" id="ministry"><div class="container"><span class="ps-kicker"><?php esc_html_e( 'Areas of ministry', 'pastor-samson' ); ?></span><h2 class="ps-display mt-3 mb-5"><?php esc_html_e( 'A ministry shaped around transformation.', 'pastor-samson' ); ?></h2><div class="row g-4">
		<?php $cards = array( array( '01', __( 'Word & Prayer', 'pastor-samson' ), __( 'Restoring a culture of biblical teaching and prayer as foundations for revival.', 'pastor-samson' ) ), array( '02', __( 'Leadership', 'pastor-samson' ), __( 'Calling believers to combine spiritual anointing with strategy, integrity and professional excellence.', 'pastor-samson' ) ), array( '03', __( 'Missions', 'pastor-samson' ), __( 'A ministry journey extending from Nigeria and Russia to Latvia, Europe and Pakistan.', 'pastor-samson' ) ) ); foreach ( $cards as $card ) : ?>
		<div class="col-md-4"><article class="ps-card"><span class="ps-card-number"><?php echo esc_html( $card[0] ); ?></span><h3><?php echo esc_html( $card[1] ); ?></h3><p><?php echo esc_html( $card[2] ); ?></p></article></div><?php endforeach; ?>
	</div></div></section>

	<section class="ps-section ps-quote" id="messages"><div class="container"><blockquote>“<?php echo esc_html( ps_value( 'ps_quote', __( 'Your purpose becomes clear when your life is fully yielded to God.', 'pastor-samson' ) ) ); ?>”</blockquote><div class="text-center mt-4"><a class="btn btn-ps" href="<?php echo esc_url( network_home_url( '/messages/' ) ); ?>"><?php esc_html_e( 'Explore Messages', 'pastor-samson' ); ?></a></div></div></section>

	<section class="ps-section ps-contact" id="contact"><div class="container"><div class="row align-items-end g-4"><div class="col-lg-8"><span class="ps-kicker"><?php esc_html_e( 'Connect', 'pastor-samson' ); ?></span><h2 class="ps-display mt-3"><?php esc_html_e( 'Invite Pastor Samson or start a conversation.', 'pastor-samson' ); ?></h2><p class="ps-copy mt-4"><?php esc_html_e( 'For speaking invitations, ministry partnerships and enquiries, contact the Spirit Assembly team.', 'pastor-samson' ); ?></p></div><div class="col-lg-4 text-lg-end"><a class="btn btn-ps" href="mailto:<?php echo esc_attr( get_option( 'admin_email' ) ); ?>"><?php esc_html_e( 'Send an Enquiry', 'pastor-samson' ); ?></a></div></div></div></section>
</main>
<?php get_footer(); ?>
