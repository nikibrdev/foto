<?php
/**
 * Home page projects teaser: a curated grid of projects (checked "Show on
 * homepage" in the Project editor), grouped by category, with a link to the
 * full portfolio archive.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_projects_query = new WP_Query(
	array(
		'post_type'      => 'project',
		'posts_per_page' => 6,
		'meta_key'       => 'project_show_in_teaser',
		'meta_value'     => '1',
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);

// Fall back to the most recent projects until the user has curated any.
if ( ! $sf_projects_query->have_posts() ) {
	$sf_projects_query = new WP_Query(
		array(
			'post_type'      => 'project',
			'posts_per_page' => 5,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'no_found_rows'  => true,
		)
	);
}

if ( ! $sf_projects_query->have_posts() ) {
	return;
}
?>
<section class="projects">
	<div class="container">
		<h2 class="projects__title"><?php esc_html_e( 'Stories you can live through', 'studio-frame' ); ?></h2>
		<div class="projects__inner">
			<?php
			$sf_index          = 0;
			$sf_last_category  = null;
			while ( $sf_projects_query->have_posts() ) :
				$sf_projects_query->the_post();
				$sf_post_id    = get_the_ID();
				$sf_categories = sf_get_project_categories( $sf_post_id );
				$sf_category   = ! empty( $sf_categories ) ? $sf_categories[0]->name : '';
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
			wp_reset_postdata();
			?>
			<a class="projects__btn btn-secondary" href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ); ?>">
				<span class="btn-secondary__inner">
					<span class="btn-secondary__default"><?php esc_html_e( 'More projects', 'studio-frame' ); ?></span>
					<span class="btn-secondary__hover"><?php esc_html_e( 'More projects', 'studio-frame' ); ?></span>
				</span>
			</a>
		</div>
	</div>
</section>
