<?php
/**
 * "Project Category" taxonomy: replaces the old hardcoded catalogue filter
 * buttons (Art / Love Story / Wedding, etc.) with real, user-editable terms.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_register_taxonomy_project_category() {
	$labels = array(
		'name'              => _x( 'Project Categories', 'taxonomy general name', 'studio-frame' ),
		'singular_name'     => _x( 'Project Category', 'taxonomy singular name', 'studio-frame' ),
		'search_items'      => __( 'Search Categories', 'studio-frame' ),
		'all_items'         => __( 'All Categories', 'studio-frame' ),
		'parent_item'       => __( 'Parent Category', 'studio-frame' ),
		'parent_item_colon' => __( 'Parent Category:', 'studio-frame' ),
		'edit_item'         => __( 'Edit Category', 'studio-frame' ),
		'update_item'       => __( 'Update Category', 'studio-frame' ),
		'add_new_item'      => __( 'Add New Category', 'studio-frame' ),
		'new_item_name'     => __( 'New Category Name', 'studio-frame' ),
		'menu_name'         => __( 'Categories', 'studio-frame' ),
	);

	register_taxonomy(
		'project_category',
		array( 'project' ),
		array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'show_in_nav_menus' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'project-category' ),
		)
	);
}
add_action( 'init', 'sf_register_taxonomy_project_category' );
