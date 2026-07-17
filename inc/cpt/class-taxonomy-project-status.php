<?php
/**
 * "Project Status" taxonomy: replaces the old hardcoded "Booking open" /
 * "Available again" labels. Each term can have its own accent colour
 * (stored as term meta) shown as a small dot next to the status text.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_register_taxonomy_project_status() {
	$labels = array(
		'name'          => _x( 'Project Statuses', 'taxonomy general name', 'studio-frame' ),
		'singular_name' => _x( 'Project Status', 'taxonomy singular name', 'studio-frame' ),
		'search_items'  => __( 'Search Statuses', 'studio-frame' ),
		'all_items'     => __( 'All Statuses', 'studio-frame' ),
		'edit_item'     => __( 'Edit Status', 'studio-frame' ),
		'update_item'   => __( 'Update Status', 'studio-frame' ),
		'add_new_item'  => __( 'Add New Status', 'studio-frame' ),
		'new_item_name' => __( 'New Status Name', 'studio-frame' ),
		'menu_name'     => __( 'Statuses', 'studio-frame' ),
	);

	register_taxonomy(
		'project_status',
		array( 'project' ),
		array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'show_in_nav_menus' => false,
			'query_var'         => true,
			'rewrite'           => false,
		)
	);
}
add_action( 'init', 'sf_register_taxonomy_project_status' );

/**
 * "Badge colour" field on the Add/Edit Project Status term screens.
 */
function sf_project_status_color_field( $term = null ) {
	$color = $term ? get_term_meta( $term->term_id, 'status_badge_color', true ) : '';
	if ( ! $color ) {
		$color = '#3AEC49';
	}
	$is_edit = (bool) $term;
	$field   = '<input type="text" id="sf-status-badge-color" name="sf_status_badge_color" value="' . esc_attr( $color ) . '" class="sf-color-field" data-default-color="#3AEC49">'
		. wp_nonce_field( 'sf_save_status_color', 'sf_status_color_nonce', true, false );
	$description = '<p class="description">' . esc_html__( 'The dot colour shown next to this status on a project page, e.g. green for "booking open".', 'studio-frame' ) . '</p>';
	?>
	<?php if ( $is_edit ) : ?>
		<tr class="form-field">
			<th scope="row"><label for="sf-status-badge-color"><?php esc_html_e( 'Badge colour', 'studio-frame' ); ?></label></th>
			<td>
				<?php echo $field . $description; // phpcs:ignore -- $field is built from esc_attr()/wp_nonce_field() output above. ?>
			</td>
		</tr>
	<?php else : ?>
		<div class="form-field">
			<label for="sf-status-badge-color"><?php esc_html_e( 'Badge colour', 'studio-frame' ); ?></label>
			<?php echo $field . $description; // phpcs:ignore -- $field is built from esc_attr()/wp_nonce_field() output above. ?>
		</div>
	<?php endif;
}
add_action( 'project_status_add_form_fields', 'sf_project_status_color_field' );
add_action( 'project_status_edit_form_fields', 'sf_project_status_color_field' );

/**
 * Save the badge colour term meta.
 */
function sf_save_project_status_color( $term_id ) {
	if ( ! isset( $_POST['sf_status_badge_color'], $_POST['sf_status_color_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sf_status_color_nonce'] ) ), 'sf_save_status_color' ) ) {
		return;
	}
	$color = sanitize_hex_color( wp_unslash( $_POST['sf_status_badge_color'] ) );
	if ( $color ) {
		update_term_meta( $term_id, 'status_badge_color', $color );
	}
}
add_action( 'created_project_status', 'sf_save_project_status_color' );
add_action( 'edited_project_status', 'sf_save_project_status_color' );

/**
 * Load the WP core colour picker on the term screens for this taxonomy.
 */
function sf_project_status_admin_assets( $hook ) {
	$screen = get_current_screen();
	if ( ! $screen || 'project_status' !== $screen->taxonomy ) {
		return;
	}
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_add_inline_script(
		'wp-color-picker',
		'jQuery(function($){ $(".sf-color-field").wpColorPicker(); });'
	);
}
add_action( 'admin_enqueue_scripts', 'sf_project_status_admin_assets' );
