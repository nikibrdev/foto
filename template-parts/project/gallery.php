<?php
/**
 * Project photo gallery. Reads the "Gallery" CMB2 field on the Project post.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_post_id = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : get_the_ID();
$sf_ids     = sf_get_project_gallery_ids( $sf_post_id );

if ( empty( $sf_ids ) && has_post_thumbnail( $sf_post_id ) ) {
	$sf_ids = array( get_post_thumbnail_id( $sf_post_id ) );
}

if ( empty( $sf_ids ) ) {
	return;
}
?>
<div class="section-project__gallery">
	<?php foreach ( $sf_ids as $sf_attachment_id ) : ?>
		<div class="section-project__img-wrap">
			<?php
			echo wp_get_attachment_image(
				$sf_attachment_id,
				'sf-gallery-wide',
				false,
				array(
					'class'   => 'section-project__img',
					'loading' => 'lazy',
				)
			);
			?>
		</div>
	<?php endforeach; ?>
</div>
