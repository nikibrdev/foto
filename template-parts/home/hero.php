<?php
/**
 * Home page hero: subtitle, headline and a CTA linking to the projects
 * archive. All copy is editable from Customizer > Studio Frame > Hero.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_hero_subtitle    = get_theme_mod( 'sf_hero_subtitle', get_bloginfo( 'name' ) );
$sf_hero_title       = get_theme_mod( 'sf_hero_title', __( 'Art photography with a story. Images you believe in.', 'studio-frame' ) );
$sf_hero_button_label = get_theme_mod( 'sf_hero_button_label', __( 'Choose a project', 'studio-frame' ) );
$sf_hero_button_url   = get_theme_mod( 'sf_hero_button_url', get_post_type_archive_link( 'project' ) );
?>
<section class="hero">
	<div class="container">
		<div class="hero__inner">
			<h2 class="hero__subtitle"><?php echo esc_html( $sf_hero_subtitle ); ?></h2>
			<h1 class="hero__title"><?php echo esc_html( $sf_hero_title ); ?></h1>
		</div>
		<a class="hero__link btn-main" href="<?php echo esc_url( $sf_hero_button_url ); ?>">
			<span class="btn-main__inner">
				<span class="btn-main__default"><?php echo esc_html( $sf_hero_button_label ); ?></span>
				<span class="btn-main__hover"><?php echo esc_html( $sf_hero_button_label ); ?></span>
			</span>
		</a>
	</div>
</section>
