<?php
/**
 * Single category view of the portfolio archive (the no-JS / SEO-friendly
 * fallback for the catalog filter buttons on archive-project.php).
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
		<h1 class="catalog__title"><?php single_term_title(); ?></h1>

		<?php sf_breadcrumbs(); ?>

		<div class="catalog__btns">
			<a class="catalog__btn" href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ); ?>"><?php esc_html_e( 'All projects', 'studio-frame' ); ?></a>
			<?php
			$sf_categories = get_terms(
				array(
					'taxonomy'   => 'project_category',
					'hide_empty' => true,
				)
			);
			if ( ! is_wp_error( $sf_categories ) ) :
				foreach ( $sf_categories as $sf_term ) :
					$sf_is_current = is_tax( 'project_category', $sf_term->term_id );
					?>
					<a class="catalog__btn<?php echo $sf_is_current ? ' active' : ''; ?>" href="<?php echo esc_url( get_term_link( $sf_term ) ); ?>"><?php echo esc_html( $sf_term->name ); ?></a>
					<?php
				endforeach;
			endif;
			?>
		</div>

		<div class="catalog__inner">
			<?php
			$sf_index = 0;
			while ( have_posts() ) :
				the_post();
				$sf_post_id     = get_the_ID();
				$sf_orientation = ( 0 === $sf_index % 2 ) ? 'horizontal' : 'vertical';
				$sf_index++;
				?>
				<div class="project" data-category="<?php echo esc_attr( sf_get_project_category_slugs( $sf_post_id ) ); ?>">
					<?php get_template_part( 'template-parts/project/card', null, array( 'post_id' => $sf_post_id, 'orientation' => $sf_orientation ) ); ?>
				</div>
				<?php
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
