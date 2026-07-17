<?php
/**
 * Client testimonials (Testimonials CPT), most recent first.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_reviews_query = new WP_Query(
	array(
		'post_type'      => 'testimonial',
		'posts_per_page' => 6,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);

if ( ! $sf_reviews_query->have_posts() ) {
	return;
}
?>
<section class="reviews">
	<div class="container">
		<h2 class="reviews__title"><?php esc_html_e( 'Client reviews', 'studio-frame' ); ?></h2>
		<ul class="reviews__list">
			<?php
			while ( $sf_reviews_query->have_posts() ) :
				$sf_reviews_query->the_post();
				$sf_text = get_post_meta( get_the_ID(), 'testimonial_text', true );
				?>
				<li class="reviews__item">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="reviews__img-wrap">
							<?php the_post_thumbnail( 'sf-review-avatar', array( 'class' => 'reviews__img', 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
						</div>
					<?php endif; ?>
					<div class="reviews__item-content">
						<blockquote class="reviews__blockquote">
							<p class="reviews__blockquote-text"><?php echo esc_html( $sf_text ); ?></p>
						</blockquote>
						<div class="reviews__item-author"><?php the_title(); ?></div>
					</div>
				</li>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</ul>
	</div>
</section>
