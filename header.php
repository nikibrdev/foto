<?php
/**
 * The header for the theme: opens <html>, outputs <head>, and renders the
 * site header (logo, primary navigation, "discuss a project" CTA, burger).
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="page">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'page__body' ); ?>>
<?php wp_body_open(); ?>
<div class="site-container">
	<header class="header">
		<div class="container">
			<div class="header__inner">
				<?php get_template_part( 'template-parts/global/site-branding' ); ?>
				<?php get_template_part( 'template-parts/navigation/primary-nav' ); ?>
				<a class="header__link btn-secondary" href="#contacts">
					<span class="btn-secondary__inner">
						<span class="btn-secondary__default"><?php esc_html_e( 'Discuss a project', 'studio-frame' ); ?></span>
						<span class="btn-secondary__hover"><?php esc_html_e( 'Discuss a project', 'studio-frame' ); ?></span>
					</span>
				</a>
				<button class="btn-reset burger" aria-label="<?php esc_attr_e( 'Open menu', 'studio-frame' ); ?>" aria-expanded="false" data-burger>
					<span class="burger__line"></span>
				</button>
			</div>
		</div>
	</header>
	<main class="main">
