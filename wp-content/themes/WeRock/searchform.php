<?php
/**
 * The template for displaying search forms in werock
 *
 * @package werock
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Buscar &hellip;', 'placeholder', 'werock' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	</label>
	<input type="submit" class="btn search-submit" value="<?php echo esc_attr_x( 'Buscar', 'submit button', 'werock' ); ?>">
</form>
