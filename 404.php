<?php
/**
 * 404 error page.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<section class="hero sf-404">
	<div class="container">
		<div class="hero__inner">
			<h2 class="hero__subtitle"><?php esc_html_e( '404', 'studio-frame' ); ?></h2>
			<h1 class="hero__title"><?php esc_html_e( 'This page could not be found.', 'studio-frame' ); ?></h1>
		</div>
		<a class="hero__link btn-main" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="btn-main__inner">
				<span class="btn-main__default"><?php esc_html_e( 'Back to home', 'studio-frame' ); ?></span>
				<span class="btn-main__hover"><?php esc_html_e( 'Back to home', 'studio-frame' ); ?></span>
			</span>
		</a>
	</div>
</section>
<?php
get_footer();
