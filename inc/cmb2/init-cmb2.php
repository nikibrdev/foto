<?php
/**
 * Loads the CMB2 field library, bundled with the theme (see
 * inc/cmb2/vendor/CMB2/) so buyers don't have to install a separate plugin
 * just to get metabox fields (image uploaders, repeaters, etc.) working.
 *
 * CMB2 is GPLv2-or-later, © the CMB2 team; see
 * inc/cmb2/vendor/CMB2/LICENSE.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CMB2', false ) ) {
	require_once SF_DIR . '/inc/cmb2/vendor/CMB2/init.php';
}
