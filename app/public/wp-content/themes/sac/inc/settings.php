<?php
/**
 * SAC theme settings.
 *
 * @package SAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the premium overlay navigation is enabled.
 */
function sac_premium_menu_enabled(): bool {
	return '1' === (string) get_option( 'sac_premium_menu_enabled', '1' );
}

/**
 * Register site-specific theme settings.
 */
function sac_register_theme_settings(): void {
	register_setting(
		'sac_settings',
		'sac_premium_menu_enabled',
		array(
			'type'              => 'boolean',
			'default'           => true,
			'sanitize_callback' => static fn( mixed $value ): int => empty( $value ) ? 0 : 1,
		)
	);

	add_settings_section(
		'sac_navigation_settings',
		__( 'Navigation', 'sac' ),
		static function (): void {
			echo '<p>' . esc_html__( 'Choose how the primary navigation appears on desktop. Mobile continues to use the compact menu.', 'sac' ) . '</p>';
		},
		'sac-settings'
	);

	add_settings_field(
		'sac_premium_menu_enabled',
		__( 'Premium menu', 'sac' ),
		'sac_render_premium_menu_setting',
		'sac-settings',
		'sac_navigation_settings'
	);
}
add_action( 'admin_init', 'sac_register_theme_settings' );

/**
 * Render the menu-style switch.
 */
function sac_render_premium_menu_setting(): void {
	?>
	<label for="sac_premium_menu_enabled">
		<input type="checkbox" id="sac_premium_menu_enabled" name="sac_premium_menu_enabled" value="1" <?php checked( sac_premium_menu_enabled() ); ?>>
		<?php esc_html_e( 'Use the current full-screen premium menu', 'sac' ); ?>
	</label>
	<p class="description">
		<?php esc_html_e( 'On: premium full-screen menu. Off: classic horizontal desktop navbar with a separate Donate button.', 'sac' ); ?>
	</p>
	<?php
}

/**
 * Add SAC Settings to the dashboard menu.
 */
function sac_add_settings_page(): void {
	add_menu_page(
		__( 'SAC Settings', 'sac' ),
		__( 'SAC Settings', 'sac' ),
		'manage_options',
		'sac-settings',
		'sac_render_settings_page',
		'dashicons-admin-customizer',
		61
	);
}
add_action( 'admin_menu', 'sac_add_settings_page' );

/**
 * Render the SAC Settings screen.
 */
function sac_render_settings_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'SAC Settings', 'sac' ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'sac_settings' );
			do_settings_sections( 'sac-settings' );
			submit_button( __( 'Save Settings', 'sac' ) );
			?>
		</form>
	</div>
	<?php
}
