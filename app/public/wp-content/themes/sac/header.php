<?php
/**
 * Site header.
 *
 * @package SAC
 */

$front_page_id = sac_front_page_id();
$service_time  = (string) sac_field( 'sac_service_time', '', $front_page_id );
$premium_menu = sac_premium_menu_enabled();
$brand_name   = __( 'Spirit Assembly', 'sac' );
$brand_place  = __( 'Church Riga', 'sac' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="sac-skip-link visually-hidden-focusable position-fixed top-0 start-0 m-3 btn btn-light" href="#primary">
	<?php esc_html_e( 'Skip to content', 'sac' ); ?>
</a>

<header class="site-header sticky-top">
	<div class="sac-topbar bg-black text-white py-2">
		<div class="container d-flex align-items-center justify-content-between gap-3">
			<p class="mb-0 small text-uppercase fw-semibold tracking-wide">
				<?php esc_html_e( 'Spirit Assembly Church · Riga, Latvia', 'sac' ); ?>
				<?php if ( $service_time ) : ?>
					<span class="d-none d-md-inline text-primary"> · <?php echo esc_html( $service_time ); ?></span>
				<?php endif; ?>
			</p>
			<?php sac_language_switcher(); ?>
		</div>
	</div>

	<nav class="navbar <?php echo $premium_menu ? 'sac-navbar-premium' : 'navbar-expand-xl sac-navbar-classic'; ?> navbar-dark bg-dark py-3" aria-label="<?php esc_attr_e( 'Primary navigation', 'sac' ); ?>">
		<div class="container">
			<a class="navbar-brand d-flex align-items-center gap-3 me-4" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( $brand_name . ' ' . $brand_place ); ?>">
				<?php echo sac_brand_logo( 'navbar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span class="sac-brand-name">
					<strong class="d-block lh-1"><?php echo esc_html( $brand_name ); ?></strong>
					<small class="d-block text-primary text-uppercase mt-1"><?php echo esc_html( $brand_place ); ?></small>
				</span>
			</a>

			<button class="navbar-toggler sac-menu-toggle border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#sacPrimaryMenu" aria-controls="sacPrimaryMenu" aria-expanded="false">
				<span class="sac-menu-toggle-label"><?php esc_html_e( 'Menu', 'sac' ); ?></span>
				<span class="sac-menu-toggle-icon" aria-hidden="true"><i></i><i></i></span>
			</button>

			<div class="collapse navbar-collapse" id="sacPrimaryMenu">
				<?php if ( $premium_menu ) : ?>
				<div class="sac-menu-layout">
					<aside class="sac-menu-story" aria-hidden="true">
						<span class="sac-menu-story-mark">SAC</span>
						<div class="sac-menu-story-content">
							<span class="sac-menu-kicker"><?php esc_html_e( 'Spirit Assembly Church', 'sac' ); ?></span>
							<p><?php esc_html_e( 'A place to encounter God, discover purpose and find a family.', 'sac' ); ?></p>
							<span class="sac-menu-location"><?php esc_html_e( 'Riga, Latvia', 'sac' ); ?></span>
						</div>
					</aside>
					<div class="sac-menu-directory">
						<p class="sac-menu-heading"><?php esc_html_e( 'Explore Spirit Assembly', 'sac' ); ?></p>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container'      => false,
								'menu_class'     => 'navbar-nav ms-auto align-items-xl-center gap-xl-1',
								'fallback_cb'    => 'sac_primary_menu_fallback',
								'depth'          => 2,
							)
						);
						?>
						<div class="sac-menu-footer">
							<p><?php esc_html_e( 'Your first Sunday starts here.', 'sac' ); ?></p>
							<a class="btn btn-primary" href="<?php echo esc_url( sac_page_url( 'new-here' ) ); ?>">
								<?php esc_html_e( 'Plan a Visit', 'sac' ); ?> <span aria-hidden="true">&#8599;</span>
							</a>
						</div>
					</div>
				</div>
				<?php else : ?>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'navbar-nav ms-auto align-items-xl-center gap-xl-1',
							'fallback_cb'    => 'sac_primary_menu_fallback',
							'depth'          => 2,
						)
					);
					?>
					<a class="btn btn-primary sac-navbar-donate ms-xl-3 mt-3 mt-xl-0" href="<?php echo esc_url( sac_page_url( 'donate' ) ); ?>">
						<?php esc_html_e( 'Donate', 'sac' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</nav>
	<?php if ( sac_christmas_snow_enabled() ) : ?>
		<button type="button" class="sac-snow-control" aria-label="<?php esc_attr_e( 'Hide snowfall', 'sac' ); ?>" aria-controls="sac-christmas-snow" aria-pressed="false" hidden>
			<span class="sac-snow-control-icon" aria-hidden="true">&#10052;&#65038;</span>
		</button>
	<?php endif; ?>
</header>
<?php get_template_part( 'template-parts/broadcast-banner' ); ?>
<?php get_template_part( 'template-parts/breadcrumbs' ); ?>
