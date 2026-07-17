<?php
/**
 * Starter block patterns for the "Blank canvas" page template and the
 * default Page template, so buyers can build extra pages (services,
 * pricing, a personal note) without leaving the block editor.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_register_block_pattern_category() {
	register_block_pattern_category(
		'studio-frame',
		array( 'label' => __( 'Studio Frame', 'studio-frame' ) )
	);
}
add_action( 'init', 'sf_register_block_pattern_category' );

function sf_register_block_patterns() {
	register_block_pattern(
		'studio-frame/cta-band',
		array(
			'title'       => __( 'Call to action band', 'studio-frame' ),
			'description' => __( 'A full-width statement with two buttons, similar to the theme\'s own "let\'s work together" section.', 'studio-frame' ),
			'categories'  => array( 'studio-frame' ),
			'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px"}}},"backgroundColor":"black","textColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-white-color has-black-background-color has-text-color has-background" style="padding-top:80px;padding-bottom:80px">
<!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">' . esc_html__( 'Want to work together?', 'studio-frame' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . esc_html__( 'Tell me about your idea and I\'ll get back to you within a day or two.', 'studio-frame' ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-sf-btn-secondary"} -->
<div class="wp-block-button is-style-sf-btn-secondary"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Get in touch', 'studio-frame' ) . '</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
		)
	);

	register_block_pattern(
		'studio-frame/two-column-bio',
		array(
			'title'       => __( 'Portrait with text', 'studio-frame' ),
			'description' => __( 'An image next to a heading and a paragraph, useful for a services page or a personal note.', 'studio-frame' ),
			'categories'  => array( 'studio-frame' ),
			'content'     => '<!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center">
<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center">
<!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="" alt=""/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center">
<!-- wp:heading -->
<h2 class="wp-block-heading">' . esc_html__( 'A heading goes here', 'studio-frame' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . esc_html__( 'Write a couple of paragraphs here — this pattern works well for a services page, pricing explanation, or an extended bio.', 'studio-frame' ) . '</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->',
		)
	);

	register_block_pattern(
		'studio-frame/soft-panel',
		array(
			'title'       => __( 'Soft info panel', 'studio-frame' ),
			'description' => __( 'A rounded, softly-coloured box for a highlighted note or quote.', 'studio-frame' ),
			'categories'  => array( 'studio-frame' ),
			'content'     => '<!-- wp:group {"className":"is-style-sf-panel","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-sf-panel">
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . esc_html__( 'Use this panel to highlight a quote, a note about booking, or anything that should stand out from the rest of the page.', 'studio-frame' ) . '</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
		)
	);
}
add_action( 'init', 'sf_register_block_patterns' );
