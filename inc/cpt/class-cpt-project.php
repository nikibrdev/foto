<?php
/**
 * "Project" custom post type: the photographer's portfolio entries.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_register_cpt_project() {
	$labels = array(
		'name'                  => _x( 'Projects', 'post type general name', 'studio-frame' ),
		'singular_name'         => _x( 'Project', 'post type singular name', 'studio-frame' ),
		'menu_name'             => _x( 'Projects', 'admin menu', 'studio-frame' ),
		'add_new'               => __( 'Add New', 'studio-frame' ),
		'add_new_item'          => __( 'Add New Project', 'studio-frame' ),
		'edit_item'             => __( 'Edit Project', 'studio-frame' ),
		'new_item'              => __( 'New Project', 'studio-frame' ),
		'view_item'             => __( 'View Project', 'studio-frame' ),
		'view_items'            => __( 'View Projects', 'studio-frame' ),
		'search_items'          => __( 'Search Projects', 'studio-frame' ),
		'not_found'             => __( 'No projects found. Click "Add New" to create your first portfolio entry.', 'studio-frame' ),
		'not_found_in_trash'    => __( 'No projects found in Trash.', 'studio-frame' ),
		'all_items'             => __( 'All Projects', 'studio-frame' ),
		'archives'              => __( 'Project Archives', 'studio-frame' ),
		'attributes'            => __( 'Project Attributes', 'studio-frame' ),
		'featured_image'        => __( 'Cover Photo', 'studio-frame' ),
		'set_featured_image'    => __( 'Set cover photo', 'studio-frame' ),
		'remove_featured_image' => __( 'Remove cover photo', 'studio-frame' ),
	);

	register_post_type(
		'project',
		array(
			'labels'             => $labels,
			'public'             => true,
			'has_archive'        => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-camera',
			'menu_position'      => 5,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'rewrite'            => array( 'slug' => 'project', 'with_front' => false ),
			'capability_type'    => 'post',
			'show_in_nav_menus'  => true,
		)
	);
}
add_action( 'init', 'sf_register_cpt_project' );

/**
 * Friendly "how this works" hint above the title field on the Project
 * editor screen.
 */
function sf_project_editor_hint() {
	$screen = get_current_screen();
	if ( ! $screen || 'project' !== $screen->post_type || 'post' !== $screen->base ) {
		return;
	}
	?>
	<div class="notice notice-info inline sf-editor-hint">
		<p>
			<?php
			esc_html_e(
				'Tip: give this project a Cover Photo (bottom-right) and fill in the fields below the editor — price, dates, status and the photo gallery. The main editor above is a short public description shown next to the details.',
				'studio-frame'
			);
			?>
		</p>
	</div>
	<?php
}
add_action( 'edit_form_after_title', 'sf_project_editor_hint' );
