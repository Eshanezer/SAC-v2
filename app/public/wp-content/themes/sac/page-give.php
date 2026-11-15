<?php
/**
 * Template Name: Donate Page
 * Template Post Type: page
 *
 * Offering and donation page.
 *
 * @package SAC
 */

get_header();

while ( have_posts() ) :
	the_post();

	$eyebrow          = (string) sac_field( 'sac_give_eyebrow', __( 'Generosity', 'sac' ) );
	$title            = (string) sac_field( 'sac_give_title', __( 'Your generosity makes a difference.', 'sac' ) );
	$intro            = (string) sac_field( 'sac_give_intro', __( 'Your generosity helps Spirit Assembly share the Gospel, serve people, and build a life-giving church in Riga.', 'sac' ) );
	$online_title     = (string) sac_field( 'sac_give_online_title', __( 'Give online', 'sac' ) );
	$online_text      = (string) sac_field( 'sac_give_online_text', __( 'Give securely using Visa, Mastercard, Apple Pay, or Google Pay.', 'sac' ) );
	$card_url         = (string) sac_field( 'sac_give_card_url', 'https://www.bit.ly/donate_spiritassembly' );
	$paypal_url       = (string) sac_field( 'sac_give_paypal_url', 'https://www.paypal.me/SpiritAssemblyRiga' );
	$bank_title       = (string) sac_field( 'sac_give_bank_title', __( 'Give by bank transfer', 'sac' ) );
	$bank_text        = (string) sac_field( 'sac_give_bank_text', __( 'Use the details below and include “Offering” as the payment reference.', 'sac' ) );
	$beneficiary      = (string) sac_field( 'sac_give_beneficiary', 'SPIRIT ASSEMBLY INTERNATIONAL MINISTRIES' );
	$swedbank_name    = (string) sac_field( 'sac_give_swedbank_beneficiary', 'SPIRIT ASSEMBLY INTERNATIONAL MINISTRIES RĪGAS EVAŅĢĒLISKĀS TICĪBAS KRISTIEŠU DRAUDZE' );
	$iban             = (string) sac_field( 'sac_give_iban', 'LV34HABA0551051092215' );
	$registration     = (string) sac_field( 'sac_give_registration', '50801052801' );
	$swift            = (string) sac_field( 'sac_give_swift', 'HABALV22' );
	$bank_address     = (string) sac_field( 'sac_give_bank_address', 'Balasta dambis 15, Rīga, LV-1048' );
	$payment_details  = (string) sac_field( 'sac_give_payment_details', __( 'Offering', 'sac' ) );
	$impact_eyebrow   = (string) sac_field( 'sac_give_impact_eyebrow', __( 'Your giving at work', 'sac' ) );
	$impact_title     = (string) sac_field( 'sac_give_impact_title', __( 'Together, we are building God’s house.', 'sac' ) );
	$impact_intro     = (string) sac_field( 'sac_give_impact_intro', __( 'Every donation helps us create space for people to encounter Jesus and experience genuine community.', 'sac' ) );
	$impact_items     = array(
		array( 'title' => (string) sac_field( 'sac_give_impact_one_title', __( 'Reach people', 'sac' ) ), 'text' => (string) sac_field( 'sac_give_impact_one_text', __( 'Share the Gospel and welcome people who are searching for hope in Riga and beyond.', 'sac' ) ) ),
		array( 'title' => (string) sac_field( 'sac_give_impact_two_title', __( 'Build community', 'sac' ) ), 'text' => (string) sac_field( 'sac_give_impact_two_text', __( 'Create life-giving gatherings, discipleship, prayer, and care for people of every generation.', 'sac' ) ) ),
		array( 'title' => (string) sac_field( 'sac_give_impact_three_title', __( 'Equip purpose', 'sac' ) ), 'text' => (string) sac_field( 'sac_give_impact_three_text', __( 'Help believers mature in faith and fulfil their God-given calling with integrity and excellence.', 'sac' ) ) ),
	);
	$verse_eyebrow    = (string) sac_field( 'sac_give_verse_eyebrow', __( 'A heart of generosity', 'sac' ) );
	$verse_text       = (string) sac_field( 'sac_give_verse_text', __( 'Each of you should give what you have decided in your heart to give… for God loves a cheerful giver.', 'sac' ) );
	$verse_reference  = (string) sac_field( 'sac_give_verse_reference', __( '2 Corinthians 9:7', 'sac' ) );
	$verse_note       = (string) sac_field( 'sac_give_verse_note', __( 'Giving is an act of worship. We give freely and joyfully in response to God’s goodness—not from pressure, but from faith.', 'sac' ) );
	$stewardship_title = (string) sac_field( 'sac_give_stewardship_title', __( 'Giving with confidence', 'sac' ) );
	$stewardship_text  = (string) sac_field( 'sac_give_stewardship_text', __( 'We value integrity and faithful stewardship. Your offering supports the ministry and mission of Spirit Assembly International Ministries.', 'sac' ) );
	$closing_title    = (string) sac_field( 'sac_give_closing_title', __( 'Thank you for your generosity.', 'sac' ) );
	$closing_text     = (string) sac_field( 'sac_give_closing_text', __( 'Every gift helps us continue the work God has entrusted to Spirit Assembly.', 'sac' ) );
	?>
	<main id="primary" class="site-main sac-give-page">
		<header class="sac-give-hero">
			<div class="container py-5">
				<div class="row justify-content-center py-lg-5 text-center">
					<div class="col-lg-9 col-xl-8">
						<p class="sac-eyebrow text-primary mb-3"><?php echo esc_html( $eyebrow ); ?></p>
						<h1 class="display-2 fw-semibold mb-4"><?php echo esc_html( $title ); ?></h1>
						<p class="lead mb-0 mx-auto"><?php echo esc_html( $intro ); ?></p>
					</div>
				</div>
			</div>
		</header>

		<section class="sac-give-impact py-5" aria-labelledby="give-impact-title">
			<div class="container py-lg-5">
				<div class="row justify-content-between align-items-end g-4 mb-5">
					<div class="col-lg-7">
						<p class="sac-eyebrow text-primary mb-3"><?php echo esc_html( $impact_eyebrow ); ?></p>
						<h2 id="give-impact-title" class="display-4 fw-semibold mb-0"><?php echo esc_html( $impact_title ); ?></h2>
					</div>
					<div class="col-lg-5"><p class="lead mb-0"><?php echo esc_html( $impact_intro ); ?></p></div>
				</div>
				<div class="row g-4">
					<?php foreach ( $impact_items as $index => $impact ) : ?>
						<div class="col-md-4">
							<article class="sac-impact-card h-100 rounded-4 p-4 p-xl-5">
								<span class="sac-impact-icon mb-4" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
								<h3 class="h3 mb-3"><?php echo esc_html( $impact['title'] ); ?></h3>
								<p class="mb-0"><?php echo esc_html( $impact['text'] ); ?></p>
							</article>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="sac-give-scripture py-5" aria-labelledby="give-scripture-title">
			<div class="container py-lg-5">
				<div class="sac-scripture-panel position-relative overflow-hidden rounded-4">
					<div class="row g-0 align-items-stretch">
						<div class="col-lg-8">
							<figure class="sac-scripture-quote h-100 mb-0 p-4 p-md-5 p-xl-6">
								<span class="sac-quote-mark" aria-hidden="true">“</span>
								<p class="sac-eyebrow text-primary mb-4"><?php echo esc_html( $verse_eyebrow ); ?></p>
								<blockquote id="give-scripture-title" class="display-5 fw-semibold mb-4"><?php echo esc_html( $verse_text ); ?></blockquote>
								<figcaption class="sac-scripture-reference"><?php echo esc_html( $verse_reference ); ?></figcaption>
							</figure>
						</div>
						<div class="col-lg-4">
							<div class="sac-scripture-note h-100 p-4 p-md-5 d-flex flex-column justify-content-end">
								<span class="sac-scripture-line mb-4" aria-hidden="true"></span>
								<h2 class="h3 mb-3"><?php esc_html_e( 'Why we give', 'sac' ); ?></h2>
								<p class="mb-0"><?php echo esc_html( $verse_note ); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="container py-5" aria-labelledby="give-online-title">
			<div class="row align-items-stretch g-4 py-lg-4">
				<div class="col-lg-5">
					<div class="sac-give-intro h-100 p-4 p-md-5 rounded-4">
						<p class="sac-eyebrow text-primary mb-3"><?php esc_html_e( 'Simple and secure', 'sac' ); ?></p>
						<h2 id="give-online-title" class="display-5 fw-semibold mb-3"><?php echo esc_html( $online_title ); ?></h2>
						<p class="mb-4"><?php echo esc_html( $online_text ); ?></p>
						<p class="small text-uppercase fw-bold text-primary mb-0"><?php esc_html_e( 'Visa · Mastercard · Apple Pay · Google Pay', 'sac' ); ?></p>
					</div>
				</div>
				<div class="col-lg-7">
					<div class="row g-4 h-100">
						<div class="col-md-6">
							<div class="sac-give-method h-100 p-4 p-xl-5 rounded-4 d-flex flex-column">
								<span class="sac-give-method-number mb-4">01</span>
								<h3 class="h3 mb-3"><?php esc_html_e( 'Card & digital wallet', 'sac' ); ?></h3>
								<p class="mb-4"><?php esc_html_e( 'Give through our secure online donation page.', 'sac' ); ?></p>
								<a class="btn btn-primary mt-auto align-self-start" href="<?php echo esc_url( $card_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Give online', 'sac' ); ?></a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="sac-give-method h-100 p-4 p-xl-5 rounded-4 d-flex flex-column">
								<span class="sac-give-method-number mb-4">02</span>
								<h3 class="h3 mb-3">PayPal</h3>
								<p class="mb-4"><?php esc_html_e( 'Give using your PayPal account or a supported payment method.', 'sac' ); ?></p>
								<a class="btn btn-outline-primary mt-auto align-self-start" href="<?php echo esc_url( $paypal_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Give with PayPal', 'sac' ); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="sac-stewardship py-5">
			<div class="container py-lg-4">
				<div class="sac-stewardship-panel rounded-4 p-4 p-md-5 d-flex flex-column flex-lg-row align-items-lg-center gap-4 gap-lg-5">
					<span class="sac-stewardship-mark" aria-hidden="true">✓</span>
					<div><p class="sac-eyebrow text-primary mb-2"><?php esc_html_e( 'Faithful stewardship', 'sac' ); ?></p><h2 class="h2 mb-3"><?php echo esc_html( $stewardship_title ); ?></h2><p class="mb-0"><?php echo esc_html( $stewardship_text ); ?></p></div>
				</div>
			</div>
		</section>

		<section class="sac-give-bank py-5" aria-labelledby="give-bank-title">
			<div class="container py-lg-5">
				<div class="row g-5">
					<div class="col-lg-4">
						<p class="sac-eyebrow text-primary mb-3"><?php esc_html_e( 'Bank details', 'sac' ); ?></p>
						<h2 id="give-bank-title" class="display-5 fw-semibold mb-3"><?php echo esc_html( $bank_title ); ?></h2>
						<p class="mb-0"><?php echo esc_html( $bank_text ); ?></p>
					</div>
					<div class="col-lg-8">
						<div class="sac-bank-card bg-white rounded-4 p-4 p-md-5">
							<dl class="row mb-0 g-0">
								<dt class="col-md-4"><?php esc_html_e( 'Beneficiary', 'sac' ); ?></dt><dd class="col-md-8"><?php echo esc_html( $beneficiary ); ?></dd>
								<dt class="col-md-4"><?php esc_html_e( 'SWEDBANK beneficiary', 'sac' ); ?></dt><dd class="col-md-8"><?php echo esc_html( $swedbank_name ); ?></dd>
								<dt class="col-md-4">IBAN</dt><dd class="col-md-8 sac-bank-code"><?php echo esc_html( $iban ); ?></dd>
								<dt class="col-md-4"><?php esc_html_e( 'Registration number', 'sac' ); ?></dt><dd class="col-md-8 sac-bank-code"><?php echo esc_html( $registration ); ?></dd>
								<dt class="col-md-4"><?php esc_html_e( 'SWIFT code', 'sac' ); ?></dt><dd class="col-md-8 sac-bank-code"><?php echo esc_html( $swift ); ?></dd>
								<dt class="col-md-4"><?php esc_html_e( 'Bank address', 'sac' ); ?></dt><dd class="col-md-8"><?php echo esc_html( $bank_address ); ?></dd>
								<dt class="col-md-4"><?php esc_html_e( 'Payment details', 'sac' ); ?></dt><dd class="col-md-8 mb-0"><span class="sac-payment-reference"><?php echo esc_html( $payment_details ); ?></span></dd>
							</dl>
						</div>
					</div>
				</div>
			</div>
		</section>

		<?php if ( trim( (string) get_the_content() ) ) : ?>
			<article class="container py-5"><div class="row justify-content-center"><div class="col-lg-9 col-xl-8 sac-entry-content"><?php the_content(); ?></div></div></article>
		<?php endif; ?>

		<section class="sac-give-thanks text-center py-5">
			<div class="container py-lg-4">
				<h2 class="display-5 fw-semibold mb-3"><?php echo esc_html( $closing_title ); ?></h2>
				<p class="lead mb-0 mx-auto"><?php echo esc_html( $closing_text ); ?></p>
			</div>
		</section>
	</main>
	<?php
endwhile;

get_footer();
