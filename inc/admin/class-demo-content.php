<?php
/**
 * One-click demo content: a handful of sample projects, testimonials, FAQ
 * entries and starter pages, so a new site doesn't look empty while the
 * buyer is still deciding what to fill in. Everything it creates is
 * tracked so it can be removed just as easily.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create demo content. Safe to call more than once — skips straight away
 * if demo content has already been installed.
 */
function sf_install_demo_content() {
	if ( get_option( 'sf_demo_imported' ) ) {
		return;
	}

	$created_ids = array();

	// Make sure the status terms exist (normally seeded on activation).
	sf_activation_seed_terms();

	$categories = array();
	foreach ( array( 'Portrait', 'Editorial', 'Wedding' ) as $cat_name ) {
		$term = term_exists( $cat_name, 'project_category' );
		if ( ! $term ) {
			$term = wp_insert_term( $cat_name, 'project_category' );
		}
		if ( ! is_wp_error( $term ) ) {
			$categories[ $cat_name ] = (int) $term['term_id'];
		}
	}

	$statuses = array(
		'open' => get_term_by( 'slug', 'in-progress', 'project_status' ),
		'past' => get_term_by( 'slug', 'repeatable', 'project_status' ),
	);

	$demo_projects = array(
		array(
			'title'    => __( 'Whispering Forest', 'studio-frame' ),
			'excerpt'  => __( 'A misty-forest art series with deep reds and quiet, storybook light.', 'studio-frame' ),
			'content'  => __( 'A fantasy-inspired portrait session shot in the woods at golden hour, built around a single character and a simple story. Great for anyone who wants a portrait session that feels like a scene from a film.', 'studio-frame' ),
			'category' => 'Editorial',
			'status'   => 'open',
			'price'    => __( 'from $450', 'studio-frame' ),
			'date'     => __( 'Booking now', 'studio-frame' ),
			'slider'   => true,
			'teaser'   => true,
		),
		array(
			'title'    => __( 'City at Dusk', 'studio-frame' ),
			'excerpt'  => __( 'An urban editorial series shot as the city lights come on.', 'studio-frame' ),
			'content'  => __( 'A moody, cinematic portrait session across the city at blue hour — reflections, neon and long shadows.', 'studio-frame' ),
			'category' => 'Editorial',
			'status'   => 'open',
			'price'    => __( 'from $400', 'studio-frame' ),
			'date'     => __( 'Spring 2026', 'studio-frame' ),
			'slider'   => true,
			'teaser'   => true,
		),
		array(
			'title'    => __( 'Anna & Michael', 'studio-frame' ),
			'excerpt'  => __( 'A quiet, documentary-style wedding day, told frame by frame.', 'studio-frame' ),
			'content'  => __( 'A full-day wedding story focused on genuine, unposed moments rather than staged shots.', 'studio-frame' ),
			'category' => 'Wedding',
			'status'   => 'past',
			'price'    => __( 'from $1,200', 'studio-frame' ),
			'date'     => __( 'Summer 2025', 'studio-frame' ),
			'slider'   => false,
			'teaser'   => true,
		),
		array(
			'title'    => __( 'Studio Portraits', 'studio-frame' ),
			'excerpt'  => __( 'Clean, classic studio portraits with a modern, minimal look.', 'studio-frame' ),
			'content'  => __( 'A simple studio session — one backdrop, natural expressions, a handful of outfit changes.', 'studio-frame' ),
			'category' => 'Portrait',
			'status'   => 'past',
			'price'    => __( 'from $250', 'studio-frame' ),
			'date'     => __( 'Year-round', 'studio-frame' ),
			'slider'   => false,
			'teaser'   => true,
		),
	);

	foreach ( $demo_projects as $index => $project ) {
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'project',
				'post_status'  => 'publish',
				'post_title'   => $project['title'],
				'post_excerpt' => $project['excerpt'],
				'post_content' => $project['content'],
				'menu_order'   => $index,
			)
		);
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}
		$created_ids[] = $post_id;

		if ( isset( $categories[ $project['category'] ] ) ) {
			wp_set_object_terms( $post_id, array( $categories[ $project['category'] ] ), 'project_category' );
		}
		if ( ! empty( $statuses[ $project['status'] ] ) && ! is_wp_error( $statuses[ $project['status'] ] ) ) {
			wp_set_object_terms( $post_id, array( (int) $statuses[ $project['status'] ]->term_id ), 'project_status' );
		}

		update_post_meta( $post_id, 'project_price_amount', $project['price'] );
		update_post_meta( $post_id, 'project_date_text', $project['date'] );
		update_post_meta( $post_id, 'project_show_in_slider', $project['slider'] ? 'on' : '' );
		update_post_meta( $post_id, 'project_show_in_teaser', $project['teaser'] ? 'on' : '' );
	}

	$demo_testimonials = array(
		array(
			__( 'Jane D.', 'studio-frame' ),
			__( 'Working with this photographer felt effortless — the whole session had a real story to it, not just a list of poses. I still look back at these photos a year later.', 'studio-frame' ),
		),
		array(
			__( 'Mark T.', 'studio-frame' ),
			__( 'Every photo feels like a still from a film. Relaxed, natural, and genuinely fun to be part of.', 'studio-frame' ),
		),
		array(
			__( 'Olivia R.', 'studio-frame' ),
			__( 'I was nervous in front of the camera, but I was put at ease immediately. The final gallery exceeded what I imagined.', 'studio-frame' ),
		),
	);
	foreach ( $demo_testimonials as $index => $testimonial ) {
		$post_id = wp_insert_post(
			array(
				'post_type'   => 'testimonial',
				'post_status' => 'publish',
				'post_title'  => $testimonial[0],
				'menu_order'  => $index,
			)
		);
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}
		$created_ids[] = $post_id;
		update_post_meta( $post_id, 'testimonial_text', $testimonial[1] );
	}

	$demo_faq = array(
		array(
			__( 'How do I book a session?', 'studio-frame' ),
			__( 'Pick a project on the site or fill in the contact form with a short description of what you have in mind, and I will get back to you to confirm a date.', 'studio-frame' ),
		),
		array(
			__( 'Can I request my own idea or style?', 'studio-frame' ),
			__( 'Absolutely — I am always happy to work from your concept, or help adapt it to fit the visual style of my portfolio.', 'studio-frame' ),
		),
		array(
			__( 'How long does a session take?', 'studio-frame' ),
			__( 'Most sessions run 1–3 hours depending on the format. After booking you will get a short guide covering outfits, props and general prep.', 'studio-frame' ),
		),
		array(
			__( 'Do I get the unedited photos?', 'studio-frame' ),
			__( 'The standard package includes a set of fully retouched images. Unedited files can be provided on request — let\'s discuss it when booking.', 'studio-frame' ),
		),
		array(
			__( 'Do you travel for sessions?', 'studio-frame' ),
			__( 'Yes — let me know which location you have in mind and we can work out the logistics together.', 'studio-frame' ),
		),
		array(
			__( 'I have never modeled before — will you help direct me?', 'studio-frame' ),
			__( 'Of course. I guide posing throughout the session and keep things relaxed — you just have to show up as yourself.', 'studio-frame' ),
		),
	);
	foreach ( $demo_faq as $index => $faq ) {
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'faq_item',
				'post_status'  => 'publish',
				'post_title'   => $faq[0],
				'post_content' => $faq[1],
				'menu_order'   => $index,
			)
		);
		if ( ! is_wp_error( $post_id ) && $post_id ) {
			$created_ids[] = $post_id;
		}
	}

	// Starter About/Contacts pages, only if the buyer hasn't already made one.
	$has_about = get_posts( array( 'post_type' => 'page', 'posts_per_page' => 1, 'fields' => 'ids', 'meta_key' => '_wp_page_template', 'meta_value' => 'page-templates/template-about.php' ) );
	if ( empty( $has_about ) ) {
		$about_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => __( 'About', 'studio-frame' ),
				'page_template' => 'page-templates/template-about.php',
			)
		);
		if ( ! is_wp_error( $about_id ) && $about_id ) {
			$created_ids[] = $about_id;
			update_post_meta( $about_id, 'about_hero_text', __( 'I create atmospheric sessions where every detail works toward a story. It is more than a pretty picture — it is a chance to live a moment and keep the feeling of it.', 'studio-frame' ) );
			update_post_meta( $about_id, 'about_hero_statement', __( 'My work blends atmosphere, visual storytelling and careful direction.', 'studio-frame' ) );
			update_post_meta(
				$about_id,
				'about_hero_points',
				array(
					array(
						'point_title' => __( 'Capturing moments', 'studio-frame' ),
						'point_text'  => __( 'The most honest photos come from relaxed, unscripted moments — I build the conditions for those to happen.', 'studio-frame' ),
					),
					array(
						'point_title' => __( 'Emotion first', 'studio-frame' ),
						'point_text'  => __( 'Light, pose and colour all serve one goal: capturing how a moment felt, not just how it looked.', 'studio-frame' ),
					),
					array(
						'point_title' => __( 'Timeless, not trendy', 'studio-frame' ),
						'point_text'  => __( 'I am not chasing trends — I build series meant to be looked at again in ten years.', 'studio-frame' ),
					),
				)
			);
		}
	}

	$has_contacts = get_posts( array( 'post_type' => 'page', 'posts_per_page' => 1, 'fields' => 'ids', 'meta_key' => '_wp_page_template', 'meta_value' => 'page-templates/template-contacts.php' ) );
	if ( empty( $has_contacts ) ) {
		$contacts_id = wp_insert_post(
			array(
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_title'    => __( 'Contacts', 'studio-frame' ),
				'page_template' => 'page-templates/template-contacts.php',
			)
		);
		if ( ! is_wp_error( $contacts_id ) && $contacts_id ) {
			$created_ids[] = $contacts_id;
		}
	}

	update_option( 'sf_demo_post_ids', $created_ids );
	update_option( 'sf_demo_imported', 1 );
}

/**
 * Remove everything sf_install_demo_content() created (and only that).
 */
function sf_remove_demo_content() {
	$ids = get_option( 'sf_demo_post_ids', array() );
	foreach ( (array) $ids as $post_id ) {
		wp_delete_post( $post_id, true );
	}
	delete_option( 'sf_demo_post_ids' );
	delete_option( 'sf_demo_imported' );
}
