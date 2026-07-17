<?php
/**
 * Customizer: contact details.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_customize_register_contacts( $wp_customize ) {
	$wp_customize->add_section(
		'sf_section_contacts',
		array(
			'title'       => __( 'Contact Details', 'studio-frame' ),
			'panel'       => 'sf_options',
			'description' => __( 'Shown in the Contacts section on every page, and used as the recipient for the contact/booking forms.', 'studio-frame' ),
			'priority'    => 40,
		)
	);

	$wp_customize->add_setting(
		'sf_contact_phone',
		array(
			'default'           => '',
			'sanitize_callback' => 'sf_sanitize_text',
		)
	);
	$wp_customize->add_control(
		'sf_contact_phone',
		array(
			'label'       => __( 'Phone number', 'studio-frame' ),
			'description' => __( 'Leave empty to hide the phone line.', 'studio-frame' ),
			'section'     => 'sf_section_contacts',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'sf_contact_email',
		array(
			'default'           => '',
			'sanitize_callback' => 'sf_sanitize_email',
		)
	);
	$wp_customize->add_control(
		'sf_contact_email',
		array(
			'label'       => __( 'Contact e-mail', 'studio-frame' ),
			'description' => __( 'Where booking and contact form submissions are sent. Leave empty to use your WordPress admin e-mail.', 'studio-frame' ),
			'section'     => 'sf_section_contacts',
			'type'        => 'email',
		)
	);

	$wp_customize->add_setting(
		'sf_contact_address',
		array(
			'default'           => '',
			'sanitize_callback' => 'sf_sanitize_text',
		)
	);
	$wp_customize->add_control(
		'sf_contact_address',
		array(
			'label'   => __( 'Studio address (optional)', 'studio-frame' ),
			'section' => 'sf_section_contacts',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sf_contact_hours',
		array(
			'default'           => '',
			'sanitize_callback' => 'sf_sanitize_text',
		)
	);
	$wp_customize->add_control(
		'sf_contact_hours',
		array(
			'label'   => __( 'Working hours (optional)', 'studio-frame' ),
			'section' => 'sf_section_contacts',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sf_contact_form_notice',
		array(
			'default'           => '',
			'sanitize_callback' => 'sf_sanitize_html',
		)
	);
	$wp_customize->add_control(
		'sf_contact_form_notice',
		array(
			'label'       => __( 'Note under the booking form (optional)', 'studio-frame' ),
			'description' => __( 'Basic HTML links are allowed, e.g. a link to your Privacy Policy page.', 'studio-frame' ),
			'section'     => 'sf_section_contacts',
			'type'        => 'textarea',
		)
	);
}
add_action( 'customize_register', 'sf_customize_register_contacts' );
