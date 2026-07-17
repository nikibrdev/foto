<?php
/**
 * Customizer: site footer.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_customize_register_footer( $wp_customize ) {
	$wp_customize->add_section(
		'sf_section_footer',
		array(
			'title'    => __( 'Footer', 'studio-frame' ),
			'panel'    => 'sf_options',
			'priority' => 60,
		)
	);

	$wp_customize->add_setting(
		'sf_footer_heading',
		array(
			'default'           => get_bloginfo( 'name' ),
			'sanitize_callback' => 'sf_sanitize_text',
		)
	);
	$wp_customize->add_control(
		'sf_footer_heading',
		array(
			'label'   => __( 'Heading', 'studio-frame' ),
			'section' => 'sf_section_footer',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sf_footer_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'sf_sanitize_url',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'sf_footer_image',
			array(
				'label'       => __( 'Portrait photo', 'studio-frame' ),
				'description' => __( 'A tall photo, e.g. of yourself. Optional — leave empty to hide it.', 'studio-frame' ),
				'section'     => 'sf_section_footer',
			)
		)
	);

	$wp_customize->add_setting(
		'sf_footer_copyright',
		array(
			/* translators: %s: current year, replaced automatically */
			'default'           => sprintf( __( '© %s. All rights reserved.', 'studio-frame' ), '[year]' ),
			'sanitize_callback' => 'sf_sanitize_text',
		)
	);
	$wp_customize->add_control(
		'sf_footer_copyright',
		array(
			'label'       => __( 'Copyright line', 'studio-frame' ),
			'description' => __( 'Use [year] anywhere in the text — it is automatically replaced with the current year.', 'studio-frame' ),
			'section'     => 'sf_section_footer',
			'type'        => 'text',
		)
	);
}
add_action( 'customize_register', 'sf_customize_register_footer' );
