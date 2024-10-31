<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * Template for recent testimonials widget form.
 *
 * @package Nice_Testimonials
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

?>
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'title' ) ); ?>"><strong><?php esc_html_e( 'Widget Title (optional)', 'nice-testimonials' ); ?></strong></label>
	<input class="widefat" id="<?php echo esc_attr( $widget->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
</p>
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'limit' ) ); ?>"><strong><?php esc_html_e( 'Number of Testimonials to Show', 'nice-testimonials' ); ?></strong></label>
	<input class="widefat" type="text" size="3" value="<?php echo esc_attr( $limit ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'limit' ) ); ?>" id="<?php echo esc_attr( $widget->get_field_id( 'limit' ) ); ?>">
</p>
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'image_size' ) ); ?>"><strong><?php esc_html_e( 'Image Size (in pixels)', 'nice-testimonials' ); ?></strong></label>
	<input class="widefat" type="text" size="3" value="<?php echo esc_attr( $image_size ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'image_size' ) ); ?>" id="<?php echo esc_attr( $widget->get_field_id( 'image_size' ) ); ?>">
</p>
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'orderby' ) ); ?>"><strong><?php esc_html_e( 'Order Testimonials By', 'nice-testimonials' ); ?></strong></label><br/>
	<select name="<?php echo esc_attr( $widget->get_field_name( 'orderby' ) ); ?>" id="<?php echo esc_attr( $widget->get_field_id( 'orderby' ) ); ?>">
		<option value="" disabled><?php esc_html_e( 'Select an option', 'nice-testimonials' ); ?></option>
		<?php $orderby_options = array(
			'default'    => esc_html__( 'Specified Order Setting', 'nice-testimonials' ),
			'ID'         => esc_html__( 'Testimonial ID', 'nice-testimonials' ),
			'title'      => esc_html__( 'Title', 'nice-testimonials' ),
			'menu_order' => esc_html__( 'Menu Order', 'nice-testimonials' ),
			'date'       => esc_html__( 'Date', 'nice-testimonials' ),
			'random'     => esc_html__( 'Random Order', 'nice-testimonials' ),
		); ?>
		<?php foreach ( $orderby_options as $value => $text ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $orderby ) ?>><?php echo esc_html( $text ); ?></option>
		<?php endforeach; ?>
	</select>
</p>
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'order' ) ); ?>"><strong><?php esc_html_e( 'Sort Testimonials By', 'nice-testimonials' ); ?></strong></label><br/>
	<select name="<?php echo esc_attr( $widget->get_field_name( 'order' ) ); ?>" id="<?php echo esc_attr( $widget->get_field_id( 'order' ) ); ?>">
		<option value="" disabled><?php esc_html_e( 'Select an option', 'nice-testimonials' ); ?></option>
		<?php $order_options = array(
			'default' => esc_html__( 'Specified Sort Setting', 'nice-testimonials' ),
			'asc'     => esc_html__( 'Ascending Order', 'nice-testimonials' ),
			'desc'    => esc_html__( 'Descending Order', 'nice-testimonials' ),
		); ?>
		<?php foreach ( $order_options as $value => $text ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $order ) ?>><?php echo esc_html( $text ); ?></option>
		<?php endforeach; ?>
	</select>
</p>

<fieldset class="nice-testimonials-widget-display-fields-settings">
	<p>
		<strong><?php esc_html_e( 'Display Fields', 'nice-testimonials' ); ?></strong><br />

		<input type="radio" onclick="jQuery( '#<?php echo esc_attr( $widget->get_field_id( 'fields' ) ); ?>_custom' ).hide();" class="use-default" name="<?php echo esc_attr( $widget->get_field_name( 'display_fields' ) ); ?>" id="<?php echo esc_attr( $widget->get_field_id( 'display_fields' ) ); ?>[default]" value="default" <?php checked( 'default', $display_fields ); ?>/>
		<label for="<?php echo esc_attr( $widget->get_field_id( 'display_fields' ) ); ?>[default]"><?php esc_html_e( 'Use specified field settings', 'nice-testimonials' ); ?></label><br />

		<input type="radio" onclick="jQuery( '#<?php echo esc_attr( $widget->get_field_id( 'fields' ) ); ?>_custom' ).show();" name="<?php echo esc_attr( $widget->get_field_name( 'display_fields' ) ); ?>" id="<?php echo esc_attr( $widget->get_field_id( 'display_fields' ) ); ?>[custom]" value="custom" <?php checked( 'custom', $display_fields ); ?> />
		<label for="<?php echo esc_attr( $widget->get_field_id( 'display_fields' ) ); ?>[custom]"><?php esc_html_e( 'Use custom settings', 'nice-testimonials' ); ?></label><br />
	</p>
