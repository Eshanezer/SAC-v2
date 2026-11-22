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

	// Contact Settings Section
	add_settings_section(
		'sac_contact_settings',
		__( 'Contact Information', 'sac' ),
		static function (): void {
			$contact_page = get_page_by_path( 'contact' );
			$edit_link    = $contact_page instanceof WP_Post ? get_edit_post_link( $contact_page->ID ) : '';
			echo '<p>' . esc_html__( 'Configure church contact details. These can also be edited directly on the Contact page in the Backend.', 'sac' );
			if ( $edit_link ) {
				echo ' <a href="' . esc_url( $edit_link ) . '">' . esc_html__( 'Edit Contact Page in BE &rarr;', 'sac' ) . '</a>';
			}
			echo '</p>';
		},
		'sac-settings'
	);

	register_setting( 'sac_settings', 'sac_contact_phone', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ) );
	register_setting( 'sac_settings', 'sac_contact_email', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_email' ) );

	add_settings_field(
		'sac_contact_phone',
		__( 'Church Phone', 'sac' ),
		static function (): void {
			$value = get_option( 'sac_contact_phone', '' );
			echo '<input class="regular-text" type="text" name="sac_contact_phone" value="' . esc_attr( (string) $value ) . '" placeholder="+371 22089000">';
		},
		'sac-settings',
		'sac_contact_settings'
	);

	add_settings_field(
		'sac_contact_email',
		__( 'Contact Email', 'sac' ),
		static function (): void {
			$value = get_option( 'sac_contact_email', '' );
			echo '<input class="regular-text" type="email" name="sac_contact_email" value="' . esc_attr( (string) $value ) . '" placeholder="info@spiritassemblychurch.com">';
			echo '<p class="description">' . esc_html__( 'Default recipient email for the contact page and public inquiries.', 'sac' ) . '</p>';
		},
		'sac-settings',
		'sac_contact_settings'
	);

	// Social Media Settings Section
	add_settings_section(
		'sac_social_settings',
		__( 'Social Media Links', 'sac' ),
		static function (): void {
			echo '<p>' . esc_html__( 'Configure church social media links shown in the header, footer, and contact section.', 'sac' ) . '</p>';
		},
		'sac-settings'
	);

	$networks = array(
		'facebook'  => array( __( 'Facebook URL', 'sac' ), 'https://bit.ly/3ek5Edk' ),
		'instagram' => array( __( 'Instagram URL', 'sac' ), 'https://bit.ly/2U32Daz' ),
		'youtube'   => array( __( 'YouTube URL', 'sac' ), 'https://bit.ly/3wEWzlL' ),
		'tiktok'    => array( __( 'TikTok URL', 'sac' ), 'https://bit.ly/42Taw2M' ),
	);

	foreach ( $networks as $network => $info ) {
		$opt_key = 'sac_social_' . $network;
		register_setting( 'sac_settings', $opt_key, array( 'type' => 'string', 'sanitize_callback' => 'esc_url_raw' ) );
		add_settings_field(
			$opt_key,
			$info[0],
			static function () use ( $opt_key, $info ): void {
				$value = get_option( $opt_key, '' );
				echo '<input class="regular-text" type="url" name="' . esc_attr( $opt_key ) . '" value="' . esc_attr( (string) $value ) . '" placeholder="' . esc_attr( $info[1] ) . '">';
			},
			'sac-settings',
			'sac_social_settings'
		);
	}
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
