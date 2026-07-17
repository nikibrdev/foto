<?php
/**
 * Search results.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<div class="container sf-search-results">
	<?php sf_breadcrumbs(); ?>
	<h1 class="sf-search-results__title">
		<?php
		/* translators: %s: search query */
		printf( esc_html__( 'Search results for: %s', 'studio-frame' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
		?>
	</h1>

	<?php if ( have_posts() ) : ?>
		<div class="sf-post-list">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'sf-post-list__item' ); ?>>
					<h2 class="sf-post-list__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="sf-post-list__excerpt"><?php the_excerpt(); ?></div>
				</article>
				<?php
			endwhile;
			?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing was found for this search.', 'studio-frame' ); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</div>
<?php
get_footer();
