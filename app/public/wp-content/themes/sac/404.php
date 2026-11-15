<?php
/**
 * Not-found template.
 *
 * @package SAC
 */

get_header();
?>
<main id="primary" class="site-main bg-dark text-white">
	<div class="container min-vh-75 d-flex align-items-center py-5">
		<div class="row w-100 justify-content-center py-5">
			<div class="col-lg-8 text-center">
				<p class="display-1 text-primary fw-semibold mb-2">404</p>
				<h1 class="display-4 fw-semibold mb-3"><?php esc_html_e( 'Page not found', 'sac' ); ?></h1>
				<p class="lead text-white-75 mb-4"><?php esc_html_e( 'The page you requested does not exist or may have moved.', 'sac' ); ?></p>
				<a class="btn btn-primary btn-lg" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return Home', 'sac' ); ?></a>
			</div>
		</div>
	</div>
</main>
<?php
get_footer();
