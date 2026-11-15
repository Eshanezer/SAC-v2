<?php /** Header. */ ?><!doctype html>
<html <?php language_attributes(); ?>>
<head><meta charset="<?php bloginfo( 'charset' ); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class(); ?>><?php wp_body_open(); ?>
<a class="visually-hidden-focusable position-fixed top-0 start-0 z-3 btn btn-light m-2" href="#main"><?php esc_html_e( 'Skip to content', 'pastor-samson' ); ?></a>
<header class="ps-header">
	<nav class="navbar navbar-expand-lg py-3" aria-label="<?php esc_attr_e( 'Primary navigation', 'pastor-samson' ); ?>">
		<div class="container">
			<a class="ps-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?><small><?php esc_html_e( 'Faith · Leadership · Purpose', 'pastor-samson' ); ?></small></a>
			<button class="navbar-toggler ps-menu-button" type="button" data-bs-toggle="collapse" data-bs-target="#psNav" aria-controls="psNav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'pastor-samson' ); ?>"><span class="navbar-toggler-icon"></span></button>
			<div class="collapse navbar-collapse ps-nav" id="psNav">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'navbar-nav ms-auto align-items-lg-center gap-lg-2', 'fallback_cb' => 'ps_menu_fallback', 'depth' => 1 ) ); ?>
				<a class="btn btn-ps ms-lg-3" href="#contact"><?php esc_html_e( 'Invite to Speak', 'pastor-samson' ); ?></a>
			</div>
		</div>
	</nav>
</header>
