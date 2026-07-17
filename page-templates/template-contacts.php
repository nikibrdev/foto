<?php
/**
 * Template Name: Contacts
 *
 * A slim page with just breadcrumbs and the contacts section. Assign this
 * template to any Page from the "Page Attributes" panel in the editor.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<?php sf_breadcrumbs(); ?>
<?php get_template_part( 'template-parts/contact/contact-info' ); ?>
<?php
get_footer();
