<?php
/**
 * Block style variations that let editor content pick up the theme's own
 * button and section look, without needing a page builder.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_register_block_styles() {
	register_block_style(
		'core/button',
		array(
			'name'  => 'sf-btn-main',
			'label' => __( 'Studio Frame Main', 'studio-frame' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'sf-btn-secondary',
			'label' => __( 'Studio Frame Secondary', 'studio-frame' ),
		)
	);

	register_block_style(
		'core/group',
		array(
			'name'  => 'sf-panel',
			'label' => __( 'Soft Panel', 'studio-frame' ),
		)
	);
}
add_action( 'init', 'sf_register_block_styles' );
