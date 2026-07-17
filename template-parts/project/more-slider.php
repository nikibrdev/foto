<?php
/**
 * Auto-scrolling strip of other projects. Used on the single project page
 * ("More projects") and the About page ("My projects").
 *
 * Optional $args:
 *   'exclude' (int)    post ID to leave out (the project currently viewed)
 *   'title'   (string) section heading override
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_exclude = isset( $args['exclude'] ) ? absint( $args['exclude'] ) : 0;
$sf_title   = isset( $args['title'] ) ? $args['title'] : __( 'More projects', 'studio-frame' );

$sf_more_query = new WP_Query(
	array(
		'post_type'      => 'project',
		'posts_per_page' => 8,
		'post__not_in'   => $sf_exclude ? array( $sf_exclude ) : array(),
		'orderby'        => 'date',
		'order'          => 'DESC',
		'no_found_rows'  => true,
	)
);

if ( ! $sf_more_query->have_posts() ) {
	return;
}
?>
<section class="more">
	<div class="container">
		<div class="more__inner">
			<h2 class="more__title"><?php echo esc_html( $sf_title ); ?></h2>
			<a class="more__link btn-secondary" href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ); ?>">
				<span class="btn-secondary__inner">
					<span class="btn-secondary__default"><?php esc_html_e( 'View all', 'studio-frame' ); ?></span>
					<span class="btn-secondary__hover"><?php esc_html_e( 'View all', 'studio-frame' ); ?></span>
				</span>
			</a>
		</div>
	</div>
	<div class="swiper more__slider">
		<div class="swiper-wrapper more__swiper-wrapper">
			<?php
			while ( $sf_more_query->have_posts() ) :
				$sf_more_query->the_post();
				$sf_img = sf_get_project_gallery_image( get_the_ID(), 0, 'sf-more-slide' );
				if ( ! $sf_img ) {
					continue;
				}
				?>
				<a class="swiper-slide more__slide" href="<?php the_permalink(); ?>">
					<div class="more__img-wrap">
						<img class="more__img" src="<?php echo esc_url( $sf_img ); ?>" alt="<?php the_title_attribute(); ?>" width="556" height="690">
					</div>
				</a>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
