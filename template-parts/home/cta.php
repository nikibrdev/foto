<?php
/**
 * Full-width call-to-action band with a background image, shown on the home
 * page and every project page. Configured in Customizer > Studio Frame > CTA.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_cta_title    = get_theme_mod( 'sf_cta_title', __( 'Want to become part of a visual story?', 'studio-frame' ) );
$sf_cta_text     = get_theme_mod( 'sf_cta_text', __( 'Pick one of the projects below or pitch your own idea.', 'studio-frame' ) );
$sf_cta_bg_image = get_theme_mod( 'sf_cta_bg_image', '' );

$sf_cta_primary_label   = get_theme_mod( 'sf_cta_primary_label', __( 'Choose a project', 'studio-frame' ) );
$sf_cta_primary_url     = get_theme_mod( 'sf_cta_primary_url', get_post_type_archive_link( 'project' ) );
$sf_cta_secondary_label = get_theme_mod( 'sf_cta_secondary_label', __( 'Discuss your project', 'studio-frame' ) );
$sf_cta_secondary_url   = get_theme_mod( 'sf_cta_secondary_url', home_url( '/#contacts' ) );
?>
<div class="sta">
	<?php if ( $sf_cta_bg_image ) : ?>
		<div class="sta__parallax" style="background-image: url('<?php echo esc_url( $sf_cta_bg_image ); ?>');"></div>
	<?php endif; ?>
	<div class="sta__inner">
		<h3 class="sta__title"><?php echo esc_html( $sf_cta_title ); ?></h3>
		<p class="sta__text"><?php echo esc_html( $sf_cta_text ); ?></p>
		<div class="sta__links">
			<a class="sta__link btn-secondary btn-secondary--white" href="<?php echo esc_url( $sf_cta_primary_url ); ?>">
				<span class="btn-secondary__inner">
					<span class="btn-secondary__default"><?php echo esc_html( $sf_cta_primary_label ); ?></span>
					<span class="btn-secondary__hover"><?php echo esc_html( $sf_cta_primary_label ); ?></span>
				</span>
			</a>
			<a class="sta__link btn-subtitle" href="<?php echo esc_url( $sf_cta_secondary_url ); ?>">
				<span class="btn-subtitle__inner">
					<span class="btn-subtitle__default"><?php echo esc_html( $sf_cta_secondary_label ); ?></span>
					<span class="btn-subtitle__hover"><?php echo esc_html( $sf_cta_secondary_label ); ?></span>
				</span>
			</a>
		</div>
	</div>
</div>