</fieldset>
<fieldset id="<?php echo esc_attr( $widget->get_field_id( 'fields' ) ); ?>_custom" class="nice-testimonials-widget-display-fields-custom" style="display: <?php echo ( 'custom' === $display_fields ) ? 'block' : 'none'; ?>">
	<p>
		<strong><?php esc_html_e( 'Display These Fields:', 'nice-testimonials' ); ?></strong><br />

		<input type="hidden" name="<?php echo esc_attr( $widget->get_field_name( 'fields' ) ); ?>[author]" value="0" />
		<input type="checkbox" name="<?php echo esc_attr( $widget->get_field_name( 'fields' ) ); ?>[author]" id="<?php echo esc_attr( $widget->get_field_id( 'fields' ) ); ?>[author]" value="1" class="checkbox" <?php checked( $fields['author'], '1' ); ?> />
		<label for="<?php echo esc_attr( $widget->get_field_id( 'fields' ) ); ?>[author]"><?php esc_html_e( 'Author', 'nice-testimonials' ); ?></label><br />

		<input type="hidden" name="<?php echo esc_attr( $widget->get_field_name( 'fields' ) ); ?>[avatar]" value="0" />
		<input type="checkbox" name="<?php echo esc_attr( $widget->get_field_name( 'fields' ) ); ?>[avatar]" id="<?php echo esc_attr( $widget->get_field_id( 'fields' ) ); ?>[avatar]" value="1" class="checkbox" <?php checked( $fields['avatar'], '1' ); ?> />
		<label for="<?php echo esc_attr( $widget->get_field_id( 'fields' ) ); ?>[avatar]"><?php esc_html_e( 'Avatar', 'nice-testimonials' ); ?></label><br />

		<input type="hidden" name="<?php echo esc_attr( $widget->get_field_name( 'fields' ) ); ?>[url]" value="0" />
		<input type="checkbox" name="<?php echo esc_attr( $widget->get_field_name( 'fields' ) ); ?>[url]" id="<?php echo esc_attr( $widget->get_field_id( 'fields' ) ); ?>[url]" class="checkbox" value="1" <?php checked( $fields['url'], '1' ); ?> />
		<label for="<?php echo esc_attr( $widget->get_field_id( 'fields' ) ); ?>[url]"><?php esc_html_e( 'URL', 'nice-testimonials' ); ?></label><br />
	</p>
</fieldset>
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'category' ) ); ?>"><strong><?php esc_html_e( 'Category', 'nice-testimonials' ); ?></strong></label><br />
	<?php wp_dropdown_categories( array(
			'id'              => $widget->get_field_name( 'category' ),
			'name'            => $widget->get_field_name( 'category' ),
			'selected'        => $category,
			'taxonomy'        => 'testimonial_category',
			'hide_empty'      => false,
			'show_option_all' => esc_html__( 'All Categories', 'nice-testimonials' ),
	) ); ?>
	<br />

	<input type="hidden" name="<?php echo esc_attr( $widget->get_field_name( 'include_children' ) ); ?>" value="0" />
	<input type="checkbox" name="<?php echo esc_attr( $widget->get_field_name( 'include_children' ) ); ?>" id="<?php echo esc_attr( $widget->get_field_id( 'include_children' ) ); ?>" class="checkbox" <?php checked( $include_children, true ); ?> />
	<label for="<?php echo esc_attr( $widget->get_field_id( 'include_children' ) ); ?>"><?php esc_html_e( 'Include Child Categories', 'nice-testimonials' ); ?></label><br />
</p>
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'id' ) ); ?>"><strong><?php esc_html_e( 'Specific ID (optional)', 'nice-testimonials' ); ?></strong></label>
	<input class="widefat" id="<?php echo esc_attr( $widget->get_field_id( 'id' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'id' ) ); ?>" type="text" value="<?php echo esc_attr( $id ); ?>"/>
	<span class="description" style="padding-left: 0; padding-right: 0;"><?php esc_html_e( 'Display a specific testimonial instead of a list.', 'nice-testimonials' ); ?></span>
</p>
