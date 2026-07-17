<?php
/**
 * Customizer: call-to-action band (shown on the homepage and every project
 * page).
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_customize_register_cta( $wp_customize ) {
	$wp_customize->add_section(
		'sf_section_cta',
		array(
			'title'       => __( 'Call to Action Band', 'studio-frame' ),
			'panel'       => 'sf_options',
			'description' => __( 'The full-width statement with two buttons shown on the homepage and every project page.', 'studio-frame' ),
			'priority'    => 30,
		)
	);

	$wp_customize->add_setting(
		'sf_cta_title',
		array(
			'default'           => __( 'Want to become part of a visual story?', 'studio-frame' ),
			'sanitize_callback' => 'sf_sanitize_textarea',
		)
	);
	$wp_customize->add_control(
		'sf_cta_title',
		array(
			'label'   => __( 'Heading', 'studio-frame' ),
			'section' => 'sf_section_cta',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'sf_cta_text',
		array(
			'default'           => __( 'Pick one of the projects below or pitch your own idea.', 'studio-frame' ),
			'sanitize_callback' => 'sf_sanitize_textarea',
		)
	);
	$wp_customize->add_control(
		'sf_cta_text',
		array(
			'label'   => __( 'Text', 'studio-frame' ),
			'section' => 'sf_section_cta',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'sf_cta_bg_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'sf_sanitize_url',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'sf_cta_bg_image',
			array(
				'label'   => __( 'Background photo', 'studio-frame' ),
				'section' => 'sf_section_cta',
			)
		)
	);

	$wp_customize->add_setting(
		'sf_cta_primary_label',
		array(
			'default'           => __( 'Choose a project', 'studio-frame' ),
			'sanitize_callback' => 'sf_sanitize_text',
		)
	);
	$wp_customize->add_control(
		'sf_cta_primary_label',
		array(
			'label'   => __( 'Primary button text', 'studio-frame' ),
			'section' => 'sf_section_cta',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sf_cta_primary_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'sf_sanitize_url',
		)
	);
	$wp_customize->add_control(
		'sf_cta_primary_url',
		array(
			'label'       => __( 'Primary button link', 'studio-frame' ),
			'description' => __( 'Leave empty to link to your Projects page automatically.', 'studio-frame' ),
			'section'     => 'sf_section_cta',
			'type'        => 'url',
		)
	);

	$wp_customize->add_setting(
		'sf_cta_secondary_label',
		array(
			'default'           => __( 'Discuss your project', 'studio-frame' ),
			'sanitize_callback' => 'sf_sanitize_text',
		)
	);
	$wp_customize->add_control(
		'sf_cta_secondary_label',
		array(
			'label'   => __( 'Secondary button text', 'studio-frame' ),
			'section' => 'sf_section_cta',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sf_cta_secondary_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'sf_sanitize_url',
		)
	);
	$wp_customize->add_control(
		'sf_cta_secondary_url',
		array(
			'label'       => __( 'Secondary button link', 'studio-frame' ),
			'description' => __( 'Leave empty to link to the contact form automatically.', 'studio-frame' ),
			'section'     => 'sf_section_cta',
			'type'        => 'url',
		)
	);
}
add_action( 'customize_register', 'sf_customize_register_cta' );
