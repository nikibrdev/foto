<?php
/**
 * Reusable Customizer sanitize callbacks.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sanitize a single line of plain text.
 */
function sf_sanitize_text( $value ) {
	return sanitize_text_field( $value );
}

/**
 * Sanitize a multi-line block of plain text (line breaks preserved).
 */
function sf_sanitize_textarea( $value ) {
	return sanitize_textarea_field( $value );
}

/**
 * Sanitize a limited HTML block (used for the legal notice under the
 * contact form, which needs a link to the Privacy Policy page).
 */
function sf_sanitize_html( $value ) {
	return wp_kses_post( $value );
}

/**
 * Sanitize a URL.
 */
function sf_sanitize_url( $value ) {
	return esc_url_raw( $value );
}

/**
 * Sanitize an e-mail address; falls back to empty string if invalid so we
 * never store garbage in a field wp_mail() will later trust.
 */
function sf_sanitize_email( $value ) {
	$value = sanitize_email( $value );
	return is_email( $value ) ? $value : '';
}

/**
 * Sanitize a hex colour value.
 */
function sf_sanitize_hex_color( $value ) {
	$sanitized = sanitize_hex_color( $value );
	return $sanitized ? $sanitized : '';
}

/**
 * Sanitize a checkbox control.
 */
function sf_sanitize_checkbox( $checked ) {
	return ( isset( $checked ) && true === $checked ) ? true : false;
}
