<?php
/**
 * Site logo, linked to the home URL. Falls back to the site title as text
 * when no custom logo has been uploaded yet (Customizer > Site Identity).
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( has_custom_logo() ) :
	?>
	<div class="logo header__logo">
		<?php the_custom_logo(); ?>
	</div>
	<?php
else :
	?>
	<a class="logo header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<span class="logo__text"><?php bloginfo( 'name' ); ?></span>
	</a>
	<?php
endif;
