<?php
/**
 * Front-end and editor asset enqueueing.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue theme styles and scripts.
 */
function sf_enqueue_assets() {
	wp_enqueue_style( 'sf-vendor', SF_URI . '/assets/css/vendor.css', array(), SF_VERSION );
	wp_enqueue_style( 'sf-style', SF_URI . '/assets/css/style.css', array( 'sf-vendor' ), SF_VERSION );

	// Live Customizer colour overrides are appended after this handle.
	wp_add_inline_style( 'sf-style', sf_get_customizer_css() );

	$main_deps = array();

	// GSAP + ScrollTrigger only power the "About" page hero title animation.
	// Registered (and made a dependency of sf-main) *before* sf-main is
	// enqueued so deferred script execution order is guaranteed correct.
	if ( is_page_template( 'page-templates/template-about.php' ) ) {
		wp_enqueue_script( 'sf-gsap', SF_URI . '/assets/js/vendor/gsap.min.js', array(), '3.12.5', array( 'strategy' => 'defer' ) );
		wp_enqueue_script( 'sf-scrolltrigger', SF_URI . '/assets/js/vendor/ScrollTrigger.min.js', array( 'sf-gsap' ), '3.12.5', array( 'strategy' => 'defer' ) );
		$main_deps[] = 'sf-scrolltrigger';
	}

	wp_enqueue_script( 'sf-main', SF_URI . '/assets/js/main.js', $main_deps, SF_VERSION, array( 'strategy' => 'defer' ) );

	wp_localize_script(
		'sf-main',
		'sfData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'i18n'    => array(
				'successTitle' => esc_html__( 'Thank you!', 'studio-frame' ),
				'successText'  => esc_html__( 'Your request has been sent.', 'studio-frame' ),
				'errorTitle'   => esc_html__( 'Something went wrong', 'studio-frame' ),
				'errorText'    => esc_html__( 'We could not send your request. Please try again.', 'studio-frame' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'sf_enqueue_assets' );

/**
 * Build the inline `<style>` block that maps Customizer colour settings onto
 * the theme's CSS custom properties (see assets/scss/_vars.scss).
 *
 * @return string
 */
function sf_get_customizer_css() {
	$colors = array(
		'--primary-color'   => get_theme_mod( 'sf_color_primary', '#1A1A1A' ),
		'--background-color' => get_theme_mod( 'sf_color_background', '#f0efed' ),
		'--green-color'      => get_theme_mod( 'sf_color_accent', '#3AEC49' ),
		'--secondary-color'  => get_theme_mod( 'sf_color_secondary', '#888888' ),
	);

	$css = ':root{';
	foreach ( $colors as $property => $value ) {
		$css .= sprintf( '%s:%s;', $property, sanitize_text_field( $value ) );
	}
	$css .= '}';

	return $css;
}

/**
 * Editor-only assets, so Gutenberg content roughly matches the front end.
 */
function sf_enqueue_block_editor_assets() {
	wp_enqueue_style( 'sf-editor-style', SF_URI . '/assets/css/editor-style.css', array(), SF_VERSION );
}
add_action( 'enqueue_block_editor_assets', 'sf_enqueue_block_editor_assets' );
