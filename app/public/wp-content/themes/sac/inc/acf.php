<?php
/**
 * ACF field definitions.
 *
 * Field groups live in code so environments remain synchronized. Translation
 * preferences follow ACF Multilingual's recommendations: content is translated,
 * while images, dates, and media URLs are copied.
 *
 * @package SAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register SAC field groups.
 */
function sac_register_acf_fields(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$give_page_locations = array(
		array(
			array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-give.php' ),
		),
		array(
			array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-donate.php' ),
		),
	);
	$give_page = get_page_by_path( 'donate' );

	if ( ! $give_page instanceof WP_Post ) {
		$give_page = get_page_by_path( 'give' );
	}

	if ( $give_page instanceof WP_Post ) {
		$give_page_locations[] = array(
			array( 'param' => 'page', 'operator' => '==', 'value' => (string) $give_page->ID ),
		);
	}

	$about_page_locations = array(
		array(
			array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php' ),
		),
	);
	$about_page = get_page_by_path( 'about' );

	if ( $about_page instanceof WP_Post ) {
		$about_page_locations[] = array(
			array( 'param' => 'page', 'operator' => '==', 'value' => (string) $about_page->ID ),
		);
	}

	$contact_page_locations = array(
		array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-contact.php' ) ),
	);
	$contact_page = get_page_by_path( 'contact' );

	if ( $contact_page instanceof WP_Post ) {
		$contact_page_locations[] = array( array( 'param' => 'page', 'operator' => '==', 'value' => (string) $contact_page->ID ) );
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_sac_homepage',
			'title'  => __( 'Homepage Content', 'sac' ),
			'fields' => array(
				array(
					'key'       => 'field_sac_home_hero_tab',
					'label'     => __( 'Hero', 'sac' ),
					'name'      => '',
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'                 => 'field_sac_hero_eyebrow',
					'label'               => __( 'Eyebrow', 'sac' ),
					'name'                => 'sac_hero_eyebrow',
					'type'                => 'text',
					'default_value'       => __( 'Spirit Assembly Church · Riga', 'sac' ),
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_hero_title',
					'label'               => __( 'Title', 'sac' ),
					'name'                => 'sac_hero_title',
					'type'                => 'text',
					'default_value'       => __( 'Welcome home.', 'sac' ),
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_hero_text',
					'label'               => __( 'Introduction', 'sac' ),
					'name'                => 'sac_hero_text',
					'type'                => 'textarea',
					'rows'                => 3,
					'new_lines'           => 'br',
					'default_value'       => __( 'A church for Riga and the nations—worshipping Jesus, growing in faith, and building life-giving community.', 'sac' ),
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_hero_background',
					'label'               => __( 'Background Image', 'sac' ),
					'name'                => 'sac_hero_background',
					'type'                => 'image',
					'return_format'       => 'id',
					'preview_size'        => 'large',
					'library'             => 'all',
					'wpml_cf_preferences' => 1,
				),
				array(
					'key'                 => 'field_sac_hero_primary_link',
					'label'               => __( 'Primary Button', 'sac' ),
					'name'                => 'sac_hero_primary_link',
					'type'                => 'link',
					'return_format'       => 'array',
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_hero_secondary_link',
					'label'               => __( 'Secondary Button', 'sac' ),
					'name'                => 'sac_hero_secondary_link',
					'type'                => 'link',
					'return_format'       => 'array',
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'       => 'field_sac_home_welcome_tab',
					'label'     => __( 'Welcome', 'sac' ),
					'name'      => '',
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'                 => 'field_sac_welcome_title',
					'label'               => __( 'Heading', 'sac' ),
					'name'                => 'sac_welcome_title',
					'type'                => 'text',
					'default_value'       => __( 'A place to encounter God and find family.', 'sac' ),
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_welcome_text',
					'label'               => __( 'Text', 'sac' ),
					'name'                => 'sac_welcome_text',
					'type'                => 'wysiwyg',
					'tabs'                => 'all',
					'toolbar'             => 'basic',
					'media_upload'        => 0,
					'default_value'       => '<p>' . __( 'Whatever your background or story, you are welcome to discover faith and community with us in Riga.', 'sac' ) . '</p>',
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_welcome_image',
					'label'               => __( 'Image', 'sac' ),
					'name'                => 'sac_welcome_image',
					'type'                => 'image',
					'return_format'       => 'id',
					'preview_size'        => 'large',
					'library'             => 'all',
					'wpml_cf_preferences' => 1,
				),
				array(
					'key'       => 'field_sac_home_visit_tab',
					'label'     => __( 'Visit Information', 'sac' ),
					'name'      => '',
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'                 => 'field_sac_visit_title',
					'label'               => __( 'Heading', 'sac' ),
					'name'                => 'sac_visit_title',
					'type'                => 'text',
					'default_value'       => __( 'Join us in Riga', 'sac' ),
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_visit_text',
					'label'               => __( 'Introduction', 'sac' ),
					'name'                => 'sac_visit_text',
					'type'                => 'textarea',
					'rows'                => 3,
					'new_lines'           => 'br',
					'default_value'       => __( 'Come as you are. Our team will be ready to welcome you and help you find your way.', 'sac' ),
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_service_time',
					'label'               => __( 'Main Service Time', 'sac' ),
					'name'                => 'sac_service_time',
					'type'                => 'text',
					'placeholder'         => __( 'Sunday · 11:00', 'sac' ),
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_service_note',
					'label'               => __( 'Service Note', 'sac' ),
					'name'                => 'sac_service_note',
					'type'                => 'text',
					'placeholder'         => __( 'Worship, message, prayer, and kids programme', 'sac' ),
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_location_name',
					'label'               => __( 'Location Name', 'sac' ),
					'name'                => 'sac_location_name',
					'type'                => 'text',
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_location_address',
					'label'               => __( 'Address', 'sac' ),
					'name'                => 'sac_location_address',
					'type'                => 'textarea',
					'rows'                => 2,
					'new_lines'           => 'br',
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_directions_link',
					'label'               => __( 'Directions Button', 'sac' ),
					'name'                => 'sac_directions_link',
					'type'                => 'link',
					'return_format'       => 'array',
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_livestream_link',
					'label'               => __( 'Livestream Button', 'sac' ),
					'name'                => 'sac_livestream_link',
					'type'                => 'link',
					'return_format'       => 'array',
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'       => 'field_sac_home_cta_tab',
					'label'     => __( 'Closing Call to Action', 'sac' ),
					'name'      => '',
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'                 => 'field_sac_cta_title',
					'label'               => __( 'Heading', 'sac' ),
					'name'                => 'sac_cta_title',
					'type'                => 'text',
					'default_value'       => __( 'There is a place for you here.', 'sac' ),
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_cta_text',
					'label'               => __( 'Text', 'sac' ),
					'name'                => 'sac_cta_text',
					'type'                => 'textarea',
					'rows'                => 3,
					'new_lines'           => 'br',
					'default_value'       => __( 'Take your next step, ask a question, or let us know how we can pray with you.', 'sac' ),
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_cta_link',
					'label'               => __( 'Button', 'sac' ),
					'name'                => 'sac_cta_link',
					'type'                => 'link',
					'return_format'       => 'array',
					'wpml_cf_preferences' => 2,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
			'position'       => 'normal',
			'style'          => 'seamless',
			'label_placement'=> 'top',
			'hide_on_screen' => array( 'the_content', 'discussion', 'comments' ),
		)
	);

	acf_add_local_field_group(
		array(
			'key'    => 'group_sac_page_header',
			'title'  => __( 'Page Header', 'sac' ),
			'fields' => array(
				array(
					'key'                 => 'field_sac_page_eyebrow',
					'label'               => __( 'Eyebrow', 'sac' ),
					'name'                => 'sac_page_eyebrow',
					'type'                => 'text',
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_page_intro',
					'label'               => __( 'Introduction', 'sac' ),
					'name'                => 'sac_page_intro',
					'type'                => 'textarea',
					'rows'                => 3,
					'new_lines'           => 'br',
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_page_image',
					'label'               => __( 'Header Image', 'sac' ),
					'name'                => 'sac_page_image',
					'type'                => 'image',
					'return_format'       => 'id',
					'preview_size'        => 'large',
					'wpml_cf_preferences' => 1,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'page',
					),
					array(
						'param'    => 'page_type',
						'operator' => '!=',
						'value'    => 'front_page',
					),
				),
			),
			'position' => 'normal',
			'style'    => 'default',
		)
	);

	acf_add_local_field_group(
		array(
			'key'    => 'group_sac_contact_page',
			'title'  => __( 'Contact Page Content', 'sac' ),
			'fields' => array(
				array( 'key' => 'field_sac_contact_intro_tab', 'label' => __( 'Contact Introduction', 'sac' ), 'name' => '', 'type' => 'tab' ),
				array( 'key' => 'field_sac_contact_title', 'label' => __( 'Heading', 'sac' ), 'name' => 'sac_contact_title', 'type' => 'text', 'default_value' => __( 'Let’s start a conversation.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_contact_text', 'label' => __( 'Text', 'sac' ), 'name' => 'sac_contact_text', 'type' => 'textarea', 'rows' => 4, 'default_value' => __( 'Whether you have a question, need prayer, or want to know more about Spirit Assembly, our team is ready to connect.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_contact_form_title', 'label' => __( 'Form Heading', 'sac' ), 'name' => 'sac_contact_form_title', 'type' => 'text', 'default_value' => __( 'Send us a message', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_contact_details_tab', 'label' => __( 'Contact Details', 'sac' ), 'name' => '', 'type' => 'tab' ),
				array( 'key' => 'field_sac_contact_phone', 'label' => __( 'Church Phone', 'sac' ), 'name' => 'sac_contact_phone', 'type' => 'text', 'default_value' => '+371 22089000', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_contact_email', 'label' => __( 'Recipient Email', 'sac' ), 'name' => 'sac_contact_email', 'type' => 'email', 'default_value' => 'info@spiritassemblychurch.com', 'instructions' => __( 'Contact form messages will be sent here.', 'sac' ), 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_contact_social_tab', 'label' => __( 'Social Media', 'sac' ), 'name' => '', 'type' => 'tab' ),
				array( 'key' => 'field_sac_social_facebook', 'label' => 'Facebook', 'name' => 'sac_social_facebook', 'type' => 'url', 'default_value' => 'https://bit.ly/3ek5Edk', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_social_instagram', 'label' => 'Instagram', 'name' => 'sac_social_instagram', 'type' => 'url', 'default_value' => 'https://bit.ly/2U32Daz', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_social_youtube', 'label' => 'YouTube', 'name' => 'sac_social_youtube', 'type' => 'url', 'default_value' => 'https://bit.ly/3wEWzlL', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_social_tiktok', 'label' => 'TikTok', 'name' => 'sac_social_tiktok', 'type' => 'url', 'default_value' => 'https://bit.ly/42Taw2M', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_contact_social_title', 'label' => __( 'Social Wall Heading', 'sac' ), 'name' => 'sac_contact_social_title', 'type' => 'text', 'default_value' => __( 'Follow life at Spirit Assembly.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_contact_social_text', 'label' => __( 'Social Wall Introduction', 'sac' ), 'name' => 'sac_contact_social_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => __( 'Stay connected through worship moments, messages, events, and stories from our church community.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_contact_feeds_tab', 'label' => __( 'Connected Social Feeds', 'sac' ), 'name' => '', 'type' => 'tab' ),
				array( 'key' => 'field_sac_social_feed_help', 'label' => __( 'How feeds work', 'sac' ), 'name' => '', 'type' => 'message', 'message' => __( 'Connect an Instagram or Facebook feed plugin, then paste its shortcode below. The frontend automatically replaces the social cards with the connected gallery or wall.', 'sac' ) ),
				array( 'key' => 'field_sac_instagram_feed_shortcode', 'label' => __( 'Instagram Feed Shortcode', 'sac' ), 'name' => 'sac_instagram_feed_shortcode', 'type' => 'text', 'placeholder' => '[instagram-feed feed=1]', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_facebook_feed_shortcode', 'label' => __( 'Facebook Feed Shortcode', 'sac' ), 'name' => 'sac_facebook_feed_shortcode', 'type' => 'text', 'placeholder' => '[facebook-feed feed=1]', 'wpml_cf_preferences' => 1 ),
			),
			'location' => $contact_page_locations,
			'position' => 'normal',
			'style' => 'seamless',
			'hide_on_screen' => array( 'discussion', 'comments' ),
		)
	);

	acf_add_local_field_group(
		array(
			'key'    => 'group_sac_church_vision',
			'title'  => __( 'Church Vision', 'sac' ),
			'fields' => array(
				array( 'key' => 'field_sac_about_images_tab', 'label' => __( 'About Images', 'sac' ), 'name' => '', 'type' => 'tab' ),
				array( 'key' => 'field_sac_about_story_image', 'label' => __( 'Story Image', 'sac' ), 'name' => 'sac_about_story_image', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'large', 'library' => 'all', 'instructions' => __( 'Used beside the “Faith lived together” content.', 'sac' ), 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_about_gallery', 'label' => __( 'Photo Gallery', 'sac' ), 'name' => 'sac_about_gallery', 'type' => 'gallery', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'insert' => 'append', 'instructions' => __( 'Add any number of images. The frontend grid adjusts automatically.', 'sac' ), 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_about_gallery_eyebrow', 'label' => __( 'Gallery Eyebrow', 'sac' ), 'name' => 'sac_about_gallery_eyebrow', 'type' => 'text', 'default_value' => __( 'Life together', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_about_gallery_title', 'label' => __( 'Gallery Heading', 'sac' ), 'name' => 'sac_about_gallery_title', 'type' => 'text', 'default_value' => __( 'Moments of faith, connection, and purpose.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_about_gallery_intro', 'label' => __( 'Gallery Introduction', 'sac' ), 'name' => 'sac_about_gallery_intro', 'type' => 'textarea', 'rows' => 3, 'default_value' => __( 'Church life is made of shared moments—worship, friendship, prayer, service, and growing together.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_about_vision_tab', 'label' => __( 'Church Vision', 'sac' ), 'name' => '', 'type' => 'tab' ),
				array( 'key' => 'field_sac_vision_eyebrow', 'label' => __( 'Eyebrow', 'sac' ), 'name' => 'sac_vision_eyebrow', 'type' => 'text', 'default_value' => __( 'Why we are here', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_vision_title', 'label' => __( 'Section Title', 'sac' ), 'name' => 'sac_vision_title', 'type' => 'text', 'default_value' => __( 'Church vision', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_vision_intro', 'label' => __( 'Introduction', 'sac' ), 'name' => 'sac_vision_intro', 'type' => 'textarea', 'rows' => 3, 'default_value' => __( 'Our vision is to reveal God’s love and power, build mature believers, and equip every generation to fulfil their calling.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_vision_item_one', 'label' => __( 'Vision Point 1', 'sac' ), 'name' => 'sac_vision_item_one', 'type' => 'textarea', 'rows' => 6, 'default_value' => 'To establish God’s kingdom on Earth through reaching to the lost souls and demonstrating the reality of the love and power of God through Miracles, Signs and Wonders; bringing healing, deliverance, and transformation to men.', 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_vision_item_two', 'label' => __( 'Vision Point 2', 'sac' ), 'name' => 'sac_vision_item_two', 'type' => 'textarea', 'rows' => 5, 'default_value' => 'To bring the body of Christ into the revelatory and balanced truth of God’s Word until we all come to maturity and unity in the Faith.', 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_vision_item_three', 'label' => __( 'Vision Point 3', 'sac' ), 'name' => 'sac_vision_item_three', 'type' => 'textarea', 'rows' => 6, 'default_value' => 'To help the individual (both young and old) in the Body of Christ understand and fulfill their God-given purpose in the society, governance and the marketplace with integrity, professionalism and God’s anointing.', 'wpml_cf_preferences' => 2 ),
			),
			'location' => $about_page_locations,
			'position' => 'normal',
			'style' => 'seamless',
			'hide_on_screen' => array( 'discussion', 'comments' ),
		)
	);

	acf_add_local_field_group(
		array(
			'key'    => 'group_sac_give_page',
			'title'  => __( 'Giving Page Content', 'sac' ),
			'fields' => array(
				array( 'key' => 'field_sac_give_hero_tab', 'label' => __( 'Page Introduction', 'sac' ), 'name' => '', 'type' => 'tab' ),
				array( 'key' => 'field_sac_give_eyebrow', 'label' => __( 'Eyebrow', 'sac' ), 'name' => 'sac_give_eyebrow', 'type' => 'text', 'default_value' => __( 'Generosity', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_title', 'label' => __( 'Title', 'sac' ), 'name' => 'sac_give_title', 'type' => 'text', 'default_value' => __( 'Your generosity makes a difference.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_intro', 'label' => __( 'Introduction', 'sac' ), 'name' => 'sac_give_intro', 'type' => 'textarea', 'rows' => 3, 'default_value' => __( 'Your generosity helps Spirit Assembly share the Gospel, serve people, and build a life-giving church in Riga.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_impact_tab', 'label' => __( 'Giving Impact', 'sac' ), 'name' => '', 'type' => 'tab' ),
				array( 'key' => 'field_sac_give_impact_eyebrow', 'label' => __( 'Eyebrow', 'sac' ), 'name' => 'sac_give_impact_eyebrow', 'type' => 'text', 'default_value' => __( 'Your giving at work', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_impact_title', 'label' => __( 'Heading', 'sac' ), 'name' => 'sac_give_impact_title', 'type' => 'text', 'default_value' => __( 'Together, we are building God’s house.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_impact_intro', 'label' => __( 'Introduction', 'sac' ), 'name' => 'sac_give_impact_intro', 'type' => 'textarea', 'rows' => 3, 'default_value' => __( 'Every donation helps us create space for people to encounter Jesus and experience genuine community.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_impact_one_title', 'label' => __( 'Impact 1 Title', 'sac' ), 'name' => 'sac_give_impact_one_title', 'type' => 'text', 'default_value' => __( 'Reach people', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_impact_one_text', 'label' => __( 'Impact 1 Text', 'sac' ), 'name' => 'sac_give_impact_one_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => __( 'Share the Gospel and welcome people who are searching for hope in Riga and beyond.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_impact_two_title', 'label' => __( 'Impact 2 Title', 'sac' ), 'name' => 'sac_give_impact_two_title', 'type' => 'text', 'default_value' => __( 'Build community', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_impact_two_text', 'label' => __( 'Impact 2 Text', 'sac' ), 'name' => 'sac_give_impact_two_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => __( 'Create life-giving gatherings, discipleship, prayer, and care for people of every generation.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_impact_three_title', 'label' => __( 'Impact 3 Title', 'sac' ), 'name' => 'sac_give_impact_three_title', 'type' => 'text', 'default_value' => __( 'Equip purpose', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_impact_three_text', 'label' => __( 'Impact 3 Text', 'sac' ), 'name' => 'sac_give_impact_three_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => __( 'Help believers mature in faith and fulfil their God-given calling with integrity and excellence.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_verse_tab', 'label' => __( 'Bible Verse', 'sac' ), 'name' => '', 'type' => 'tab' ),
				array( 'key' => 'field_sac_give_verse_eyebrow', 'label' => __( 'Eyebrow', 'sac' ), 'name' => 'sac_give_verse_eyebrow', 'type' => 'text', 'default_value' => __( 'A heart of generosity', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_verse_text', 'label' => __( 'Verse', 'sac' ), 'name' => 'sac_give_verse_text', 'type' => 'textarea', 'rows' => 4, 'default_value' => __( 'Each of you should give what you have decided in your heart to give… for God loves a cheerful giver.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_verse_reference', 'label' => __( 'Reference', 'sac' ), 'name' => 'sac_give_verse_reference', 'type' => 'text', 'default_value' => __( '2 Corinthians 9:7', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_verse_note', 'label' => __( 'Supporting Message', 'sac' ), 'name' => 'sac_give_verse_note', 'type' => 'textarea', 'rows' => 4, 'default_value' => __( 'Giving is an act of worship. We give freely and joyfully in response to God’s goodness—not from pressure, but from faith.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_online_tab', 'label' => __( 'Online Giving', 'sac' ), 'name' => '', 'type' => 'tab' ),
				array( 'key' => 'field_sac_give_online_title', 'label' => __( 'Heading', 'sac' ), 'name' => 'sac_give_online_title', 'type' => 'text', 'default_value' => __( 'Give online', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_online_text', 'label' => __( 'Text', 'sac' ), 'name' => 'sac_give_online_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => __( 'Give securely using Visa, Mastercard, Apple Pay, or Google Pay.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_card_url', 'label' => __( 'Card and Digital Wallet URL', 'sac' ), 'name' => 'sac_give_card_url', 'type' => 'url', 'default_value' => 'https://www.bit.ly/donate_spiritassembly', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_give_paypal_url', 'label' => __( 'PayPal URL', 'sac' ), 'name' => 'sac_give_paypal_url', 'type' => 'url', 'default_value' => 'https://www.paypal.me/SpiritAssemblyRiga', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_give_bank_tab', 'label' => __( 'Bank Transfer', 'sac' ), 'name' => '', 'type' => 'tab' ),
				array( 'key' => 'field_sac_give_bank_title', 'label' => __( 'Heading', 'sac' ), 'name' => 'sac_give_bank_title', 'type' => 'text', 'default_value' => __( 'Give by bank transfer', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_bank_text', 'label' => __( 'Instructions', 'sac' ), 'name' => 'sac_give_bank_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => __( 'Use the details below and include “Offering” as the payment reference.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_beneficiary', 'label' => __( 'Beneficiary', 'sac' ), 'name' => 'sac_give_beneficiary', 'type' => 'text', 'default_value' => 'SPIRIT ASSEMBLY INTERNATIONAL MINISTRIES', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_give_swedbank_beneficiary', 'label' => __( 'Beneficiary for SWEDBANK users', 'sac' ), 'name' => 'sac_give_swedbank_beneficiary', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'SPIRIT ASSEMBLY INTERNATIONAL MINISTRIES RĪGAS EVAŅĢĒLISKĀS TICĪBAS KRISTIEŠU DRAUDZE', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_give_iban', 'label' => 'IBAN', 'name' => 'sac_give_iban', 'type' => 'text', 'default_value' => 'LV34HABA0551051092215', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_give_registration', 'label' => __( 'Registration Number', 'sac' ), 'name' => 'sac_give_registration', 'type' => 'text', 'default_value' => '50801052801', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_give_swift', 'label' => __( 'SWIFT Code', 'sac' ), 'name' => 'sac_give_swift', 'type' => 'text', 'default_value' => 'HABALV22', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_give_bank_address', 'label' => __( 'Bank Address', 'sac' ), 'name' => 'sac_give_bank_address', 'type' => 'text', 'default_value' => 'Balasta dambis 15, Rīga, LV-1048', 'wpml_cf_preferences' => 1 ),
				array( 'key' => 'field_sac_give_payment_details', 'label' => __( 'Payment Details', 'sac' ), 'name' => 'sac_give_payment_details', 'type' => 'text', 'default_value' => __( 'Offering', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_stewardship_tab', 'label' => __( 'Stewardship', 'sac' ), 'name' => '', 'type' => 'tab' ),
				array( 'key' => 'field_sac_give_stewardship_title', 'label' => __( 'Heading', 'sac' ), 'name' => 'sac_give_stewardship_title', 'type' => 'text', 'default_value' => __( 'Giving with confidence', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_stewardship_text', 'label' => __( 'Text', 'sac' ), 'name' => 'sac_give_stewardship_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => __( 'We value integrity and faithful stewardship. Your offering supports the ministry and mission of Spirit Assembly International Ministries.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_closing_tab', 'label' => __( 'Closing Message', 'sac' ), 'name' => '', 'type' => 'tab' ),
				array( 'key' => 'field_sac_give_closing_title', 'label' => __( 'Heading', 'sac' ), 'name' => 'sac_give_closing_title', 'type' => 'text', 'default_value' => __( 'Thank you for your generosity.', 'sac' ), 'wpml_cf_preferences' => 2 ),
				array( 'key' => 'field_sac_give_closing_text', 'label' => __( 'Text', 'sac' ), 'name' => 'sac_give_closing_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => __( 'Every gift helps us continue the work God has entrusted to Spirit Assembly.', 'sac' ), 'wpml_cf_preferences' => 2 ),
			),
			'location' => $give_page_locations,
			'position' => 'normal',
			'style' => 'seamless',
			'hide_on_screen' => array( 'discussion', 'comments' ),
		)
	);

	acf_add_local_field_group(
		array(
			'key'    => 'group_sac_event_details',
			'title'  => __( 'Event Details', 'sac' ),
			'fields' => array(
				array(
					'key'                 => 'field_sac_event_start',
					'label'               => __( 'Starts', 'sac' ),
					'name'                => 'sac_event_start',
					'type'                => 'date_time_picker',
					'display_format'      => 'd.m.Y H:i',
					'return_format'       => 'Y-m-d H:i:s',
					'first_day'           => 1,
					'wpml_cf_preferences' => 1,
				),
				array(
					'key'                 => 'field_sac_event_end',
					'label'               => __( 'Ends', 'sac' ),
					'name'                => 'sac_event_end',
					'type'                => 'date_time_picker',
					'display_format'      => 'd.m.Y H:i',
					'return_format'       => 'Y-m-d H:i:s',
					'first_day'           => 1,
					'wpml_cf_preferences' => 1,
				),
				array(
					'key'                 => 'field_sac_event_location',
					'label'               => __( 'Location', 'sac' ),
					'name'                => 'sac_event_location',
					'type'                => 'text',
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_event_address',
					'label'               => __( 'Address', 'sac' ),
					'name'                => 'sac_event_address',
					'type'                => 'textarea',
					'rows'                => 2,
					'new_lines'           => 'br',
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_event_link',
					'label'               => __( 'Registration Button', 'sac' ),
					'name'                => 'sac_event_link',
					'type'                => 'link',
					'return_format'       => 'array',
					'wpml_cf_preferences' => 2,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'sac_event',
					),
				),
			),
			'position' => 'normal',
			'style'    => 'default',
		)
	);

	acf_add_local_field_group(
		array(
			'key'    => 'group_sac_sermon_details',
			'title'  => __( 'Message Details', 'sac' ),
			'fields' => array(
				array(
					'key'                 => 'field_sac_sermon_speaker',
					'label'               => __( 'Speaker', 'sac' ),
					'name'                => 'sac_sermon_speaker',
					'type'                => 'text',
					'wpml_cf_preferences' => 1,
				),
				array(
					'key'                 => 'field_sac_sermon_date',
					'label'               => __( 'Service Date', 'sac' ),
					'name'                => 'sac_sermon_date',
					'type'                => 'date_picker',
					'display_format'      => 'd.m.Y',
					'return_format'       => 'Y-m-d',
					'first_day'           => 1,
					'wpml_cf_preferences' => 1,
				),
				array(
					'key'                 => 'field_sac_sermon_scripture',
					'label'               => __( 'Scripture', 'sac' ),
					'name'                => 'sac_sermon_scripture',
					'type'                => 'text',
					'wpml_cf_preferences' => 2,
				),
				array(
					'key'                 => 'field_sac_sermon_video_url',
					'label'               => __( 'Video URL', 'sac' ),
					'name'                => 'sac_sermon_video_url',
					'type'                => 'url',
					'wpml_cf_preferences' => 1,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'sac_sermon',
					),
				),
			),
			'position' => 'normal',
			'style'    => 'default',
		)
	);
}
add_action( 'acf/init', 'sac_register_acf_fields' );

/**
 * Explain the optional dependency when this theme moves to another environment.
 */
function sac_acf_dependency_notice(): void {
	if ( function_exists( 'acf_add_local_field_group' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	?>
	<div class="notice notice-warning">
		<p><?php esc_html_e( 'SAC theme: activate Advanced Custom Fields to edit structured church content.', 'sac' ); ?></p>
	</div>
	<?php
}
add_action( 'admin_notices', 'sac_acf_dependency_notice' );
