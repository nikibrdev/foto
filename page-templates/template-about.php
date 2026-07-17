<?php
/**
 * Template Name: About the photographer
 *
 * Bio hero, CTA, a strip of projects, FAQ and contacts. Assign this template
 * to any Page from the "Page Attributes" panel in the editor.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<?php sf_breadcrumbs(); ?>
<?php get_template_part( 'template-parts/about/about-hero' ); ?>
<?php get_template_part( 'template-parts/home/cta' ); ?>
<?php get_template_part( 'template-parts/project/more-slider', null, array( 'title' => __( 'My projects', 'studio-frame' ) ) ); ?>
<?php get_template_part( 'template-parts/home/faq' ); ?>
<?php get_template_part( 'template-parts/contact/contact-info' ); ?>
<?php
get_footer();
