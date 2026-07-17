<?php
/**
 * "Get Started" screen under Appearance: a plain-language checklist that
 * walks a non-technical buyer through setting up the theme, plus a
 * one-click demo content button.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sf_add_welcome_screen() {
	$hook = add_theme_page(
		__( 'Studio Frame: Get Started', 'studio-frame' ),
		__( 'Get Started', 'studio-frame' ),
		'edit_theme_options',
		'sf-get-started',
		'sf_render_welcome_screen'
	);
	add_action( 'load-' . $hook, 'sf_welcome_screen_assets' );
}
add_action( 'admin_menu', 'sf_add_welcome_screen' );

function sf_welcome_screen_assets() {
	add_action(
		'admin_enqueue_scripts',
		function () {
			wp_enqueue_style( 'sf-admin', SF_URI . '/assets/css/admin.css', array(), SF_VERSION );
		}
	);
}

/**
 * Build the checklist items with their completion state and a "fix this"
 * link. Shared with the admin notice's progress count.
 *
 * @return array[] Each item: label, done (bool), url.
 */
function sf_get_setup_checklist() {
	$about_page = get_posts(
		array(
			'post_type'      => 'page',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-templates/template-about.php',
		)
	);
	$contacts_page = get_posts(
		array(
			'post_type'      => 'page',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-templates/template-contacts.php',
		)
	);

	$project_counts = wp_count_posts( 'project' );
	$testimonial_counts = wp_count_posts( 'testimonial' );
	$faq_counts = wp_count_posts( 'faq_item' );

	return array(
		array(
			'label' => __( 'Upload your logo', 'studio-frame' ),
			'done'  => has_custom_logo(),
			'url'   => admin_url( 'customize.php?autofocus[section]=title_tagline' ),
		),
		array(
			'label' => __( 'Set your contact e-mail (for booking requests)', 'studio-frame' ),
			'done'  => (bool) get_theme_mod( 'sf_contact_email', '' ),
			'url'   => admin_url( 'customize.php?autofocus[section]=sf_section_contacts' ),
		),
		array(
			'label' => __( 'Create a primary menu', 'studio-frame' ),
			'done'  => has_nav_menu( 'primary' ),
			'url'   => admin_url( 'nav-menus.php' ),
		),
		array(
			'label' => __( 'Add at least one project to your portfolio', 'studio-frame' ),
			'done'  => ! empty( $project_counts->publish ),
			'url'   => admin_url( 'post-new.php?post_type=project' ),
		),
		array(
			'label' => __( 'Create an "About" page (assign the "About the photographer" template)', 'studio-frame' ),
			'done'  => ! empty( $about_page ),
			'url'   => admin_url( 'post-new.php?post_type=page' ),
		),
		array(
			'label' => __( 'Create a "Contacts" page (assign the "Contacts" template)', 'studio-frame' ),
			'done'  => ! empty( $contacts_page ),
			'url'   => admin_url( 'post-new.php?post_type=page' ),
		),
		array(
			'label' => __( 'Add a client testimonial (optional, but recommended)', 'studio-frame' ),
			'done'  => ! empty( $testimonial_counts->publish ),
			'url'   => admin_url( 'post-new.php?post_type=testimonial' ),
		),
		array(
			'label' => __( 'Add a few frequently asked questions (optional)', 'studio-frame' ),
			'done'  => ! empty( $faq_counts->publish ),
			'url'   => admin_url( 'post-new.php?post_type=faq_item' ),
		),
	);
}

function sf_render_welcome_screen() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$checklist   = sf_get_setup_checklist();
	$done_count  = count( array_filter( wp_list_pluck( $checklist, 'done' ) ) );
	$total_count = count( $checklist );

	if ( isset( $_POST['sf_demo_action'] ) && check_admin_referer( 'sf_demo_content' ) ) {
		if ( 'install' === $_POST['sf_demo_action'] ) {
			sf_install_demo_content();
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Demo content has been added. Take a look around, then replace it with your own photos and words.', 'studio-frame' ) . '</p></div>';
		} elseif ( 'remove' === $_POST['sf_demo_action'] ) {
			sf_remove_demo_content();
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Demo content has been removed.', 'studio-frame' ) . '</p></div>';
		}
		$checklist  = sf_get_setup_checklist();
		$done_count = count( array_filter( wp_list_pluck( $checklist, 'done' ) ) );
	}

	$demo_installed = (bool) get_option( 'sf_demo_imported' );
	?>
	<div class="wrap sf-welcome">
		<h1><?php esc_html_e( 'Welcome to Studio Frame', 'studio-frame' ); ?></h1>
		<p class="sf-welcome__intro"><?php esc_html_e( 'This page walks you through setting up your photography site. Everything here can also be changed later — nothing is permanent.', 'studio-frame' ); ?></p>

		<h2>
			<?php
			printf(
				/* translators: 1: number of completed steps, 2: total steps */
				esc_html__( 'Setup checklist (%1$d of %2$d done)', 'studio-frame' ),
				(int) $done_count,
				(int) $total_count
			);
			?>
		</h2>
		<ul class="sf-checklist">
			<?php foreach ( $checklist as $item ) : ?>
				<li class="sf-checklist__item <?php echo $item['done'] ? 'is-done' : ''; ?>">
					<span class="sf-checklist__icon" aria-hidden="true"><?php echo $item['done'] ? '&#10003;' : '&#9675;'; ?></span>
					<span class="sf-checklist__label"><?php echo esc_html( $item['label'] ); ?></span>
					<?php if ( ! $item['done'] ) : ?>
						<a class="sf-checklist__action" href="<?php echo esc_url( $item['url'] ); ?>"><?php esc_html_e( 'Do this now', 'studio-frame' ); ?> &rarr;</a>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>

		<h2><?php esc_html_e( 'Not sure where to start?', 'studio-frame' ); ?></h2>
		<p>
			<?php esc_html_e( 'Install one-click demo content — a few sample projects, testimonials and FAQ entries — to see how a finished site looks, then replace it with your own material at your own pace.', 'studio-frame' ); ?>
		</p>
		<form method="post" class="sf-welcome__demo-form">
			<?php wp_nonce_field( 'sf_demo_content' ); ?>
			<?php if ( $demo_installed ) : ?>
				<button type="submit" name="sf_demo_action" value="remove" class="button" onclick="return confirm('<?php echo esc_js( __( 'Remove all demo projects, testimonials and FAQ entries?', 'studio-frame' ) ); ?>');">
					<?php esc_html_e( 'Remove demo content', 'studio-frame' ); ?>
				</button>
			<?php else : ?>
				<button type="submit" name="sf_demo_action" value="install" class="button button-primary">
					<?php esc_html_e( 'Install demo content', 'studio-frame' ); ?>
				</button>
			<?php endif; ?>
		</form>

		<h2><?php esc_html_e( 'Where to customize things', 'studio-frame' ); ?></h2>
		<ul class="sf-links">
			<li><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Customizer — text, colours, contact details, social links', 'studio-frame' ); ?></a></li>
			<li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=project' ) ); ?>"><?php esc_html_e( 'Projects — your portfolio entries', 'studio-frame' ); ?></a></li>
			<li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=testimonial' ) ); ?>"><?php esc_html_e( 'Testimonials — client reviews shown on the homepage', 'studio-frame' ); ?></a></li>
			<li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=faq_item' ) ); ?>"><?php esc_html_e( 'FAQ — questions and answers shown on the homepage', 'studio-frame' ); ?></a></li>
			<li><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>"><?php esc_html_e( 'Menus — header and footer navigation', 'studio-frame' ); ?></a></li>
		</ul>
	</div>
	<?php
}
