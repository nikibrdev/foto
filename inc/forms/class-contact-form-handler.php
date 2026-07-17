<?php
/**
 * Handles the contact + booking form submissions rendered by
 * template-parts/contact/contact-form.php, via admin-ajax.php.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Minimum number of seconds that must pass between the form being rendered
 * and being submitted. Real visitors always take longer than this; simple
 * bots that submit immediately do not.
 */
define( 'SF_FORM_MIN_SECONDS', 3 );

/**
 * Max submissions allowed from the same IP address within the rate-limit
 * window.
 */
define( 'SF_FORM_RATE_LIMIT', 5 );
define( 'SF_FORM_RATE_WINDOW', 10 * MINUTE_IN_SECONDS );

function sf_handle_form_submission() {
	if ( ! isset( $_POST['sf_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sf_nonce'] ) ), 'sf_submit_form' ) ) {
		wp_send_json_error( array( 'message' => __( 'Your session has expired. Please reload the page and try again.', 'studio-frame' ) ), 403 );
	}

	// Honeypot: real visitors never fill this hidden field in.
	if ( ! empty( $_POST['sf_website'] ) ) {
		wp_send_json_success(); // Pretend success so the bot moves on.
	}

	// Time-trap: reject submissions that arrive suspiciously fast.
	$submitted_at = isset( $_POST['sf_ts'] ) ? absint( $_POST['sf_ts'] ) : 0;
	if ( ! $submitted_at || ( time() - $submitted_at ) < SF_FORM_MIN_SECONDS ) {
		wp_send_json_error( array( 'message' => __( 'Please try submitting the form again.', 'studio-frame' ) ), 400 );
	}

	if ( sf_form_rate_limited() ) {
		wp_send_json_error( array( 'message' => __( 'Too many requests. Please try again in a few minutes.', 'studio-frame' ) ), 429 );
	}

	$name    = isset( $_POST['sf_name'] ) ? sanitize_text_field( wp_unslash( $_POST['sf_name'] ) ) : '';
	$phone   = isset( $_POST['sf_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['sf_phone'] ) ) : '';
	$email   = isset( $_POST['sf_email'] ) ? sanitize_email( wp_unslash( $_POST['sf_email'] ) ) : '';
	$message = isset( $_POST['sf_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['sf_message'] ) ) : '';
	$consent = ! empty( $_POST['sf_consent'] );
	$context = isset( $_POST['sf_context'] ) && 'booking' === $_POST['sf_context'] ? 'booking' : 'contacts';
	$project_id = isset( $_POST['sf_project_id'] ) ? absint( $_POST['sf_project_id'] ) : 0;

	$errors = array();
	if ( '' === $name ) {
		$errors[] = __( 'Please enter your name.', 'studio-frame' );
	}
	if ( '' === $phone ) {
		$errors[] = __( 'Please enter your phone number.', 'studio-frame' );
	}
	if ( '' === $email || ! is_email( $email ) ) {
		$errors[] = __( 'Please enter a valid e-mail address.', 'studio-frame' );
	}
	if ( ! $consent ) {
		$errors[] = __( 'Please confirm your consent to send the form.', 'studio-frame' );
	}

	if ( ! empty( $errors ) ) {
		wp_send_json_error( array( 'message' => implode( ' ', $errors ) ), 422 );
	}

	$sent = sf_send_form_email( $context, $project_id, $name, $phone, $email, $message );

	sf_form_rate_limit_hit();

	if ( ! $sent ) {
		wp_send_json_error( array( 'message' => __( 'We could not send your request right now. Please try again or contact us directly by e-mail.', 'studio-frame' ) ), 500 );
	}

	wp_send_json_success( array( 'message' => __( 'Thank you! Your request has been sent.', 'studio-frame' ) ) );
}
add_action( 'wp_ajax_sf_submit_form', 'sf_handle_form_submission' );
add_action( 'wp_ajax_nopriv_sf_submit_form', 'sf_handle_form_submission' );

/**
 * Build and send the notification e-mail to the site's configured contact
 * address.
 */
function sf_send_form_email( $context, $project_id, $name, $phone, $email, $message ) {
	$to = sf_get_contact_email();

	if ( 'booking' === $context && $project_id ) {
		/* translators: %s: project title */
		$subject = sprintf( __( 'New booking request: %s', 'studio-frame' ), get_the_title( $project_id ) );
	} else {
		$subject = __( 'New contact form submission', 'studio-frame' );
	}
	$subject = '[' . get_bloginfo( 'name' ) . '] ' . $subject;

	$lines   = array();
	$lines[] = sprintf( '%s: %s', __( 'Name', 'studio-frame' ), $name );
	$lines[] = sprintf( '%s: %s', __( 'Phone', 'studio-frame' ), $phone );
	$lines[] = sprintf( '%s: %s', __( 'Email', 'studio-frame' ), $email );
	if ( 'booking' === $context && $project_id ) {
		$lines[] = sprintf( '%s: %s (%s)', __( 'Project', 'studio-frame' ), get_the_title( $project_id ), get_permalink( $project_id ) );
	}
	if ( $message ) {
		$lines[] = '';
		$lines[] = __( 'Message:', 'studio-frame' );
		$lines[] = $message;
	}

	$body = implode( "\n", $lines );

	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	return wp_mail( $to, $subject, $body, $headers );
}

/**
 * True when the current IP has already submitted SF_FORM_RATE_LIMIT
 * (or more) forms within the current rate-limit window.
 */
function sf_form_rate_limited() {
	$key   = 'sf_form_rl_' . md5( sf_get_client_ip() );
	$count = (int) get_transient( $key );
	return $count >= SF_FORM_RATE_LIMIT;
}

/**
 * Record one submission from the current IP for rate-limiting purposes.
 */
function sf_form_rate_limit_hit() {
	$key   = 'sf_form_rl_' . md5( sf_get_client_ip() );
	$count = (int) get_transient( $key );
	set_transient( $key, $count + 1, SF_FORM_RATE_WINDOW );
}

/**
 * Best-effort client IP lookup for rate-limiting only (not used for any
 * security or trust decision beyond throttling).
 */
function sf_get_client_ip() {
	if ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
		return sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
	}
	return '0.0.0.0';
}
