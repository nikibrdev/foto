<?php
/**
 * A single portfolio card, used on the home page teaser and the projects
 * archive/catalogue. Pass `$args['post_id']` and `$args['orientation']`
 * ('horizontal' spans two grid columns, 'vertical' spans one):
 *
 *     get_template_part( 'template-parts/project/card', null, array(
 *         'post_id'     => $post_id,
 *         'orientation' => 'horizontal',
 *     ) );
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_post_id     = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : 0;
$sf_orientation = isset( $args['orientation'] ) && 'vertical' === $args['orientation'] ? 'vertical' : 'horizontal';

if ( ! $sf_post_id ) {
	return;
}

$sf_size = 'vertical' === $sf_orientation ? 'sf-project-vertical' : 'sf-project-horizontal';
$sf_img_main  = sf_get_project_gallery_image( $sf_post_id, 0, $sf_size );
$sf_img_hover = sf_get_project_gallery_image( $sf_post_id, 1, $sf_size );
if ( ! $sf_img_hover ) {
	$sf_img_hover = $sf_img_main;
}

$sf_categories = sf_get_project_categories( $sf_post_id );
$sf_category_name = ! empty( $sf_categories ) ? $sf_categories[0]->name : '';
?>
<a class="project__card project__card--<?php echo esc_attr( $sf_orientation ); ?>" href="<?php echo esc_url( get_permalink( $sf_post_id ) ); ?>">
	<div class="project__card-img-wrap">
		<?php if ( $sf_img_main ) : ?>
			<img class="project__card-img" src="<?php echo esc_url( $sf_img_main ); ?>" alt="<?php echo esc_attr( get_the_title( $sf_post_id ) ); ?>">
		<?php endif; ?>
		<?php if ( $sf_img_hover ) : ?>
			<img class="project__card-img project__card-img--hidden" src="<?php echo esc_url( $sf_img_hover ); ?>" alt="">
		<?php endif; ?>
	</div>
	<div class="project__card-info">
		<?php if ( $sf_category_name ) : ?>
			<div class="project__category">
				<span class="project__category-name"><?php echo esc_html( $sf_category_name ); ?></span>
				<img class="project__card-icon" loading="lazy" src="<?php echo esc_url( SF_URI . '/assets/img/icons/arrow-up-right-white.svg' ); ?>" width="24" height="24" alt="">
			</div>
		<?php endif; ?>
		<div class="project__name"><?php echo esc_html( get_the_title( $sf_post_id ) ); ?></div>
	</div>
</a>
