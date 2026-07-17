<?php
/**
 * About page hero: name headline, portrait, bio intro and a short list of
 * "how I work" points. Content lives on the WordPress Page itself (the one
 * assigned the "About the photographer" template) — edit the title, featured
 * image and the fields below the main editor.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_page_id = get_the_ID();
$sf_title   = get_the_title( $sf_page_id );
if ( ! $sf_title ) {
	$sf_title = get_bloginfo( 'name' );
}

$sf_text      = get_post_meta( $sf_page_id, 'about_hero_text', true );
$sf_statement = get_post_meta( $sf_page_id, 'about_hero_statement', true );
$sf_points    = get_post_meta( $sf_page_id, 'about_hero_points', true );
if ( ! is_array( $sf_points ) ) {
	$sf_points = array();
}
?>
<section class="about-hero">
	<div class="container">
		<div class="about-hero__headline">
			<h1 class="about-hero__title"><?php echo esc_html( $sf_title ); ?></h1>
		</div>
		<?php if ( has_post_thumbnail( $sf_page_id ) ) : ?>
			<div class="about-hero__img-wrap">
				<?php echo get_the_post_thumbnail( $sf_page_id, 'full', array( 'class' => 'about-hero__img', 'alt' => $sf_title ) ); ?>
			</div>
		<?php endif; ?>
		<div class="about-hero__top">
			<h2 class="about-hero__subtitle"><?php echo esc_html( $sf_title ); ?></h2>
			<?php if ( $sf_text ) : ?>
				<p class="about-hero__text"><?php echo wp_kses_post( nl2br( esc_html( $sf_text ) ) ); ?></p>
			<?php endif; ?>
		</div>
		<?php if ( $sf_statement || ! empty( $sf_points ) ) : ?>
			<div class="about-hero__bottom">
				<?php if ( $sf_statement ) : ?>
					<h3 class="about-hero__bottom-title"><?php echo esc_html( $sf_statement ); ?></h3>
				<?php endif; ?>
				<?php if ( ! empty( $sf_points ) ) : ?>
					<ol class="about-hero__list">
						<?php foreach ( $sf_points as $sf_point ) : ?>
							<?php if ( empty( $sf_point['point_title'] ) && empty( $sf_point['point_text'] ) ) continue; ?>
							<li class="about-hero__item">
								<?php if ( ! empty( $sf_point['point_title'] ) ) : ?>
									<h4 class="about-hero__item-title"><?php echo esc_html( $sf_point['point_title'] ); ?></h4>
								<?php endif; ?>
								<?php if ( ! empty( $sf_point['point_text'] ) ) : ?>
									<p class="about-hero__item-text"><?php echo esc_html( $sf_point['point_text'] ); ?></p>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ol>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
