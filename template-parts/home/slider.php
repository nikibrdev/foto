<?php
/**
 * Home page hero slider: featured projects (checked "Show in homepage
 * slider" in the Project editor). Silently renders nothing until at least
 * one project has been marked as featured.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_slider_query = new WP_Query(
	array(
		'post_type'      => 'project',
		'posts_per_page' => 6,
		'meta_key'       => 'project_show_in_slider',
		'meta_value'     => 'on',
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);

if ( ! $sf_slider_query->have_posts() ) {
	return;
}
?>
<div class="swiper slider">
	<div class="swiper-wrapper">
		<?php
		while ( $sf_slider_query->have_posts() ) :
			$sf_slider_query->the_post();
			$sf_status = sf_get_project_status( get_the_ID() );
			$sf_img_main   = sf_get_project_gallery_image( get_the_ID(), 0, 'sf-slider-main' );
			$sf_img_side   = sf_get_project_gallery_image( get_the_ID(), 1, 'sf-slider-side' );
			$sf_img_bottom = sf_get_project_gallery_image( get_the_ID(), 2, 'sf-slider-bottom' );
			$sf_excerpt    = get_post_meta( get_the_ID(), 'project_short_description', true );
			if ( ! $sf_excerpt ) {
				$sf_excerpt = get_the_excerpt();
			}
			?>
			<div class="swiper-slide slider__item">
				<div class="slider__img-box">
					<?php if ( $sf_img_main ) : ?>
						<div class="slider__img-main-wrap">
							<img class="slider__img-main" src="<?php echo esc_url( $sf_img_main ); ?>" alt="<?php the_title_attribute(); ?>" width="945" height="597">
						</div>
					<?php endif; ?>
					<?php if ( $sf_img_side ) : ?>
						<div class="slider__img-right-wrap">
							<img class="slider__img-right" src="<?php echo esc_url( $sf_img_side ); ?>" alt="" width="292" height="438">
						</div>
					<?php endif; ?>
					<?php if ( $sf_img_bottom ) : ?>
						<div class="slider__img-bottom-wrap">
							<img class="slider__img-bottom" src="<?php echo esc_url( $sf_img_bottom ); ?>" alt="" width="205" height="307">
						</div>
					<?php endif; ?>
				</div>
				<div class="slider__content">
					<?php if ( $sf_status ) : ?>
						<div class="slider__status">
							<div class="slider__item-label"></div>
							<div class="slider__status-text"><?php echo esc_html( $sf_status->name ); ?></div>
						</div>
					<?php endif; ?>
					<h3 class="slider__item-title"><?php the_title(); ?></h3>
					<?php if ( $sf_excerpt ) : ?>
						<p class="slider__item-text"><?php echo esc_html( $sf_excerpt ); ?></p>
					<?php endif; ?>
					<a class="slider__item-link btn-main" href="<?php the_permalink(); ?>">
						<span class="btn-main__inner">
							<span class="btn-main__default"><?php esc_html_e( 'Learn more', 'studio-frame' ); ?></span>
							<span class="btn-main__hover"><?php esc_html_e( 'Learn more', 'studio-frame' ); ?></span>
						</span>
					</a>
				</div>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
		?>
	</div>
	<div class="slider__btns">
		<div class="slider__btn-prev"><?php esc_html_e( 'Prev', 'studio-frame' ); ?></div>
		<div class="swiper-pagination"></div>
		<div class="slider__btn-next"><?php esc_html_e( 'Next', 'studio-frame' ); ?></div>
	</div>
</div>
