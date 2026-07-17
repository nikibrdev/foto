<?php
/**
 * Customizer: Hero section (homepage).
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_customize_register_hero( $wp_customize ) {
	$wp_customize->add_section(
		'sf_section_hero',
		array(
			'title'       => __( 'Hero (homepage top)', 'studio-frame' ),
			'panel'       => 'sf_options',
			'description' => __( 'The big statement at the very top of your homepage.', 'studio-frame' ),
			'priority'    => 10,
		)
	);

	$wp_customize->add_setting(
		'sf_hero_subtitle',
		array(
			'default'           => get_bloginfo( 'name' ),
			'sanitize_callback' => 'sf_sanitize_text',
		)
	);
	$wp_customize->add_control(
		'sf_hero_subtitle',
		array(
			'label'       => __( 'Small label above the headline', 'studio-frame' ),
			'description' => __( 'Usually your name or studio name.', 'studio-frame' ),
			'section'     => 'sf_section_hero',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'sf_hero_title',
		array(
			'default'           => __( 'Art photography with a story. Images you believe in.', 'studio-frame' ),
			'sanitize_callback' => 'sf_sanitize_textarea',
		)
	);
	$wp_customize->add_control(
		'sf_hero_title',
		array(
			'label'       => __( 'Headline', 'studio-frame' ),
			'description' => __( 'The main, large statement. Keep it short — one or two sentences work best.', 'studio-frame' ),
			'section'     => 'sf_section_hero',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'sf_hero_button_label',
		array(
			'default'           => __( 'Choose a project', 'studio-frame' ),
			'sanitize_callback' => 'sf_sanitize_text',
		)
	);
	$wp_customize->add_control(
		'sf_hero_button_label',
		array(
			'label'   => __( 'Button text', 'studio-frame' ),
			'section' => 'sf_section_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sf_hero_button_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'sf_sanitize_url',
		)
	);
	$wp_customize->add_control(
		'sf_hero_button_url',
		array(
			'label'       => __( 'Button link', 'studio-frame' ),
			'description' => __( 'Leave empty to link to your Projects page automatically.', 'studio-frame' ),
			'section'     => 'sf_section_hero',
			'type'        => 'url',
		)
	);
}
add_action( 'customize_register', 'sf_customize_register_hero' );
