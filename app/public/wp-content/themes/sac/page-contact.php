<?php
/**
 * Template Name: Contact Page
 * Template Post Type: page
 *
 * @package SAC
 */

get_header();

while ( have_posts() ) :
	the_post();

	$eyebrow       = (string) sac_field( 'sac_page_eyebrow', __( 'Connect with us', 'sac' ) );
	$intro         = (string) sac_field( 'sac_page_intro', __( 'We would love to hear from you, pray with you, and help you take your next step.', 'sac' ) );
	$phone         = (string) sac_contact_info( 'CONTACT_PHONE', 'sac_contact_phone', '+371 22089000' );
	$email         = (string) sac_contact_info( 'CONTACT_EMAIL', 'sac_contact_email', 'info@spiritassemblychurch.com' );
	$contact_title = (string) sac_field( 'sac_contact_title', __( 'Let’s start a conversation.', 'sac' ) );
	$contact_text  = (string) sac_field( 'sac_contact_text', __( 'Whether you have a question, need prayer, or want to know more about Spirit Assembly, our team is ready to connect.', 'sac' ) );
	$form_title    = (string) sac_field( 'sac_contact_form_title', __( 'Send us a message', 'sac' ) );
	$social_title  = (string) sac_field( 'sac_contact_social_title', __( 'Follow life at Spirit Assembly.', 'sac' ) );
	$social_text   = (string) sac_field( 'sac_contact_social_text', __( 'Stay connected through worship moments, messages, events, and stories from our church community.', 'sac' ) );
	$instagram_feed = trim( (string) sac_field( 'sac_instagram_feed_shortcode', '' ) );
	$facebook_feed  = trim( (string) sac_field( 'sac_facebook_feed_shortcode', '' ) );
	$socials       = array(
		'Facebook'  => (string) sac_contact_info( 'SOCIAL_FACEBOOK', 'sac_social_facebook', 'https://bit.ly/3ek5Edk' ),
		'Instagram' => (string) sac_contact_info( 'SOCIAL_INSTAGRAM', 'sac_social_instagram', 'https://bit.ly/2U32Daz' ),
		'YouTube'   => (string) sac_contact_info( 'SOCIAL_YOUTUBE', 'sac_social_youtube', 'https://bit.ly/3wEWzlL' ),
		'TikTok'    => (string) sac_contact_info( 'SOCIAL_TIKTOK', 'sac_social_tiktok', 'https://bit.ly/42Taw2M' ),
	);
	$status = sanitize_key( wp_unslash( $_GET['contact-status'] ?? '' ) );
	$notices = array(
		'success'  => array( 'success', __( 'Thank you. Your message has been sent successfully.', 'sac' ) ),
		'invalid'  => array( 'danger', __( 'Please enter your name, a valid email address, and a message.', 'sac' ) ),
		'failed'   => array( 'danger', __( 'We could not send your message. Please call or email us instead.', 'sac' ) ),
		'rate'     => array( 'warning', __( 'Please wait a moment before sending another message.', 'sac' ) ),
		'security' => array( 'danger', __( 'Your session expired. Please refresh the page and try again.', 'sac' ) ),
	);

	?>
	<main id="primary" class="site-main sac-contact-page">
	<?php
	get_template_part(
		'template-parts/page-hero',
		null,
		array( 'eyebrow' => $eyebrow, 'title' => get_the_title(), 'intro' => $intro )
	);
	?>
		<section class="sac-contact-section py-5">
			<div class="container py-lg-5">
				<div class="row g-5">
					<div class="col-lg-5">
						<p class="sac-eyebrow text-primary mb-3"><?php esc_html_e( 'You are welcome here', 'sac' ); ?></p>
						<h2 class="display-5 fw-semibold mb-4"><?php echo esc_html( $contact_title ); ?></h2>
						<p class="lead text-body-secondary mb-5"><?php echo esc_html( $contact_text ); ?></p>

						<div class="sac-contact-methods mb-5">
							<a class="sac-contact-method text-decoration-none" href="tel:<?php echo esc_attr( preg_replace( '/[^+0-9]/', '', $phone ) ); ?>"><span><?php esc_html_e( 'Call us', 'sac' ); ?></span><strong><?php echo esc_html( $phone ); ?></strong></a>
							<a class="sac-contact-method text-decoration-none" href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><span><?php esc_html_e( 'Email us', 'sac' ); ?></span><strong><?php echo esc_html( antispambot( $email ) ); ?></strong></a>
						</div>

						<h3 class="h6 text-uppercase text-primary tracking-wide mb-3"><?php esc_html_e( 'Follow Spirit Assembly', 'sac' ); ?></h3>
						<ul class="sac-social-links list-unstyled d-flex flex-wrap gap-2 mb-0">
							<?php foreach ( $socials as $network => $url ) : ?>
								<?php if ( $url ) : ?><li><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo sac_social_icon( $network ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $network ); ?></span><span class="visually-hidden"> <?php esc_html_e( '(opens in a new tab)', 'sac' ); ?></span></a></li><?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div>

					<div class="col-lg-6 offset-lg-1">
						<div id="contact-form" class="sac-contact-form-panel rounded-4 p-4 p-md-5">
							<p class="sac-eyebrow text-primary mb-3"><?php esc_html_e( 'Contact form', 'sac' ); ?></p>
							<h2 class="h1 mb-4"><?php echo esc_html( $form_title ); ?></h2>
							<?php if ( isset( $notices[ $status ] ) ) : ?><div class="alert alert-<?php echo esc_attr( $notices[ $status ][0] ); ?>" role="status" tabindex="-1"><?php echo esc_html( $notices[ $status ][1] ); ?></div><?php endif; ?>
							<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
								<input type="hidden" name="action" value="sac_contact">
								<?php wp_nonce_field( 'sac_contact_form', 'sac_contact_nonce' ); ?>
								<div class="sac-honeypot" aria-hidden="true"><label for="website">Website</label><input id="website" name="website" type="text" tabindex="-1" autocomplete="off"></div>
								<div class="row g-4">
									<div class="col-md-6"><label class="form-label" for="contact-name"><?php esc_html_e( 'Name', 'sac' ); ?> <span aria-hidden="true">*</span></label><input class="form-control" id="contact-name" name="contact_name" type="text" autocomplete="name" required></div>
									<div class="col-md-6"><label class="form-label" for="contact-email"><?php esc_html_e( 'Email', 'sac' ); ?> <span aria-hidden="true">*</span></label><input class="form-control" id="contact-email" name="contact_email" type="email" autocomplete="email" required></div>
									<div class="col-md-6"><label class="form-label" for="contact-phone"><?php esc_html_e( 'Phone', 'sac' ); ?></label><input class="form-control" id="contact-phone" name="contact_phone" type="tel" autocomplete="tel"></div>
									<div class="col-md-6"><label class="form-label" for="contact-subject"><?php esc_html_e( 'Subject', 'sac' ); ?></label><input class="form-control" id="contact-subject" name="contact_subject" type="text"></div>
									<div class="col-12"><label class="form-label" for="contact-message"><?php esc_html_e( 'How can we help?', 'sac' ); ?> <span aria-hidden="true">*</span></label><textarea class="form-control" id="contact-message" name="contact_message" rows="6" required></textarea></div>
									<div class="col-12 d-flex flex-column flex-sm-row align-items-sm-center gap-3"><button class="btn btn-primary btn-lg" type="submit"><?php esc_html_e( 'Send message', 'sac' ); ?></button><p class="small text-body-secondary mb-0"><?php esc_html_e( 'Required fields are marked with an asterisk.', 'sac' ); ?></p></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="sac-social-wall py-5" aria-labelledby="sac-social-wall-title">
			<div class="container py-lg-5">
				<div class="row align-items-end g-4 mb-5">
					<div class="col-lg-7"><p class="sac-eyebrow text-primary mb-3"><?php esc_html_e( 'Stay connected', 'sac' ); ?></p><h2 id="sac-social-wall-title" class="display-4 fw-semibold mb-0"><?php echo esc_html( $social_title ); ?></h2></div>
					<div class="col-lg-5"><p class="lead text-body-secondary mb-0"><?php echo esc_html( $social_text ); ?></p></div>
				</div>

				<?php if ( $instagram_feed || $facebook_feed ) : ?>
					<div class="sac-social-feed-grid">
						<?php if ( $instagram_feed ) : ?><div class="sac-social-feed-panel"><?php echo wp_kses_post( do_shortcode( $instagram_feed ) ); ?></div><?php endif; ?>
						<?php if ( $facebook_feed ) : ?><div class="sac-social-feed-panel"><?php echo wp_kses_post( do_shortcode( $facebook_feed ) ); ?></div><?php endif; ?>
					</div>
				<?php else : ?>
					<div class="sac-social-placeholder-grid">
						<?php foreach ( array_slice( $socials, 0, 4, true ) as $network => $url ) : ?>
							<a class="sac-social-placeholder text-decoration-none" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo sac_social_icon( $network ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><strong><?php echo esc_html( $network ); ?></strong><span><?php esc_html_e( 'View our latest updates', 'sac' ); ?></span><span class="visually-hidden"> <?php esc_html_e( '(opens in a new tab)', 'sac' ); ?></span></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	</main>
	<?php
endwhile;

get_footer();
