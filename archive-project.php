<?php
/**
 * Portfolio archive: every published project, with a client-side category
 * filter (progressive enhancement — assets/js/src/components/catalog-filter.js)
 * and real taxonomy archive URLs underneath for SEO / no-JS visitors.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<section class="catalog">
	<div class="container">
		<h1 class="catalog__title"><?php post_type_archive_title(); ?></h1>

		<?php sf_breadcrumbs(); ?>

		<?php
		$sf_categories = get_terms(
			array(
				'taxonomy'   => 'project_category',
				'hide_empty' => true,
			)
		);
		if ( ! is_wp_error( $sf_categories ) && ! empty( $sf_categories ) ) :
			?>
			<div class="catalog__btns">
				<button class="catalog__btn active" data-filter="all"><?php esc_html_e( 'All projects', 'studio-frame' ); ?></button>
				<?php foreach ( $sf_categories as $sf_term ) : ?>
					<button class="catalog__btn" data-filter="<?php echo esc_attr( $sf_term->slug ); ?>"><?php echo esc_html( $sf_term->name ); ?></button>
				<?php endforeach; ?>
			</div>
			<noscript>
				<div class="catalog__btns">
					<?php foreach ( $sf_categories as $sf_term ) : ?>
						<a class="catalog__btn" href="<?php echo esc_url( get_term_link( $sf_term ) ); ?>"><?php echo esc_html( $sf_term->name ); ?></a>
					<?php endforeach; ?>
				</div>
			</noscript>
		<?php endif; ?>

		<div class="catalog__inner">
			<?php
			$sf_index         = 0;
			$sf_last_category = null;
			while ( have_posts() ) :
				the_post();
				$sf_post_id     = get_the_ID();
				$sf_categories2 = sf_get_project_categories( $sf_post_id );
				$sf_category    = ! empty( $sf_categories2 ) ? $sf_categories2[0]->name : '';
				$sf_orientation = ( 0 === $sf_index % 2 ) ? 'horizontal' : 'vertical';
				?>
				<div class="project" data-category="<?php echo esc_attr( sf_get_project_category_slugs( $sf_post_id ) ); ?>">
					<?php if ( $sf_category && $sf_category !== $sf_last_category ) : ?>
						<div class="project__card project__card--name">
							<div class="project__status">
								<h3 class="project__category-title"><?php echo esc_html( $sf_category ); ?></h3>
							</div>
						</div>
						<?php $sf_last_category = $sf_category; ?>
					<?php endif; ?>
					<?php get_template_part( 'template-parts/project/card', null, array( 'post_id' => $sf_post_id, 'orientation' => $sf_orientation ) ); ?>
				</div>
				<?php
				$sf_index++;
			endwhile;
			?>
		</div>

		<?php the_posts_pagination(); ?>
	</div>
</section>
<?php get_template_part( 'template-parts/home/cta' ); ?>
<?php get_template_part( 'template-parts/contact/contact-info' ); ?>
<?php
get_footer();
