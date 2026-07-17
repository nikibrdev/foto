<?php
/**
 * Project sidebar: availability status, category, date and price, plus the
 * "Book now" button that opens the booking form modal.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_post_id = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : get_the_ID();

$sf_status     = sf_get_project_status( $sf_post_id );
$sf_categories = sf_get_project_categories( $sf_post_id );
$sf_date_text  = get_post_meta( $sf_post_id, 'project_date_text', true );
$sf_price      = sf_get_project_price( $sf_post_id );
$sf_badge_color = $sf_status ? get_term_meta( $sf_status->term_id, 'status_badge_color', true ) : '';
?>
<div class="section-project__info aside">
	<div class="aside__info-box">
		<?php if ( $sf_status ) : ?>
			<div class="aside__info-item">
				<div class="aside__info-label"><?php esc_html_e( 'Availability:', 'studio-frame' ); ?></div>
				<div class="aside__info-value aside__info-value--availability" <?php echo $sf_badge_color ? 'style="--green-color: ' . esc_attr( $sf_badge_color ) . ';"' : ''; ?>>
					<?php echo esc_html( $sf_status->name ); ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $sf_categories ) ) : ?>
			<div class="aside__info-item">
				<div class="aside__info-label"><?php esc_html_e( 'Category:', 'studio-frame' ); ?></div>
				<div class="aside__info-value"><?php echo esc_html( wp_list_pluck( $sf_categories, 'name' )[0] ); ?></div>
			</div>
		<?php endif; ?>
		<?php if ( $sf_date_text ) : ?>
			<div class="aside__info-item">
				<div class="aside__info-label"><?php esc_html_e( 'Date:', 'studio-frame' ); ?></div>
				<div class="aside__info-value"><?php echo esc_html( $sf_date_text ); ?></div>
			</div>
		<?php endif; ?>
		<?php if ( $sf_price ) : ?>
			<div class="aside__info-item">
				<div class="aside__info-label"><?php esc_html_e( 'Price:', 'studio-frame' ); ?></div>
				<div class="aside__info-value"><?php echo esc_html( $sf_price ); ?></div>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( has_excerpt( $sf_post_id ) || get_the_content( null, false, $sf_post_id ) ) : ?>
		<div class="aside__text-box">
			<?php if ( has_excerpt( $sf_post_id ) ) : ?>
				<p class="aside__text"><?php echo esc_html( get_the_excerpt( $sf_post_id ) ); ?></p>
			<?php else : ?>
				<div class="aside__text"><?php echo wp_kses_post( apply_filters( 'the_content', get_the_content( null, false, $sf_post_id ) ) ); ?></div>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php
	$sf_button_label = get_post_meta( $sf_post_id, 'project_booking_button_label', true );
	if ( ! $sf_button_label ) {
		$sf_button_label = __( 'Book now', 'studio-frame' );
	}
	?>
	<button class="aside__btn btn-main" data-graph-path="modal-project-<?php echo esc_attr( $sf_post_id ); ?>">
		<span class="btn-main__inner">
			<span class="btn-main__default"><?php echo esc_html( $sf_button_label ); ?></span>
			<span class="btn-main__hover"><?php echo esc_html( $sf_button_label ); ?></span>
		</span>
	</button>

	<?php get_template_part( 'template-parts/project/booking-modal', null, array( 'post_id' => $sf_post_id ) ); ?>
</div>
