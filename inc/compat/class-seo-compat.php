<?php
/**
 * A minimal built-in meta description / Open Graph fallback, used only
 * when no SEO plugin (Yoast SEO, RankMath, etc.) is active. As soon as one
 * of those is detected, this theme steps out of the way entirely so their
 * output is never duplicated.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether a dedicated SEO plugin is handling meta output already.
 */
function sf_has_seo_plugin() {
	return defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || defined( 'AIOSEO_VERSION' ) || class_exists( 'All_in_One_SEO_Pack' );
}

/**
 * Output a basic meta description + Open Graph tags in <head>.
 */
function sf_output_basic_meta_tags() {
	if ( sf_has_seo_plugin() ) {
		return;
	}

	$description = '';
	$image       = '';
	$title       = get_bloginfo( 'name' );

	if ( is_singular() ) {
		global $post;
		$description = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( wp_strip_all_tags( $post->post_content ), 30 );
		if ( has_post_thumbnail( $post ) ) {
			$image = get_the_post_thumbnail_url( $post, 'large' );
		}
		$title = get_the_title( $post );
	} elseif ( is_post_type_archive( 'project' ) ) {
		$description = get_bloginfo( 'description' );
		$title       = post_type_archive_title( '', false );
	} else {
		$description = get_bloginfo( 'description' );
	}

	$description = trim( wp_strip_all_tags( $description ) );

	if ( $description ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
	}

	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:type" content="%s">' . "\n", is_singular() ? 'article' : 'website' );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	if ( $description ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $description ) );
	}
	if ( $image ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	}
}
add_action( 'wp_head', 'sf_output_basic_meta_tags', 1 );
