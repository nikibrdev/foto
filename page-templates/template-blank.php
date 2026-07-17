<?php
/**
 * Template Name: Blank canvas (no extra sections)
 *
 * Just the header, the Page's own block-editor content, and the footer.
 * Use this when you want to build a page freely with Gutenberg blocks and
 * patterns without any of the theme's built-in sections.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<div class="container sf-blank-page">
	<?php sf_breadcrumbs(); ?>
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<h1 class="sf-blank-page__title"><?php the_title(); ?></h1>
		<div class="sf-blank-page__content"><?php the_content(); ?></div>
		<?php
	endwhile;
	?>
</div>
<?php
get_footer();
