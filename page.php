<?php
/**
 * Default template for any WordPress Page that hasn't been assigned one of
 * the theme's custom page templates.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<div class="container sf-page">
	<?php sf_breadcrumbs(); ?>
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'sf-page__article' ); ?>>
			<h1 class="sf-page__title"><?php the_title(); ?></h1>
			<div class="sf-page__content">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="sf-page__pagination">' . esc_html__( 'Pages:', 'studio-frame' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>
		</article>
		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</div>
<?php
get_footer();
