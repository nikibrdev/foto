<?php
/**
 * Reusable template helpers shared across theme templates.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add a `data-menu-item` attribute to every primary/footer menu link so the
 * burger.js mobile-menu script can close the menu when a link is clicked.
 */
function sf_nav_menu_link_attributes( $atts ) {
	$atts['data-menu-item'] = '';
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'sf_nav_menu_link_attributes' );

/**
 * Format a project's "from" price for display, e.g. "from $500".
 *
 * @param int $post_id Project post ID.
 * @return string Escaped-safe plain text, empty string if no price is set.
 */
function sf_get_project_price( $post_id ) {
	$amount = get_post_meta( $post_id, 'project_price_amount', true );
	if ( '' === $amount ) {
		return '';
	}

	$note = get_post_meta( $post_id, 'project_price_note', true );

	/* translators: %s: price amount, e.g. "$500" */
	$price = sprintf( __( 'from %s', 'studio-frame' ), $amount );

	if ( $note ) {
		$price .= ' (' . $note . ')';
	}

	return $price;
}

/**
 * Get the project's status term (the taxonomy replaces the old hardcoded
 * "booking open" / "available again" labels).
 *
 * @param int $post_id Project post ID.
 * @return WP_Term|null
 */
function sf_get_project_status( $post_id ) {
	$terms = get_the_terms( $post_id, 'project_status' );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return null;
	}
	return $terms[0];
}

/**
 * Get the project's category terms.
 *
 * @param int $post_id Project post ID.
 * @return WP_Term[]
 */
function sf_get_project_categories( $post_id ) {
	$terms = get_the_terms( $post_id, 'project_category' );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return array();
	}
	return $terms;
}

/**
 * Space-separated list of category slugs for a project, used in the
 * `data-category` attribute that assets/js/src/components/catalog-filter.js
 * reads to filter cards client-side.
 *
 * @param int $post_id Project post ID.
 * @return string
 */
function sf_get_project_category_slugs( $post_id ) {
	$terms = sf_get_project_categories( $post_id );
	if ( empty( $terms ) ) {
		return '';
	}
	return implode( ' ', wp_list_pluck( $terms, 'slug' ) );
}

/**
 * Render breadcrumbs for the current request. No-op (returns nothing) when
 * an SEO plugin already provides its own breadcrumb function, so the two
 * never render twice.
 */
function sf_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) || function_exists( 'rank_math_the_breadcrumbs' ) ) {
		return;
	}

	$items = array(
		array(
			'label' => esc_html__( 'Home', 'studio-frame' ),
			'url'   => home_url( '/' ),
		),
	);

	if ( is_singular( 'project' ) ) {
		$items[] = array(
			'label' => esc_html__( 'Projects', 'studio-frame' ),
			'url'   => get_post_type_archive_link( 'project' ),
		);
		$items[] = array(
			'label' => get_the_title(),
			'url'   => '',
		);
	} elseif ( is_post_type_archive( 'project' ) ) {
		$items[] = array(
			'label' => esc_html__( 'Projects', 'studio-frame' ),
			'url'   => '',
		);
	} elseif ( is_tax( 'project_category' ) ) {
		$items[] = array(
			'label' => esc_html__( 'Projects', 'studio-frame' ),
			'url'   => get_post_type_archive_link( 'project' ),
		);
		$items[] = array(
			'label' => single_term_title( '', false ),
			'url'   => '',
		);
	} elseif ( is_page() ) {
		$items[] = array(
			'label' => get_the_title(),
			'url'   => '',
		);
	} elseif ( is_search() ) {
		$items[] = array(
			/* translators: %s: search query */
			'label' => sprintf( esc_html__( 'Search results for "%s"', 'studio-frame' ), get_search_query() ),
			'url'   => '',
		);
	} elseif ( is_404() ) {
		$items[] = array(
			'label' => esc_html__( 'Page not found', 'studio-frame' ),
			'url'   => '',
		);
	}

	if ( count( $items ) < 2 ) {
		return;
	}

	echo '<div class="breadcrumbs"><div class="container"><ul class="breadcrumbs__list">';
	foreach ( $items as $item ) {
		echo '<li class="breadcrumbs__item">';
		if ( ! empty( $item['url'] ) ) {
			printf( '<a class="breadcrumbs__link" href="%1$s">%2$s</a>', esc_url( $item['url'] ), esc_html( $item['label'] ) );
		} else {
			printf( '<span class="breadcrumbs__link">%s</span>', esc_html( $item['label'] ) );
		}
		echo '</li>';
	}
	echo '</ul></div></div>';
}

/**
 * Social network links configured in the Customizer, keyed by slug.
 *
 * @return array<string, string> Non-empty links only.
 */
function sf_get_social_links() {
	$networks = array(
		'telegram'  => get_theme_mod( 'sf_social_telegram', '' ),
		'whatsapp'  => get_theme_mod( 'sf_social_whatsapp', '' ),
		'vk'        => get_theme_mod( 'sf_social_vk', '' ),
		'instagram' => get_theme_mod( 'sf_social_instagram', '' ),
		'youtube'   => get_theme_mod( 'sf_social_youtube', '' ),
	);

	return array_filter( $networks );
}

/**
 * Get the site's contact e-mail, falling back to the WordPress admin e-mail.
 *
 * @return string
 */
function sf_get_contact_email() {
	$email = get_theme_mod( 'sf_contact_email', '' );
	return $email ? $email : get_option( 'admin_email' );
}

/**
 * Attachment IDs stored in a project's CMB2 `file_list` gallery field, in
 * the order the user arranged them in.
 *
 * @param int $post_id Project post ID.
 * @return int[]
 */
function sf_get_project_gallery_ids( $post_id ) {
	$gallery = get_post_meta( $post_id, 'project_gallery', true );
	if ( empty( $gallery ) || ! is_array( $gallery ) ) {
		return array();
	}
	return array_map( 'absint', array_keys( $gallery ) );
}

/**
 * A single image URL from a project's gallery by position, with a graceful
 * fallback to the post thumbnail when the gallery doesn't have that many
 * images yet (keeps hero/slider layouts from breaking while content is
 * still being filled in).
 *
 * @param int    $post_id Project post ID.
 * @param int    $index   Zero-based position in the gallery.
 * @param string $size    Registered image size.
 * @return string Empty string if nothing is available.
 */
function sf_get_project_gallery_image( $post_id, $index, $size = 'sf-gallery-portrait' ) {
	$ids = sf_get_project_gallery_ids( $post_id );

	if ( isset( $ids[ $index ] ) ) {
		$url = wp_get_attachment_image_url( $ids[ $index ], $size );
		if ( $url ) {
			return $url;
		}
	}

	if ( 0 === $index && has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail_url( $post_id, $size );
	}

	return '';
}
