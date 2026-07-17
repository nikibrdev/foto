<?php
/**
 * Search form, styled with the theme's generic .form classes.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="form sf-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="form__item">
		<label class="form__label">
			<input type="search" class="form__input" placeholder="<?php echo esc_attr__( 'Search…', 'studio-frame' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
		</label>
	</div>
	<button type="submit" class="form__btn btn-secondary">
		<span class="btn-secondary__inner">
			<span class="btn-secondary__default"><?php esc_html_e( 'Search', 'studio-frame' ); ?></span>
			<span class="btn-secondary__hover"><?php esc_html_e( 'Search', 'studio-frame' ); ?></span>
		</span>
	</button>
</form>
