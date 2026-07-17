<?php
/**
 * Custom fields for the Project post type (price, dates, gallery, status
 * flags), registered with the bundled CMB2 library.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_register_project_metaboxes() {
	$cmb = new_cmb2_box(
		array(
			'id'           => 'sf_project_details',
			'title'        => __( 'Project Details', 'studio-frame' ),
			'object_types' => array( 'project' ),
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true,
		)
	);

	$cmb->add_field(
		array(
			'name'       => __( 'Price', 'studio-frame' ),
			'desc'       => __( 'The starting price shown on the project page, e.g. "$500". Leave empty to hide the price line.', 'studio-frame' ),
			'id'         => 'project_price_amount',
			'type'       => 'text',
			'attributes' => array( 'placeholder' => __( 'e.g. from $500', 'studio-frame' ) ),
		)
	);

	$cmb->add_field(
		array(
			'name' => __( 'Price note', 'studio-frame' ),
			'desc' => __( 'Optional extra detail shown next to the price, e.g. "for a 2-hour session".', 'studio-frame' ),
			'id'   => 'project_price_note',
			'type' => 'text',
		)
	);

	$cmb->add_field(
		array(
			'name'       => __( 'Date / period', 'studio-frame' ),
			'desc'       => __( 'Free text — a month, a season, or "Booking now", whatever fits this project.', 'studio-frame' ),
			'id'         => 'project_date_text',
			'type'       => 'text',
			'attributes' => array( 'placeholder' => __( 'e.g. September 2026', 'studio-frame' ) ),
		)
	);

	$cmb->add_field(
		array(
			'name' => __( 'Short description for cards', 'studio-frame' ),
			'desc' => __( 'A one- or two-sentence teaser shown on the homepage slider and project cards. If left empty, the excerpt is used instead.', 'studio-frame' ),
			'id'   => 'project_short_description',
			'type' => 'textarea_small',
		)
	);

	$cmb->add_field(
		array(
			'name' => __( 'Gallery', 'studio-frame' ),
			'desc' => __( 'Upload the photos for this project, in the order you want them shown. The first photo is also used as the cover/thumbnail wherever a single image is needed.', 'studio-frame' ),
			'id'   => 'project_gallery',
			'type' => 'file_list',
			'text' => array(
				'add_upload_files_text' => __( 'Add Photos', 'studio-frame' ),
				'remove_image_text'     => __( 'Remove', 'studio-frame' ),
				'file_text'             => __( 'Photo:', 'studio-frame' ),
				'remove_text'           => __( 'Remove', 'studio-frame' ),
			),
			'query_args' => array( 'type' => 'image' ),
		)
	);

	$cmb->add_field(
		array(
			'name' => __( 'Book now button label', 'studio-frame' ),
			'desc' => __( 'Leave empty to use the default "Book now".', 'studio-frame' ),
			'id'   => 'project_booking_button_label',
			'type' => 'text',
		)
	);

	$cmb_flags = new_cmb2_box(
		array(
			'id'           => 'sf_project_flags',
			'title'        => __( 'Show on Homepage', 'studio-frame' ),
			'object_types' => array( 'project' ),
			'context'      => 'side',
			'priority'     => 'default',
			'show_names'   => true,
		)
	);

	$cmb_flags->add_field(
		array(
			'name' => __( 'Homepage slider', 'studio-frame' ),
			'desc' => __( 'Feature this project in the large image slider at the top of the homepage.', 'studio-frame' ),
			'id'   => 'project_show_in_slider',
			'type' => 'checkbox',
		)
	);

	$cmb_flags->add_field(
		array(
			'name' => __( 'Homepage projects list', 'studio-frame' ),
			'desc' => __( 'Feature this project in the curated grid on the homepage. If nothing is featured, the most recent projects are shown automatically.', 'studio-frame' ),
			'id'   => 'project_show_in_teaser',
			'type' => 'checkbox',
		)
	);
}
add_action( 'cmb2_admin_init', 'sf_register_project_metaboxes' );
