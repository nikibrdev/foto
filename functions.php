<?php
/**
 * Studio Frame theme bootstrap.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SF_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'SF_DIR', get_template_directory() );
define( 'SF_URI', get_template_directory_uri() );

/**
 * Core theme setup, enqueue and template helper files.
 */
require_once SF_DIR . '/inc/setup.php';
require_once SF_DIR . '/inc/enqueue.php';
require_once SF_DIR . '/inc/template-tags.php';

/**
 * Custom post types & taxonomies.
 */
require_once SF_DIR . '/inc/cpt/class-taxonomy-project-category.php';
require_once SF_DIR . '/inc/cpt/class-taxonomy-project-status.php';
require_once SF_DIR . '/inc/cpt/class-cpt-project.php';
require_once SF_DIR . '/inc/cpt/class-cpt-testimonial.php';
require_once SF_DIR . '/inc/cpt/class-cpt-faq.php';

/**
 * CMB2 (bundled) and theme metaboxes.
 */
require_once SF_DIR . '/inc/cmb2/init-cmb2.php';
require_once SF_DIR . '/inc/cmb2/metaboxes-project.php';
require_once SF_DIR . '/inc/cmb2/metaboxes-testimonial.php';

/**
 * Customizer.
 */
require_once SF_DIR . '/inc/customizer/class-customizer.php';

/**
 * Forms.
 */
require_once SF_DIR . '/inc/forms/class-contact-form-handler.php';

/**
 * Gutenberg block patterns & style variations.
 */
require_once SF_DIR . '/inc/blocks/class-block-patterns.php';
require_once SF_DIR . '/inc/blocks/class-block-styles.php';

/**
 * SEO / third-party compatibility.
 */
require_once SF_DIR . '/inc/compat/class-seo-compat.php';

/**
 * Admin experience: welcome screen, notices, demo content, help tabs.
 */
if ( is_admin() ) {
	require_once SF_DIR . '/inc/admin/class-welcome-screen.php';
	require_once SF_DIR . '/inc/admin/class-admin-notices.php';
	require_once SF_DIR . '/inc/admin/class-demo-content.php';
	require_once SF_DIR . '/inc/admin/class-help-tabs.php';
}
