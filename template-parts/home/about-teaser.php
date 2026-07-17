<?php
/**
 * Home page "about" teaser: bio excerpt plus a 6-photo collage. Configured
 * in Customizer > Studio Frame > About.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_about_title = get_theme_mod( 'sf_about_title', __( 'Photography that feels like a story, told frame by frame.', 'studio-frame' ) );
$sf_about_text  = get_theme_mod( 'sf_about_text', __( 'Every shoot is planned like a scene: mood, storyline and a visual signature. My sessions are not just photographs — they are an aesthetic experience you can live through and keep.', 'studio-frame' ) );
$sf_about_link_label = get_theme_mod( 'sf_about_link_label', __( 'More about me', 'studio-frame' ) );
$sf_about_link_url   = get_theme_mod( 'sf_about_link_url', '' );

$sf_about_images = array();
for ( $i = 1; $i <= 6; $i++ ) {
	$image = get_theme_mod( 'sf_about_image_' . $i, '' );
	if ( $image ) {
		$sf_about_images[] = $image;
	}
}
?>
<section class="about">
	<div class="about__fixed">
		<div class="container">
			<div class="about__inner">
				<div class="about__info">
					<h2 class="about__title"><?php echo esc_html( $sf_about_title ); ?></h2>
					<p class="about__text"><?php echo esc_html( $sf_about_text ); ?></p>
					<?php if ( $sf_about_link_url ) : ?>
						<a class="about__link btn-main" href="<?php echo esc_url( $sf_about_link_url ); ?>">
							<span class="btn-main__inner">
								<span class="btn-main__default"><?php echo esc_html( $sf_about_link_label ); ?></span>
								<span class="btn-main__hover"><?php echo esc_html( $sf_about_link_label ); ?></span>
							</span>
						</a>
					<?php endif; ?>
				</div>
				<?php if ( ! empty( $sf_about_images ) ) : ?>
					<div class="about__images">
						<?php foreach ( $sf_about_images as $sf_image_url ) : ?>
							<div class="about__img-wrap">
								<img class="about__img" loading="lazy" src="<?php echo esc_url( $sf_image_url ); ?>" width="272" height="250" alt="">
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
