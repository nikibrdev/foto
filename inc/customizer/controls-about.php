<?php
/**
 * Customizer: "About" teaser section (homepage).
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_customize_register_about( $wp_customize ) {
	$wp_customize->add_section(
		'sf_section_about',
		array(
			'title'       => __( 'About Teaser (homepage)', 'studio-frame' ),
			'panel'       => 'sf_options',
			'description' => __( 'A short introduction with a 6-photo collage, shown on the homepage. For the full About page, edit the Page itself.', 'studio-frame' ),
			'priority'    => 20,
		)
	);

	$wp_customize->add_setting(
		'sf_about_title',
		array(
			'default'           => __( 'Photography that feels like a story, told frame by frame.', 'studio-frame' ),
			'sanitize_callback' => 'sf_sanitize_textarea',
		)
	);
	$wp_customize->add_control(
		'sf_about_title',
		array(
			'label'   => __( 'Heading', 'studio-frame' ),
			'section' => 'sf_section_about',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'sf_about_text',
		array(
			'default'           => __( 'Every shoot is planned like a scene: mood, storyline and a visual signature. My sessions are not just photographs — they are an aesthetic experience you can live through and keep.', 'studio-frame' ),
			'sanitize_callback' => 'sf_sanitize_textarea',
		)
	);
	$wp_customize->add_control(
		'sf_about_text',
		array(
			'label'   => __( 'Text', 'studio-frame' ),
			'section' => 'sf_section_about',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'sf_about_link_label',
		array(
			'default'           => __( 'More about me', 'studio-frame' ),
			'sanitize_callback' => 'sf_sanitize_text',
		)
	);
	$wp_customize->add_control(
		'sf_about_link_label',
		array(
			'label'   => __( 'Link text', 'studio-frame' ),
			'section' => 'sf_section_about',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sf_about_link_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'sf_sanitize_url',
		)
	);
	$wp_customize->add_control(
		'sf_about_link_url',
		array(
			'label'       => __( 'Link URL', 'studio-frame' ),
			'description' => __( 'Point this to your About page.', 'studio-frame' ),
			'section'     => 'sf_section_about',
			'type'        => 'url',
		)
	);

	for ( $i = 1; $i <= 6; $i++ ) {
		$wp_customize->add_setting(
			'sf_about_image_' . $i,
			array(
				'default'           => '',
				'sanitize_callback' => 'sf_sanitize_url',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'sf_about_image_' . $i,
				array(
					/* translators: %d: image position, 1-6 */
					'label'   => sprintf( __( 'Collage photo %d', 'studio-frame' ), $i ),
					'section' => 'sf_section_about',
				)
			)
		);
	}
}
add_action( 'customize_register', 'sf_customize_register_about' );
