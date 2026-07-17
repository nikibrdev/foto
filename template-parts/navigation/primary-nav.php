<?php
/**
 * Primary navigation. Falls back to a sensible default menu (Home / Projects
 * / About / Contacts) so the header never looks broken before the user has
 * assigned a menu under Appearance > Menus.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( has_nav_menu( 'primary' ) ) :
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => 'nav',
			'container_class' => 'nav',
			'container_aria_label' => esc_attr__( 'Primary menu', 'studio-frame' ),
			'menu_class'     => 'nav__list',
			'menu_id'        => false,
			'items_wrap'     => '<ul id="%1$s" class="%2$s" data-menu>%3$s</ul>',
			'link_before'    => '<span class="nav__link-text">',
			'link_after'     => '</span>',
			'depth'          => 1,
			'fallback_cb'    => false,
		)
	);
else :
	?>
	<nav class="nav" aria-label="<?php esc_attr_e( 'Primary menu', 'studio-frame' ); ?>" data-menu>
		<ul class="nav__list">
			<li class="nav__item"><a class="nav__link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'studio-frame' ); ?></a></li>
			<li class="nav__item"><a class="nav__link" href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ); ?>"><?php esc_html_e( 'Projects', 'studio-frame' ); ?></a></li>
			<li class="nav__item"><a class="nav__link" href="#contacts"><?php esc_html_e( 'Contact', 'studio-frame' ); ?></a></li>
		</ul>
		<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
			<p class="nav__hint description">
				<?php esc_html_e( 'Only visible to you: create a menu under Appearance > Menus and assign it to "Primary Menu (header)" to replace this placeholder.', 'studio-frame' ); ?>
			</p>
		<?php endif; ?>
	</nav>
	<?php
endif;
