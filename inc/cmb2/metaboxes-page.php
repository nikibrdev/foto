<?php
/**
 * Custom fields shown only on Pages using the "About the photographer"
 * template (see page-templates/template-about.php and
 * template-parts/about/about-hero.php).
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * True when the page currently being edited/rendered uses the About
 * template — used as a CMB2 `show_on` callback so this metabox doesn't
 * clutter every other Page's editor screen.
 */
function sf_is_about_template_page( $cmb ) {
	$post_id = $cmb->object_id;
	if ( ! $post_id ) {
		return false;
	}
	return 'page-templates/template-about.php' === get_page_template_slug( $post_id );
}

function sf_register_about_page_metaboxes() {
	$cmb = new_cmb2_box(
		array(
			'id'           => 'sf_about_hero_details',
			'title'        => __( 'About Page Content', 'studio-frame' ),
			'object_types' => array( 'page' ),
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true,
			'show_on_cb'   => 'sf_is_about_template_page',
		)
	);

	$cmb->add_field(
		array(
			'name' => __( 'Intro text', 'studio-frame' ),
			'desc' => __( 'A short paragraph under your name, introducing your style and approach.', 'studio-frame' ),
			'id'   => 'about_hero_text',
			'type' => 'textarea',
		)
	);

	$cmb->add_field(
		array(
			'name' => __( 'Closing statement', 'studio-frame' ),
			'desc' => __( 'A short bold statement shown above the list below, e.g. "My work blends mood, story and craft."', 'studio-frame' ),
			'id'   => 'about_hero_statement',
			'type' => 'text',
		)
	);

	$group = $cmb->add_field(
		array(
			'id'          => 'about_hero_points',
			'type'        => 'group',
			'description' => __( 'A short list of 2–4 points describing how you work (e.g. "Capturing moments", "Emotion first").', 'studio-frame' ),
			'options'     => array(
				'group_title'   => __( 'Point {#}', 'studio-frame' ),
				'add_button'    => __( 'Add Another Point', 'studio-frame' ),
				'remove_button' => __( 'Remove Point', 'studio-frame' ),
				'sortable'      => true,
			),
		)
	);

	$cmb->add_group_field(
		$group,
		array(
			'name' => __( 'Title', 'studio-frame' ),
			'id'   => 'point_title',
			'type' => 'text',
		)
	);

	$cmb->add_group_field(
		$group,
		array(
			'name' => __( 'Text', 'studio-frame' ),
			'id'   => 'point_text',
			'type' => 'textarea_small',
		)
	);
}
add_action( 'cmb2_admin_init', 'sf_register_about_page_metaboxes' );
