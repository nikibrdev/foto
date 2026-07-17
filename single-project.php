<?php
/**
 * Single portfolio project: title, gallery, details sidebar (status,
 * category, date, price) with a booking form, plus related projects.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$sf_post_id = get_the_ID();
	?>
	<section class="section-project">
		<div class="container">
			<h1 class="section-project__title"><?php the_title(); ?></h1>

			<?php sf_breadcrumbs(); ?>

			<div class="section-project__inner">
				<?php get_template_part( 'template-parts/project/gallery', null, array( 'post_id' => $sf_post_id ) ); ?>
				<?php get_template_part( 'template-parts/project/details-aside', null, array( 'post_id' => $sf_post_id ) ); ?>
			</div>
		</div>
	</section>
	<?php
endwhile;
?>
<?php get_template_part( 'template-parts/home/cta' ); ?>
<?php get_template_part( 'template-parts/project/more-slider', null, array( 'exclude' => isset( $sf_post_id ) ? $sf_post_id : 0 ) ); ?>
<?php get_template_part( 'template-parts/contact/contact-info' ); ?>
<?php
get_footer();
