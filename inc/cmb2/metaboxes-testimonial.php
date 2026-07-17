<?php
/**
 * Custom field for the Testimonial post type.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_register_testimonial_metaboxes() {
	$cmb = new_cmb2_box(
		array(
			'id'           => 'sf_testimonial_details',
			'title'        => __( 'Review Text', 'studio-frame' ),
			'object_types' => array( 'testimonial' ),
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true,
		)
	);

	$cmb->add_field(
		array(
			'name' => __( 'Review', 'studio-frame' ),
			'desc' => __( 'The client\'s quote, shown next to their name and photo.', 'studio-frame' ),
			'id'   => 'testimonial_text',
			'type' => 'textarea',
		)
	);
}
add_action( 'cmb2_admin_init', 'sf_register_testimonial_metaboxes' );
