<?php
/**
 * Frequently asked questions (FAQ CPT: title = question, content = answer).
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_faq_query = new WP_Query(
	array(
		'post_type'      => 'faq_item',
		'posts_per_page' => 20,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);

if ( ! $sf_faq_query->have_posts() ) {
	return;
}
?>
<section class="faq">
	<div class="container">
		<h2 class="faq__title"><?php esc_html_e( 'Frequently asked questions', 'studio-frame' ); ?></h2>
		<ol class="faq__list">
			<?php
			while ( $sf_faq_query->have_posts() ) :
				$sf_faq_query->the_post();
				?>
				<li class="faq__item">
					<span class="faq__item-question"><?php the_title(); ?></span>
					<span class="faq__item-answer"><?php the_content(); ?></span>
				</li>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</ol>
	</div>
</section>
