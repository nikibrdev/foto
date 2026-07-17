<?php
/**
 * The default template. Used as the fallback for any request that doesn't
 * match a more specific template (e.g. blog posts, if the site chooses to
 * publish any).
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<div class="container">
	<?php sf_breadcrumbs(); ?>

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
		<p><?php esc_html_e( 'Nothing was found.', 'studio-frame' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
