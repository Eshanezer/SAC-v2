<?php
/**
 * ACF-driven homepage.
 *
 * @package SAC
 */

get_header();

$page_id            = sac_front_page_id();
$hero_eyebrow       = (string) sac_field( 'sac_hero_eyebrow', __( 'Spirit Assembly Church · Riga', 'sac' ), $page_id );
$hero_title         = (string) sac_field( 'sac_hero_title', __( 'Welcome home.', 'sac' ), $page_id );
$hero_text          = (string) sac_field( 'sac_hero_text', __( 'A church for Riga and the nations—worshipping Jesus, growing in faith, and building life-giving community.', 'sac' ), $page_id );
$hero_background    = sac_image_url( 'sac_hero_background', 'full', $page_id );

if ( ! $hero_background ) {
	$hero_background = get_theme_file_uri( '/assets/img/placeholders/worship-hero.jpg' );
}
$hero_primary       = sac_link(
	'sac_hero_primary_link',
	array(
		'url'    => sac_page_url( 'new-here' ),
		'title'  => __( 'Plan a Visit', 'sac' ),
		'target' => '_self',
	),
	$page_id
);
$hero_secondary     = sac_link(
	'sac_hero_secondary_link',
	array(
		'url'    => (string) get_post_type_archive_link( 'sac_sermon' ),
		'title'  => __( 'Watch Messages', 'sac' ),
		'target' => '_self',
	),
	$page_id
);
$welcome_title      = (string) sac_field( 'sac_welcome_title', __( 'A place to encounter God and find family.', 'sac' ), $page_id );
$welcome_text       = (string) sac_field( 'sac_welcome_text', '<p>' . __( 'Whatever your background or story, you are welcome to discover faith and community with us in Riga.', 'sac' ) . '</p>', $page_id );
$welcome_image      = sac_image_url( 'sac_welcome_image', 'large', $page_id );

if ( ! $welcome_image ) {
	$welcome_image = get_theme_file_uri( '/assets/img/placeholders/church-community.jpg' );
}
$visit_title        = (string) sac_field( 'sac_visit_title', __( 'Join us in Riga', 'sac' ), $page_id );
$visit_text         = (string) sac_field( 'sac_visit_text', __( 'Come as you are. Our team will be ready to welcome you and help you find your way.', 'sac' ), $page_id );
$service_time       = (string) sac_field( 'sac_service_time', __( 'Sunday gathering', 'sac' ), $page_id );
$service_note       = (string) sac_field( 'sac_service_note', __( 'Service time will be announced soon.', 'sac' ), $page_id );
$location_name      = (string) sac_field( 'sac_location_name', __( 'Riga, Latvia', 'sac' ), $page_id );
$location_address   = (string) sac_field( 'sac_location_address', '', $page_id );
$directions_link    = sac_link(
	'sac_directions_link',
	array(
		'url'    => sac_page_url( 'contact' ),
		'title'  => __( 'Plan Your Visit', 'sac' ),
		'target' => '_self',
	),
	$page_id
);
$livestream_link    = sac_link(
	'sac_livestream_link',
	array(
		'url'    => (string) get_post_type_archive_link( 'sac_sermon' ),
		'title'  => __( 'Watch Online', 'sac' ),
		'target' => '_self',
	),
	$page_id
);
$cta_title          = (string) sac_field( 'sac_cta_title', __( 'There is a place for you here.', 'sac' ), $page_id );
$cta_text           = (string) sac_field( 'sac_cta_text', __( 'Take your next step, ask a question, or let us know how we can pray with you.', 'sac' ), $page_id );
$cta_link           = sac_link(
	'sac_cta_link',
	array(
		'url'    => sac_page_url( 'contact' ),
		'title'  => __( 'Connect With Us', 'sac' ),
		'target' => '_self',
	),
	$page_id
);

$hero_style = $hero_background ? '--sac-hero-image:url(' . esc_url_raw( $hero_background ) . ');' : '';

$events_query = new WP_Query(
	array(
		'post_type'      => 'sac_event',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'meta_key'       => 'sac_event_start',
		'meta_value'     => current_time( 'mysql' ),
		'meta_compare'   => '>=',
		'meta_type'      => 'DATETIME',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
	)
);

