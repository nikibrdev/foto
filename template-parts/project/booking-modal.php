<?php
/**
 * Booking form, shown inside a graph-modal popup triggered by the
 * "Book now" button in template-parts/project/details-aside.php.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_post_id = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : get_the_ID();
?>
<div class="graph-modal">
	<div class="graph-modal__container" role="dialog" aria-modal="true" data-graph-target="modal-project-<?php echo esc_attr( $sf_post_id ); ?>">
		<button class="btn-reset js-modal-close graph-modal__close" aria-label="<?php esc_attr_e( 'Close dialog', 'studio-frame' ); ?>"></button>
		<div class="graph-modal__content">
			<div class="form-wrapper">
				<h3 class="form-title"><?php esc_html_e( 'Book a photo session', 'studio-frame' ); ?></h3>
				<?php get_template_part( 'template-parts/contact/contact-form', null, array( 'context' => 'booking', 'project_id' => $sf_post_id ) ); ?>
				<div class="form-info">
					<p class="form-info__text">
						<?php
						$sf_custom_notice = get_theme_mod( 'sf_contact_form_notice', '' );
						if ( $sf_custom_notice ) {
							echo wp_kses_post( $sf_custom_notice );
						} else {
							$sf_privacy_url = get_privacy_policy_url();
							if ( $sf_privacy_url ) {
								printf(
									/* translators: %s: link to the site's Privacy Policy page */
									esc_html__( 'By submitting this form you agree to the %s.', 'studio-frame' ),
									'<a class="form-info__link" href="' . esc_url( $sf_privacy_url ) . '">' . esc_html__( 'Privacy Policy', 'studio-frame' ) . '</a>' // phpcs:ignore -- link markup intentionally passed as translatable %s.
								);
							} else {
								esc_html_e( 'By submitting this form you agree to the processing of your personal data.', 'studio-frame' );
							}
						}
						?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
