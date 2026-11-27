<?php
/**
 * Site-wide seasonal appearance settings.
 *
 * @package SAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sac_christmas_snow_enabled(): bool {
	$settings = get_option( 'sac_christmas', array() );
	return ! empty( $settings['snow'] );
}

add_action(
	'admin_menu',
	static function (): void {
		add_submenu_page(
			'sac-settings',
			__( 'Seasonal Changes', 'sac' ),
			__( 'Seasonal Changes', 'sac' ),
			'manage_options',
			'sac-seasonal',
			'sac_render_seasonal_settings'
		);
	},
	20
);

add_action(
	'admin_init',
	static function (): void {
		register_setting(
			'sac_seasonal',
			'sac_christmas',
			array(
				'type'              => 'array',
				'sanitize_callback' => static function ( $value ): array {
					return array( 'snow' => in_array( $value['snow'] ?? null, array( true, 1, '1' ), true ) );
				},
			)
		);
	}
);

function sac_render_seasonal_settings(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Seasonal Changes', 'sac' ); ?></h1>
		<?php settings_errors(); ?>
		<form action="options.php" method="post">
			<?php settings_fields( 'sac_seasonal' ); ?>
			<fieldset>
				<legend><strong><?php esc_html_e( 'Christmas', 'sac' ); ?></strong></legend>
				<p><label>
					<input type="hidden" name="sac_christmas[snow]" value="0">
					<input type="checkbox" name="sac_christmas[snow]" value="1" <?php checked( sac_christmas_snow_enabled() ); ?>>
					<?php esc_html_e( 'Show snowfall across the site', 'sac' ); ?>
				</label></p>
			</fieldset>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

add_action(
	'wp_enqueue_scripts',
	static function (): void {
		if ( sac_christmas_snow_enabled() ) {
			wp_enqueue_style( 'sac-christmas', get_theme_file_uri( '/assets/css/christmas.css' ), array( 'sac-style' ), '1.0.6' );
		}
	},
	20
);

add_action(
	'wp_body_open',
	static function (): void {
		if ( sac_christmas_snow_enabled() ) {
			echo '<div id="sac-christmas-snow" class="sac-christmas-snow" aria-hidden="true"></div>';
		}
	}
);
