<?php
/**
 * Breadcrumb navigation.
 *
 * @package SAC
 */

$items = sac_breadcrumb_items();
if ( ! $items ) {
	return;
}

?>
<nav class="sac-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'sac' ); ?>">
	<ol class="container" role="list">
		<?php foreach ( $items as $index => $item ) : ?>
			<li>
				<?php if ( $index ) : ?><span class="sac-breadcrumb-divider" aria-hidden="true"></span><?php endif; ?>
				<?php if ( $item['url'] ) : ?>
					<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
				<?php else : ?>
					<span aria-current="page"><?php echo esc_html( $item['label'] ); ?></span>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>
</nav>
