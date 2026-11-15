<?php
/**
 * Shared interior page hero.
 *
 * @package SAC
 * @var array $args Hero configuration.
 */

$eyebrow = (string) ( $args['eyebrow'] ?? __( 'Spirit Assembly Church', 'sac' ) );
$title    = (string) ( $args['title'] ?? get_the_title() );
$intro    = (string) ( $args['intro'] ?? '' );
$image    = (string) ( $args['image'] ?? '' );
$style    = $image ? '--sac-page-image:url(' . esc_url_raw( $image ) . ');' : '';
?>
<header class="sac-page-hero text-white" style="<?php echo esc_attr( $style ); ?>">
	<div class="container position-relative py-5">
		<div class="row py-5">
			<div class="col-lg-9 col-xl-8 py-lg-4">
				<p class="sac-eyebrow text-primary mb-3"><?php echo esc_html( $eyebrow ); ?></p>
				<h1 class="display-2 fw-semibold mb-<?php echo $intro ? '3' : '0'; ?>"><?php echo esc_html( $title ); ?></h1>
				<?php if ( $intro ) : ?><div class="lead text-white-75 mb-0"><?php echo wp_kses_post( $intro ); ?></div><?php endif; ?>
			</div>
		</div>
	</div>
</header>
