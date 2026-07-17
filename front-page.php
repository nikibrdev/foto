<?php
/**
 * The static front page: hero, featured-project slider, "about" teaser,
 * projects teaser, call to action, reviews, contact form and FAQ.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<?php get_template_part( 'template-parts/home/hero' ); ?>
<?php get_template_part( 'template-parts/home/slider' ); ?>
<?php get_template_part( 'template-parts/home/about-teaser' ); ?>
<?php get_template_part( 'template-parts/home/projects-teaser' ); ?>
<?php get_template_part( 'template-parts/home/cta' ); ?>
<?php get_template_part( 'template-parts/home/reviews' ); ?>
<?php get_template_part( 'template-parts/contact/contact-info' ); ?>
<?php get_template_part( 'template-parts/home/faq' ); ?>
<?php
get_footer();
