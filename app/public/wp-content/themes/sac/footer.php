<?php
/**
 * Site footer.
 *
 * @package SAC
 */

$front_page_id = sac_front_page_id();
$service_time  = (string) sac_field( 'sac_service_time', '', $front_page_id );
$location_name = (string) sac_field( 'sac_location_name', __( 'Riga, Latvia', 'sac' ), $front_page_id );
$address       = (string) sac_field( 'sac_location_address', '', $front_page_id );
$contact_id    = sac_page_id( 'contact' );
$phone         = (string) sac_contact_info( 'CONTACT_PHONE', 'sac_contact_phone', '+371 22089000', $contact_id );
$socials       = array(
	'Facebook'  => (string) sac_contact_info( 'SOCIAL_FACEBOOK', 'sac_social_facebook', 'https://bit.ly/3ek5Edk', $contact_id ),
	'Instagram' => (string) sac_contact_info( 'SOCIAL_INSTAGRAM', 'sac_social_instagram', 'https://bit.ly/2U32Daz', $contact_id ),
	'YouTube'   => (string) sac_contact_info( 'SOCIAL_YOUTUBE', 'sac_social_youtube', 'https://bit.ly/3wEWzlL', $contact_id ),
	'TikTok'    => (string) sac_contact_info( 'SOCIAL_TIKTOK', 'sac_social_tiktok', 'https://bit.ly/42Taw2M', $contact_id ),
);
?>
<footer class="site-footer bg-dark text-white pt-5">
	<div class="container py-4 py-lg-5">
		<div class="row g-5">
			<div class="col-lg-5">
				<div class="d-flex align-items-center gap-3 mb-4">
					<?php echo sac_brand_logo( 'footer' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div>
						<strong class="d-block fs-5"><?php esc_html_e( 'Spirit Assembly Church', 'sac' ); ?></strong>
						<span class="text-primary small text-uppercase tracking-wide"><?php esc_html_e( 'Riga, Latvia', 'sac' ); ?></span>
					</div>
				</div>
				<p class="text-white-50 mb-4 sac-footer-intro">
					<?php esc_html_e( 'A multilingual church community welcoming people from Riga and the nations.', 'sac' ); ?>
				</p>
				<p class="small mb-0 text-white-50">English · Latviešu · Русский</p>
			</div>

			<div class="col-6 col-lg-2">
				<h2 class="h6 text-uppercase text-primary tracking-wide mb-3"><?php esc_html_e( 'Explore', 'sac' ); ?></h2>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'list-unstyled mb-0',
						'fallback_cb'    => false,
						'depth'          => 1,
					)
				);
				?>
			</div>

			<div class="col-6 col-lg-2">
				<h2 class="h6 text-uppercase text-primary tracking-wide mb-3"><?php esc_html_e( 'Next Steps', 'sac' ); ?></h2>
				<ul class="list-unstyled mb-0">
					<li class="mb-2"><a class="link-light link-opacity-75-hover text-decoration-none" href="<?php echo esc_url( sac_page_url( 'new-here' ) ); ?>"><?php esc_html_e( 'Plan a Visit', 'sac' ); ?></a></li>
					<li class="mb-2"><a class="link-light link-opacity-75-hover text-decoration-none" href="<?php echo esc_url( (string) get_post_type_archive_link( 'sac_sermon' ) ); ?>"><?php esc_html_e( 'Watch Messages', 'sac' ); ?></a></li>
					<li class="mb-2"><a class="link-light link-opacity-75-hover text-decoration-none" href="<?php echo esc_url( (string) get_post_type_archive_link( 'sac_album' ) ); ?>"><?php esc_html_e( 'Gallery', 'sac' ); ?></a></li>
					<li class="mb-2"><a class="link-light link-opacity-75-hover text-decoration-none" href="<?php echo esc_url( (string) get_post_type_archive_link( 'sac_video' ) ); ?>"><?php esc_html_e( 'Videos', 'sac' ); ?></a></li>
					<?php if ( $broadcast_url = sac_broadcast_page_url() ) : ?>
						<li class="mb-2"><a class="link-light link-opacity-75-hover text-decoration-none" href="<?php echo esc_url( $broadcast_url ); ?>"><?php esc_html_e( 'Live Broadcast', 'sac' ); ?></a></li>
					<?php endif; ?>
					<li class="mb-2"><a class="link-light link-opacity-75-hover text-decoration-none" href="<?php echo esc_url( sac_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'sac' ); ?></a></li>
					<li><a class="link-light link-opacity-75-hover text-decoration-none" href="<?php echo esc_url( sac_page_url( 'donate' ) ); ?>"><?php esc_html_e( 'Donate', 'sac' ); ?></a></li>
				</ul>
			</div>

			<div class="col-lg-3">
				<h2 class="h6 text-uppercase text-primary tracking-wide mb-3"><?php esc_html_e( 'Gather With Us', 'sac' ); ?></h2>
				<?php if ( $service_time ) : ?>
					<p class="fw-semibold mb-1"><?php echo esc_html( $service_time ); ?></p>
				<?php endif; ?>
				<p class="text-white-50 mb-1"><?php echo esc_html( $location_name ); ?></p>
				<?php if ( $address ) : ?>
					<div class="text-white-50 small mb-3"><?php echo wp_kses_post( nl2br( esc_html( $address ) ) ); ?></div>
				<?php endif; ?>
				<a class="d-block link-light text-decoration-none mb-2" href="tel:<?php echo esc_attr( preg_replace( '/[^+0-9]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
				<a class="btn btn-outline-light btn-sm mt-2" href="<?php echo esc_url( sac_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Get in Touch', 'sac' ); ?></a>
				<ul class="sac-footer-socials list-unstyled d-flex flex-wrap gap-3 mt-4 mb-0">
					<?php foreach ( $socials as $network => $url ) : ?>
						<li><a class="link-light text-decoration-none" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $network ); ?><span class="visually-hidden"> <?php esc_html_e( '(opens in a new tab)', 'sac' ); ?></span></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>

	<div class="border-top border-light border-opacity-10">
		<div class="container py-4 d-flex flex-column flex-md-row justify-content-between gap-2 small text-white-50">
			<p class="mb-0">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php esc_html_e( 'Spirit Assembly Church', 'sac' ); ?></p>
			<?php if ( ! is_user_logged_in() ) : ?>
				<a class="link-light link-opacity-75-hover" href="<?php echo esc_url( wp_login_url() ); ?>"><?php esc_html_e( 'Log in', 'sac' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
