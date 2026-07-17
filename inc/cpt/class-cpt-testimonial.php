<?php
/**
 * "Testimonial" custom post type: client reviews shown on the home page.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_register_cpt_testimonial() {
	$labels = array(
		'name'               => _x( 'Testimonials', 'post type general name', 'studio-frame' ),
		'singular_name'      => _x( 'Testimonial', 'post type singular name', 'studio-frame' ),
		'menu_name'          => _x( 'Testimonials', 'admin menu', 'studio-frame' ),
		'add_new'            => __( 'Add New', 'studio-frame' ),
		'add_new_item'       => __( 'Add New Testimonial', 'studio-frame' ),
		'edit_item'          => __( 'Edit Testimonial', 'studio-frame' ),
		'new_item'           => __( 'New Testimonial', 'studio-frame' ),
		'search_items'       => __( 'Search Testimonials', 'studio-frame' ),
		'not_found'          => __( 'No testimonials yet. Click "Add New" to add your first client review.', 'studio-frame' ),
		'not_found_in_trash' => __( 'No testimonials found in Trash.', 'studio-frame' ),
		'all_items'          => __( 'All Testimonials', 'studio-frame' ),
		'featured_image'     => __( 'Client Photo', 'studio-frame' ),
		'set_featured_image' => __( 'Set client photo', 'studio-frame' ),
	);

	register_post_type(
		'testimonial',
		array(
			'labels'          => $labels,
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'show_in_rest'    => false,
			'menu_icon'       => 'dashicons-format-quote',
			'menu_position'   => 6,
			'supports'        => array( 'title', 'thumbnail', 'page-attributes' ),
			'capability_type' => 'post',
		)
	);
}
add_action( 'init', 'sf_register_cpt_testimonial' );

/**
 * Rename the "Title" field label to "Client name" for this post type, so
 * the editor screen reads naturally.
 */
function sf_testimonial_title_placeholder( $title, $post ) {
	if ( $post && 'testimonial' === $post->post_type ) {
		$title = __( 'Client name, e.g. "Jane D."', 'studio-frame' );
	}
	return $title;
}
add_filter( 'enter_title_here', 'sf_testimonial_title_placeholder', 10, 2 );
