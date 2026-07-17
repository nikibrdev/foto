<?php
/**
 * Footer navigation. Falls back to Projects / Contact when no "Footer Menu"
 * has been assigned yet under Appearance > Menus.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( has_nav_menu( 'footer' ) ) :
	wp_nav_menu(
		array(
			'theme_location'  => 'footer',
			'container'       => 'nav',
			'container_class' => 'footer-nav',
			'menu_class'      => 'footer-nav__list',
			'menu_id'         => false,
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'link_before'     => '<span class="btn-main__inner"><span class="btn-main__default">',
			'link_after'      => '</span></span>',
			'depth'           => 1,
			'fallback_cb'     => false,
		)
	);
else :
	$sf_footer_links = array(
		array(
			'label' => __( 'Projects', 'studio-frame' ),
			'url'   => get_post_type_archive_link( 'project' ),
		),
		array(
			'label' => __( 'Contact', 'studio-frame' ),
			'url'   => home_url( '/#contacts' ),
		),
	);
	?>
	<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer menu', 'studio-frame' ); ?>">
		<ul class="footer-nav__list">
			<?php foreach ( $sf_footer_links as $sf_link ) : ?>
				<li class="footer-nav__item">
					<a href="<?php echo esc_url( $sf_link['url'] ); ?>" class="footer-nav__link btn-main btn-main--white">
						<span class="btn-main__inner">
							<span class="btn-main__default"><?php echo esc_html( $sf_link['label'] ); ?></span>
							<span class="btn-main__hover"><?php echo esc_html( $sf_link['label'] ); ?></span>
						</span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>
	<?php
endif;
