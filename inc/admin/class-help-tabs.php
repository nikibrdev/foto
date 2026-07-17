<?php
/**
 * Contextual Help tabs (top-right "Help" dropdown) on the CPT list/edit
 * screens, explaining fields that aren't self-explanatory.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_add_help_tabs() {
	$screen = get_current_screen();
	if ( ! $screen ) {
		return;
	}

	if ( 'project' === $screen->post_type ) {
		$screen->add_help_tab(
			array(
				'id'      => 'sf-help-project',
				'title'   => __( 'About Projects', 'studio-frame' ),
				'content' =>
					'<p>' . esc_html__( 'A Project is one entry in your portfolio.', 'studio-frame' ) . '</p>' .
					'<p>' . esc_html__( 'Price, dates, status and the photo gallery are set in the "Project Details" box below the main editor. The main editor text is a short public description shown next to those details.', 'studio-frame' ) . '</p>' .
					'<p>' . esc_html__( 'Categories and Statuses (right-hand sidebar) power the filter buttons on your portfolio page — add as many as you like.', 'studio-frame' ) . '</p>' .
					'<p>' . esc_html__( '"Show on Homepage" (right-hand sidebar) controls whether this project appears in the homepage slider and/or the curated projects grid.', 'studio-frame' ) . '</p>',
			)
		);
	}

	if ( 'testimonial' === $screen->post_type ) {
		$screen->add_help_tab(
			array(
				'id'      => 'sf-help-testimonial',
				'title'   => __( 'About Testimonials', 'studio-frame' ),
				'content' =>
					'<p>' . esc_html__( 'The Title field is the client\'s name (e.g. "Jane D." — a first name and last initial is common for privacy).', 'studio-frame' ) . '</p>' .
					'<p>' . esc_html__( 'Set a Featured Image for the client\'s photo, and fill in the review text in the box below.', 'studio-frame' ) . '</p>' .
					'<p>' . esc_html__( 'Drag testimonials up and down in the list view to change the order they appear in on the homepage.', 'studio-frame' ) . '</p>',
			)
		);
	}

	if ( 'faq_item' === $screen->post_type ) {
		$screen->add_help_tab(
			array(
				'id'      => 'sf-help-faq',
				'title'   => __( 'About FAQ', 'studio-frame' ),
				'content' =>
					'<p>' . esc_html__( 'Type the question as the Title, and the answer in the main editor below.', 'studio-frame' ) . '</p>' .
					'<p>' . esc_html__( 'Drag entries up and down in the list view to change the order they appear in on the homepage.', 'studio-frame' ) . '</p>',
			)
		);
	}
}
add_action( 'current_screen', 'sf_add_help_tabs' );
