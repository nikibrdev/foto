<?php
/**
 * Comments template, only ever loaded on Pages/posts that have comments
 * open (the Project, Testimonial and FAQ post types don't support them).
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>
<div class="sf-comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="sf-comments__title">
			<?php
			$sf_comment_count = get_comments_number();
			printf(
				/* translators: %s: number of comments */
				esc_html( _n( '%s comment', '%s comments', $sf_comment_count, 'studio-frame' ) ),
				esc_html( number_format_i18n( $sf_comment_count ) )
			);
			?>
		</h2>
		<ol class="sf-comments__list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="sf-comments__closed"><?php esc_html_e( 'Comments are closed.', 'studio-frame' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>
</div>
