<?php
/**
 * Customizer: social network links.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_customize_register_social( $wp_customize ) {
	$wp_customize->add_section(
		'sf_section_social',
		array(
			'title'       => __( 'Social Links', 'studio-frame' ),
			'panel'       => 'sf_options',
			'description' => __( 'Leave any field empty to hide that icon everywhere on the site.', 'studio-frame' ),
			'priority'    => 50,
		)
	);

	$networks = array(
		'telegram'  => __( 'Telegram URL', 'studio-frame' ),
		'whatsapp'  => __( 'WhatsApp URL', 'studio-frame' ),
		'vk'        => __( 'VK URL', 'studio-frame' ),
		'instagram' => __( 'Instagram URL', 'studio-frame' ),
		'youtube'   => __( 'YouTube URL', 'studio-frame' ),
	);

	foreach ( $networks as $slug => $label ) {
		$wp_customize->add_setting(
			'sf_social_' . $slug,
			array(
				'default'           => '',
				'sanitize_callback' => 'sf_sanitize_url',
			)
		);
		$wp_customize->add_control(
			'sf_social_' . $slug,
			array(
				'label'   => $label,
				'section' => 'sf_section_social',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'sf_customize_register_social' );
