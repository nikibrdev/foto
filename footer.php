<?php
/**
 * The footer for the theme: closes <main> / .site-container and renders the
 * site footer (heading, portrait image, footer navigation).
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_footer_heading = get_theme_mod( 'sf_footer_heading', get_bloginfo( 'name' ) );
$sf_footer_image    = get_theme_mod( 'sf_footer_image', '' );
?>
	</main>
	<footer class="footer">
		<div class="container">
			<div class="footer__content">
				<h2 class="footer__title"><?php echo esc_html( $sf_footer_heading ); ?></h2>
				<?php if ( $sf_footer_image ) : ?>
					<div class="footer__img-wrap">
						<img class="footer__img" loading="lazy" src="<?php echo esc_url( $sf_footer_image ); ?>" width="556" height="688" alt="<?php echo esc_attr( $sf_footer_heading ); ?>">
					</div>
				<?php endif; ?>
			</div>
			<?php get_template_part( 'template-parts/global/footer-nav' ); ?>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
