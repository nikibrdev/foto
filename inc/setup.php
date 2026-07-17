<?php
/**
 * Core theme setup: supports, menus, image sizes, text domain.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme support, navigation menus and image sizes.
 */
function sf_theme_setup() {
	load_theme_textdomain( 'studio-frame', SF_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 55,
			'width'       => 77,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu (header)', 'studio-frame' ),
			'footer'  => esc_html__( 'Footer Menu', 'studio-frame' ),
		)
	);

	// Project catalogue card crops (see template-parts/project/card.php).
	add_image_size( 'sf-project-horizontal', 1152, 690, true );
	add_image_size( 'sf-project-vertical', 576, 690, true );

	// Single project gallery crops (see template-parts/project/gallery.php).
	add_image_size( 'sf-gallery-wide', 1142, 690, true );
	add_image_size( 'sf-gallery-tall', 1142, 1409, true );
	add_image_size( 'sf-gallery-portrait', 556, 690, true );

	// Home page "about" collage thumbnails.
	add_image_size( 'sf-about-collage', 272, 250, true );

	// Client review avatar.
	add_image_size( 'sf-review-avatar', 202, 269, true );

	// Hero slider crops.
	add_image_size( 'sf-slider-main', 945, 597, true );
	add_image_size( 'sf-slider-side', 292, 438, true );
	add_image_size( 'sf-slider-bottom', 205, 307, true );

	// "More projects" running strip + footer portrait.
	add_image_size( 'sf-more-slide', 556, 690, true );
	add_image_size( 'sf-footer-portrait', 556, 688, true );
}
add_action( 'after_setup_theme', 'sf_theme_setup' );

/**
 * Set the $content_width global, used by core embeds/oEmbeds.
 */
function sf_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sf_content_width', 1152 );
}
add_action( 'after_setup_theme', 'sf_content_width', 0 );

/**
 * Seed default taxonomy terms once, right after theme activation.
 */
function sf_activation_seed_terms() {
	if ( ! taxonomy_exists( 'project_status' ) ) {
		return;
	}

	if ( ! term_exists( 'in-progress', 'project_status' ) ) {
		$term = wp_insert_term( __( 'Booking open', 'studio-frame' ), 'project_status', array( 'slug' => 'in-progress' ) );
		if ( ! is_wp_error( $term ) ) {
			update_term_meta( $term['term_id'], 'status_badge_color', '#3AEC49' );
		}
	}

	if ( ! term_exists( 'repeatable', 'project_status' ) ) {
		$term = wp_insert_term( __( 'Available again', 'studio-frame' ), 'project_status', array( 'slug' => 'repeatable' ) );
		if ( ! is_wp_error( $term ) ) {
			update_term_meta( $term['term_id'], 'status_badge_color', '#888888' );
		}
	}
}

/**
 * Seed default terms and flush rewrite rules once, right after activation,
 * so the /project/ archive works immediately without a manual permalinks
 * resave.
 */
function sf_on_theme_activation() {
	sf_activation_seed_terms();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'sf_on_theme_activation' );
