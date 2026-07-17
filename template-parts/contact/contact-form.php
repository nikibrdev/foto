<?php
/**
 * Reusable contact/booking form fragment.
 *
 * Pass `$args['context']` ('contacts'|'booking') and, for a booking form,
 * `$args['project_id']` when calling get_template_part():
 *
 *     get_template_part( 'template-parts/contact/contact-form', null, array(
 *         'context'    => 'booking',
 *         'project_id' => get_the_ID(),
 *     ) );
 *
 * Submissions are handled by inc/forms/class-contact-form-handler.php via
 * admin-ajax.php (see assets/js/src/components/form.js for the client side).
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_context    = isset( $args['context'] ) ? $args['context'] : 'contacts';
$sf_project_id = isset( $args['project_id'] ) ? absint( $args['project_id'] ) : 0;
?>
<form action="#" class="form" novalidate>
	<div class="form__item">
		<label class="form__label">
			<input type="text" name="sf_name" class="form__input" placeholder="<?php echo esc_attr__( 'Your name *', 'studio-frame' ); ?>" autocomplete="name">
		</label>
		<span class="form__error"><?php esc_html_e( 'This field is required', 'studio-frame' ); ?></span>
	</div>
	<div class="form__item-wrap">
		<div class="form__item">
			<label class="form__label">
				<input type="tel" name="sf_phone" class="form__input" placeholder="<?php echo esc_attr__( 'Phone number *', 'studio-frame' ); ?>" autocomplete="tel">
			</label>
			<span class="form__error"><?php esc_html_e( 'This field is required', 'studio-frame' ); ?></span>
		</div>
		<div class="form__item">
			<label class="form__label">
				<input type="email" name="sf_email" class="form__input" placeholder="<?php echo esc_attr__( 'Email *', 'studio-frame' ); ?>" autocomplete="email">
			</label>
			<span class="form__error"><?php esc_html_e( 'This field is required', 'studio-frame' ); ?></span>
		</div>
	</div>
	<div class="form__item">
		<label class="form__label">
			<textarea name="sf_message" class="form__input form__input--textarea" placeholder="<?php echo esc_attr__( 'Message', 'studio-frame' ); ?>"></textarea>
		</label>
	</div>
	<div class="form__item">
		<label class="custom-checkbox">
			<input type="checkbox" class="custom-checkbox__field" name="sf_consent" value="1">
			<span class="custom-checkbox__content"><?php esc_html_e( 'I agree to the processing of my personal data', 'studio-frame' ); ?></span>
		</label>
		<span class="form__error form__error--checkbox"><?php esc_html_e( 'Please confirm your consent to send the form', 'studio-frame' ); ?></span>
	</div>

	<?php // Honeypot: hidden from real visitors via CSS, most bots fill every field they see. ?>
	<div class="form__item form__item--hp" aria-hidden="true">
		<label class="form__label">
			<input type="text" name="sf_website" class="form__input" tabindex="-1" autocomplete="off">
		</label>
	</div>

	<input type="hidden" name="action" value="sf_submit_form">
	<input type="hidden" name="sf_context" value="<?php echo esc_attr( $sf_context ); ?>">
	<?php if ( $sf_project_id ) : ?>
		<input type="hidden" name="sf_project_id" value="<?php echo esc_attr( $sf_project_id ); ?>">
	<?php endif; ?>
	<input type="hidden" name="sf_ts" value="<?php echo esc_attr( time() ); ?>">
	<?php wp_nonce_field( 'sf_submit_form', 'sf_nonce' ); ?>

	<button type="submit" class="form__btn btn-secondary">
		<span class="btn-secondary__inner">
			<span class="btn-secondary__default"><?php esc_html_e( 'Discuss a project', 'studio-frame' ); ?></span>
			<span class="btn-secondary__hover"><?php esc_html_e( 'Discuss a project', 'studio-frame' ); ?></span>
		</span>
	</button>
</form>
