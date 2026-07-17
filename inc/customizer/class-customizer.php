<?php
/**
 * Customizer bootstrap: registers the "Studio Frame" panel and loads each
 * section's controls from its own file for readability.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/sanitize.php';
require_once __DIR__ . '/controls-hero.php';
require_once __DIR__ . '/controls-about.php';
require_once __DIR__ . '/controls-cta.php';
require_once __DIR__ . '/controls-contacts.php';
require_once __DIR__ . '/controls-social.php';
require_once __DIR__ . '/controls-footer.php';
require_once __DIR__ . '/controls-colors.php';

function sf_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'sf_options',
		array(
			'title'       => __( 'Studio Frame Settings', 'studio-frame' ),
			'description' => __( 'Everything on this page updates a section of your site — hero text, contact details, colours and more. Changes only go live once you click Publish.', 'studio-frame' ),
			'priority'    => 30,
		)
	);

	// A gentle nudge to also set a static homepage + menus, shown as the
	// panel's own description doesn't fit this well; surfaced instead on
	// the theme's Welcome screen (see inc/admin/class-welcome-screen.php).

	if ( $wp_customize->get_section( 'title_tagline' ) ) {
		$wp_customize->get_section( 'title_tagline' )->title = __( 'Site Identity (name, logo)', 'studio-frame' );
	}
}
add_action( 'customize_register', 'sf_customize_register' );

/**
 * Live-preview JS for the colour settings (see assets/js/customizer-preview.js).
 */
function sf_customize_preview_js() {
	wp_enqueue_script(
		'sf-customizer-preview',
		SF_URI . '/assets/js/customizer-preview.js',
		array( 'customize-preview' ),
		SF_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'sf_customize_preview_js' );
