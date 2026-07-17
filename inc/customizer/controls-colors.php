<?php
/**
 * Customizer: colour scheme, mapped onto the theme's CSS custom properties
 * (see assets/scss/_vars.scss and inc/enqueue.php::sf_get_customizer_css()).
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_customize_register_colors( $wp_customize ) {
	$wp_customize->add_section(
		'sf_section_colors',
		array(
			'title'       => __( 'Colours', 'studio-frame' ),
			'panel'       => 'sf_options',
			'description' => __( 'Changes apply across the whole site immediately.', 'studio-frame' ),
			'priority'    => 70,
		)
	);

	$colors = array(
		'sf_color_primary'    => array(
			'label'   => __( 'Primary (text & accents)', 'studio-frame' ),
			'default' => '#1A1A1A',
		),
		'sf_color_background' => array(
			'label'   => __( 'Page background', 'studio-frame' ),
			'default' => '#f0efed',
		),
		'sf_color_accent'     => array(
			'label'   => __( 'Accent (status dots, highlights)', 'studio-frame' ),
			'default' => '#3AEC49',
		),
		'sf_color_secondary'  => array(
			'label'   => __( 'Secondary (muted text)', 'studio-frame' ),
			'default' => '#888888',
		),
	);

	foreach ( $colors as $setting_id => $config ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $config['default'],
				'sanitize_callback' => 'sf_sanitize_hex_color',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$setting_id,
				array(
					'label'   => $config['label'],
					'section' => 'sf_section_colors',
				)
			)
		);
	}
}
add_action( 'customize_register', 'sf_customize_register_colors' );