$messages_query = new WP_Query(
	array(
		'post_type'      => 'sac_sermon',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);
?>
<main id="primary" class="site-main">
	<section class="sac-hero d-flex align-items-center text-white" style="<?php echo esc_attr( $hero_style ); ?>">
		<div class="container position-relative py-5">
			<div class="row min-vh-75 align-items-center py-5">
				<div class="col-lg-9 col-xl-8 py-lg-5">
					<p class="sac-eyebrow text-primary mb-3"><?php echo esc_html( $hero_eyebrow ); ?></p>
					<h1 class="display-1 fw-semibold mb-4"><?php echo esc_html( $hero_title ); ?></h1>
					<div class="lead text-white-75 mb-4 mb-lg-5 sac-hero-copy"><?php echo wp_kses_post( $hero_text ); ?></div>
					<div class="d-flex flex-column flex-sm-row gap-3">
						<a class="btn btn-primary btn-lg" href="<?php echo esc_url( $hero_primary['url'] ); ?>" target="<?php echo esc_attr( $hero_primary['target'] ); ?>"><?php echo esc_html( $hero_primary['title'] ); ?></a>
						<a class="btn btn-outline-light btn-lg" href="<?php echo esc_url( $hero_secondary['url'] ); ?>" target="<?php echo esc_attr( $hero_secondary['target'] ); ?>"><?php echo esc_html( $hero_secondary['title'] ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="sac-quick-links bg-primary text-dark" aria-label="<?php esc_attr_e( 'Quick links', 'sac' ); ?>">
		<div class="container">
			<div class="row g-0">
				<a class="col-md-4 sac-quick-link p-4 p-lg-5 text-dark text-decoration-none" href="<?php echo esc_url( sac_page_url( 'new-here' ) ); ?>">
					<span class="small text-uppercase fw-bold tracking-wide d-block mb-2"><?php esc_html_e( 'First time?', 'sac' ); ?></span>
					<strong class="h4 d-flex justify-content-between align-items-center mb-0"><?php esc_html_e( 'Plan your visit', 'sac' ); ?><span aria-hidden="true">→</span></strong>
				</a>
				<a class="col-md-4 sac-quick-link p-4 p-lg-5 text-dark text-decoration-none" href="<?php echo esc_url( (string) get_post_type_archive_link( 'sac_sermon' ) ); ?>">
					<span class="small text-uppercase fw-bold tracking-wide d-block mb-2"><?php esc_html_e( 'Be encouraged', 'sac' ); ?></span>
					<strong class="h4 d-flex justify-content-between align-items-center mb-0"><?php esc_html_e( 'Watch messages', 'sac' ); ?><span aria-hidden="true">→</span></strong>
				</a>
				<a class="col-md-4 sac-quick-link p-4 p-lg-5 text-dark text-decoration-none" href="<?php echo esc_url( sac_page_url( 'ministries' ) ); ?>">
					<span class="small text-uppercase fw-bold tracking-wide d-block mb-2"><?php esc_html_e( 'Find community', 'sac' ); ?></span>
					<strong class="h4 d-flex justify-content-between align-items-center mb-0"><?php esc_html_e( 'Get connected', 'sac' ); ?><span aria-hidden="true">→</span></strong>
				</a>
			</div>
		</div>
	</section>

	<section class="sac-section bg-body-tertiary">
		<div class="container py-5">
			<div class="row align-items-center g-5 py-lg-5">
				<div class="col-lg-6 order-2 order-lg-1">
					<div class="sac-media-frame ratio ratio-4x3 rounded-4 overflow-hidden shadow-lg">
						<?php if ( $welcome_image ) : ?>
							<img class="w-100 h-100 object-fit-cover" src="<?php echo esc_url( $welcome_image ); ?>" alt="<?php esc_attr_e( 'People sharing conversation and community after a church gathering', 'sac' ); ?>" loading="lazy" decoding="async">
						<?php else : ?>
							<div class="sac-riga-placeholder d-flex align-items-center justify-content-center">
								<span class="display-2 fw-semibold">RIGA</span>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1 order-1 order-lg-2">
					<p class="sac-eyebrow text-primary mb-3"><?php esc_html_e( 'Welcome', 'sac' ); ?></p>
					<h2 class="display-5 fw-semibold mb-4"><?php echo esc_html( $welcome_title ); ?></h2>
					<div class="sac-rich-text fs-5 text-body-secondary mb-4"><?php echo wp_kses_post( $welcome_text ); ?></div>
					<a class="btn btn-dark" href="<?php echo esc_url( sac_page_url( 'about' ) ); ?>"><?php esc_html_e( 'Discover Our Story', 'sac' ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<section class="sac-section sac-visit bg-dark text-white">
		<div class="container py-5">
			<div class="row align-items-center g-5 py-lg-5">
				<div class="col-lg-6">
					<p class="sac-eyebrow text-primary mb-3"><?php esc_html_e( 'This Sunday', 'sac' ); ?></p>
					<h2 class="display-4 fw-semibold mb-4"><?php echo esc_html( $visit_title ); ?></h2>
					<p class="lead text-white-75 mb-0"><?php echo wp_kses_post( $visit_text ); ?></p>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="card sac-visit-card border-0 rounded-4 shadow-lg">
						<div class="card-body p-4 p-lg-5">
							<p class="small text-uppercase fw-bold tracking-wide text-primary mb-2"><?php esc_html_e( 'Gathering', 'sac' ); ?></p>
							<h3 class="h2 mb-2"><?php echo esc_html( $service_time ); ?></h3>
							<p class="text-body-secondary mb-4"><?php echo esc_html( $service_note ); ?></p>
							<hr>
							<p class="fw-semibold mb-1"><?php echo esc_html( $location_name ); ?></p>
							<?php if ( $location_address ) : ?>
								<div class="text-body-secondary small mb-4"><?php echo wp_kses_post( nl2br( esc_html( $location_address ) ) ); ?></div>
							<?php endif; ?>
							<div class="d-flex flex-wrap gap-2 mt-4">
								<a class="btn btn-primary" href="<?php echo esc_url( $directions_link['url'] ); ?>" target="<?php echo esc_attr( $directions_link['target'] ); ?>"><?php echo esc_html( $directions_link['title'] ); ?></a>
								<a class="btn btn-outline-dark" href="<?php echo esc_url( $livestream_link['url'] ); ?>" target="<?php echo esc_attr( $livestream_link['target'] ); ?>"><?php echo esc_html( $livestream_link['title'] ); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="sac-section bg-white">
		<div class="container py-5">
			<div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-5 pt-lg-4">
				<div>
					<p class="sac-eyebrow text-primary mb-2"><?php esc_html_e( 'Church Life', 'sac' ); ?></p>
					<h2 class="display-5 fw-semibold mb-0"><?php esc_html_e( 'Upcoming events', 'sac' ); ?></h2>
				</div>
				<a class="btn btn-outline-dark" href="<?php echo esc_url( (string) get_post_type_archive_link( 'sac_event' ) ); ?>"><?php esc_html_e( 'See All Events', 'sac' ); ?></a>
			</div>

			<?php if ( $events_query->have_posts() ) : ?>
				<div class="row g-4 pb-lg-4">
					<?php while ( $events_query->have_posts() ) : ?>
						<?php $events_query->the_post(); ?>
						<div class="col-md-6 col-xl-4"><?php get_template_part( 'template-parts/card', 'event' ); ?></div>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
				<div class="sac-empty-state rounded-4 p-4 p-lg-5 mb-lg-4">
					<div class="row align-items-center g-4">
						<div class="col-lg-8">
							<h3 class="h3 mb-2"><?php esc_html_e( 'New events are coming soon.', 'sac' ); ?></h3>
							<p class="text-body-secondary mb-0"><?php esc_html_e( 'Check back for worship gatherings, conferences, and opportunities to connect.', 'sac' ); ?></p>
						</div>
						<div class="col-lg-4 text-lg-end">
							<a class="btn btn-dark" href="<?php echo esc_url( sac_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Stay Connected', 'sac' ); ?></a>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</section>

	<section class="sac-section bg-body-tertiary">
		<div class="container py-5">
			<div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-5 pt-lg-4">
				<div>
					<p class="sac-eyebrow text-primary mb-2"><?php esc_html_e( 'Grow in Faith', 'sac' ); ?></p>
					<h2 class="display-5 fw-semibold mb-0"><?php esc_html_e( 'Latest messages', 'sac' ); ?></h2>
				</div>
				<a class="btn btn-outline-dark" href="<?php echo esc_url( (string) get_post_type_archive_link( 'sac_sermon' ) ); ?>"><?php esc_html_e( 'Browse Messages', 'sac' ); ?></a>
			</div>

			<?php if ( $messages_query->have_posts() ) : ?>
				<div class="row g-4 pb-lg-4">
					<?php while ( $messages_query->have_posts() ) : ?>
						<?php $messages_query->the_post(); ?>
						<div class="col-md-6 col-xl-4"><?php get_template_part( 'template-parts/card', 'sermon' ); ?></div>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
				<div class="row g-4 pb-lg-4">
					<?php for ( $card = 1; $card <= 3; $card++ ) : ?>
						<div class="col-md-6 col-xl-4">
							<div class="card h-100 border-0 rounded-4 overflow-hidden sac-content-card">
								<div class="ratio ratio-16x9 sac-card-placeholder"></div>
								<div class="card-body p-4">
									<p class="small text-primary text-uppercase fw-bold tracking-wide mb-2"><?php esc_html_e( 'Message', 'sac' ); ?></p>
									<h3 class="h4 mb-2"><?php esc_html_e( 'Messages will be added soon', 'sac' ); ?></h3>
									<p class="text-body-secondary mb-0"><?php esc_html_e( 'Watch teaching from Spirit Assembly Church here.', 'sac' ); ?></p>
								</div>
							</div>
						</div>
					<?php endfor; ?>
				</div>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</section>

	<section class="sac-cta bg-primary text-dark">
		<div class="container py-5">
			<div class="row align-items-center g-4 py-lg-4">
				<div class="col-lg-8">
					<h2 class="display-5 fw-semibold mb-3"><?php echo esc_html( $cta_title ); ?></h2>
					<p class="lead mb-0"><?php echo wp_kses_post( $cta_text ); ?></p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a class="btn btn-dark btn-lg" href="<?php echo esc_url( $cta_link['url'] ); ?>" target="<?php echo esc_attr( $cta_link['target'] ); ?>"><?php echo esc_html( $cta_link['title'] ); ?></a>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
