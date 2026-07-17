<?php
/**
 * "FAQ" custom post type: title = question, main editor = answer.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_register_cpt_faq() {
	$labels = array(
		'name'               => _x( 'FAQ', 'post type general name', 'studio-frame' ),
		'singular_name'      => _x( 'FAQ Item', 'post type singular name', 'studio-frame' ),
		'menu_name'          => _x( 'FAQ', 'admin menu', 'studio-frame' ),
		'add_new'            => __( 'Add New', 'studio-frame' ),
		'add_new_item'       => __( 'Add New Question', 'studio-frame' ),
		'edit_item'          => __( 'Edit Question', 'studio-frame' ),
		'new_item'           => __( 'New Question', 'studio-frame' ),
		'search_items'       => __( 'Search Questions', 'studio-frame' ),
		'not_found'          => __( 'No questions yet. Click "Add New" to add your first FAQ entry.', 'studio-frame' ),
		'not_found_in_trash' => __( 'No questions found in Trash.', 'studio-frame' ),
		'all_items'          => __( 'All Questions', 'studio-frame' ),
	);

	register_post_type(
		'faq_item',
		array(
			'labels'          => $labels,
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'show_in_rest'    => true,
			'menu_icon'       => 'dashicons-editor-help',
			'menu_position'   => 7,
			'supports'        => array( 'title', 'editor', 'page-attributes' ),
			'capability_type' => 'post',
		)
	);
}
add_action( 'init', 'sf_register_cpt_faq' );

/**
 * Rename the "Title"/editor placeholders so the editor screen reads as a
 * question-and-answer pair rather than a generic post.
 */
function sf_faq_title_placeholder( $title, $post ) {
	if ( $post && 'faq_item' === $post->post_type ) {
		$title = __( 'Type the question here', 'studio-frame' );
	}
	return $title;
}
add_filter( 'enter_title_here', 'sf_faq_title_placeholder', 10, 2 );

function sf_faq_editor_hint() {
	$screen = get_current_screen();
	if ( ! $screen || 'faq_item' !== $screen->post_type || 'post' !== $screen->base ) {
		return;
	}
	?>
	<div class="notice notice-info inline sf-editor-hint">
		<p><?php esc_html_e( 'Type the question as the title above, and write the answer in the editor below.', 'studio-frame' ); ?></p>
	</div>
	<?php
}
add_action( 'edit_form_after_title', 'sf_faq_editor_hint' );
