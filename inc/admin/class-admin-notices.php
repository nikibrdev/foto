<?php
/**
 * A one-time "you just activated Studio Frame" notice pointing to the Get
 * Started screen, shown once after activation and dismissible for good.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_flag_activation_notice() {
	update_option( 'sf_show_activation_notice', 1 );
}
add_action( 'after_switch_theme', 'sf_flag_activation_notice' );

/**
 * Handle the notice's dismiss link before any output is sent.
 */
function sf_maybe_dismiss_activation_notice() {
	if ( ! isset( $_GET['sf_dismiss_notice'] ) || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'sf_dismiss_notice' ) ) {
		return;
	}
	delete_option( 'sf_show_activation_notice' );
	wp_safe_redirect( remove_query_arg( array( 'sf_dismiss_notice', '_wpnonce' ) ) );
	exit;
}
add_action( 'admin_init', 'sf_maybe_dismiss_activation_notice' );

function sf_render_activation_notice() {
	if ( ! get_option( 'sf_show_activation_notice' ) || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$dismiss_url = wp_nonce_url( add_query_arg( 'sf_dismiss_notice', '1' ), 'sf_dismiss_notice' );
	?>
	<div class="notice notice-success sf-admin-notice">
		<p>
			<strong><?php esc_html_e( 'Studio Frame is active!', 'studio-frame' ); ?></strong>
			<?php esc_html_e( 'Head over to the Get Started page for a step-by-step setup checklist and one-click demo content.', 'studio-frame' ); ?>
		</p>
		<p>
			<a class="button button-primary" href="<?php echo esc_url( admin_url( 'themes.php?page=sf-get-started' ) ); ?>"><?php esc_html_e( 'Get Started', 'studio-frame' ); ?></a>
			<a class="button" href="<?php echo esc_url( $dismiss_url ); ?>"><?php esc_html_e( 'Dismiss', 'studio-frame' ); ?></a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'sf_render_activation_notice' );
