<?php
/**
 * NiceThemes Post Type API
 *
 * @package Nice_Testimonials_Post_Type_API
 * @since   1.1
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Testimonials_Metabox_HTMLHandler
 *
 * This class works as a helper to construct HTML for meta boxes.
 *
 * @since 1.1
 */
class Nice_Testimonials_Metabox_HTMLHandler {
	/**
	 * Meta box data to construct the HTML.
	 *
	 * @var   stdClass
	 * @since 1.1
	 */
	protected $data;

	/**
	 * Printable data.
	 *
	 * @var   string
	 * @since 1.1
	 */
	protected $html;

	/**
	 * Set initial data and process HTML.
	 *
	 * @since 1.1
	 *
	 * @param Nice_Testimonials_Metabox $instance
	 */
	public function __construct( Nice_Testimonials_Metabox $instance ) {
		if ( $this->data = $instance->get_info() ) {
			$this->process_html();
		}
	}

	/**
	 * Construct HTML for the current instance.
	 *
	 * @since 1.1
	 */
	protected function process_html() {
		$html = '<table id="nice-metabox" class="form-table">';
		$fields_html = '';

		foreach ( $this->data->fields as $field ) {
			// Apply a generic filter.
			$field = apply_filters( 'nice_testimonials_post_type_metabox_add_field', $field, $this );
			// Apply a type-specific filter.
			$field = apply_filters( 'nice_testimonials_post_type_metabox_add_field_' . $field['type'], $field, $this );

			/**
			 * Set nonce to validate.
			 */
			wp_nonce_field( $field['name'], $field['name'] . '_nonce' );

			switch ( $field['type'] ) :

				case 'info':
					$field_html = self::custom_get_info( $field );
					break;

				case 'text':
					$field_html = self::custom_get_text( $field );
					break;

				case 'select':
					$field_html = self::custom_get_select( $field );
					break;

				case 'textarea':
					$field_html = self::custom_get_textarea( $field );
					break;

				case 'upload':
					$field_html = self::custom_get_file( $field );
					break;

				case 'checkbox':
					$field_html = self::custom_get_checkbox( $field );
					break;

				case 'radio':
					$field_html = self::custom_get_radio( $field );
					break;
				default :
					$field_html = '';
					break;

			endswitch;

			// Apply a generic filter.
			$field_html = apply_filters( 'nice_testimonials_post_type_metabox_add_field_html', $field_html, $field, $this );
			// Apply a type-specific filter.
			$field_html = apply_filters( 'nice_testimonials_post_type_metabox_add_field_html_' . $field['type'], $field_html, $field, $this );

			// Add to overall fields' HTML.
			$fields_html .= $field_html;
		}

		$html .= $fields_html . '</table>';

		$this->html = $html;
	}

	/**
	 * Display constructed meta box.
	 *
	 * @since 1.1
	 */
	public function print_html() {
		echo $this->html; // WPCS: XSS ok.
	}

	/**
	 * Retrieve option info in order to return the field in html code.
	 *
	 * @since  1.1
	 *
	 * @param  array  $field  Option info in order to return the HTML code.
	 *
	 * @return string         Text input.
	 */
	protected static function custom_get_info( $field ) {
		$id = self::custom_get_id( $field );

		$html  = "\t" . '<tr id="' . $id . '" class="nice-custom-info" >';
		$html .= "\t\t" . '<td colspan="2">' . $field['desc'] . '</td>' . "\n";
		$html .= "\t" . '</tr>' . "\n";

		return $html;
	}

	/**
	 * Retrieve option info in order to return the field in html code.
	 *
	 * @since  1.1
	 *
	 * @param  array  $field  Option info in order return the html code.
	 *
	 * @return string         Text input.
	 */
	function custom_get_text( $field ) {
		$id = self::custom_get_id( $field );

		$html  = "\t" . '<tr id="' . $id . '" >';
		$html .= "\t\t" . '<th><label for="' . esc_attr( $id ) . '">' . $field['label'] . '</label></th>' . "\n";
		$html .= "\t\t" . '<td><input class="nice-input-text " type="' . $field['type'] . '" value="' . html_entity_decode( $this->custom_get_value( $field ) ) . '" name="' . $field['name'] . '" id="' . $id . '"/>';
		$html .= '<span class="description">' . $field['desc'] . '</span></td>' . "\n";
		$html .= "\t" . '</tr>' . "\n";

		return $html;
	}

	/**
	 * Retrieve option info in order to return the field in html code.
	 *
	 * @since  1.1
	 *
	 * @param  array  $field  Option info in order return the html code.
	 *
	 * @return string         Textarea input.
	 */
	protected static function custom_get_textarea( $field ) {
		$id = self::custom_get_id( $field );

		$html  = "\t" . '<tr id="' . $id . '" >';
		$html .= "\t\t" . '<th><label for="' . $id . '">' . $field['label'] . '</label></th>' . "\n";
		$html .= "\t\t" . '<td><textarea class="nice_testimonials_textarea " name="' . $field['name'] . '" id="' . $id . '">' . esc_textarea( stripslashes( html_entity_decode( self::custom_get_value( $field ) ) ) ) . '</textarea>';
		$html .= '<span class="description">' . $field['desc'] . '</span></td>' . "\n";
		$html .= "\t" . '</tr>' . "\n";

		return $html;
	}

	/**
	 * Retrieve option info in order to return the field in HTML code.
	 *
	 * @since  1.1
	 *
	 * @param  array  $field  Option info in order return the html code.
	 *
	 * @return string         Select input.
	 */
	protected static function custom_get_select( $field ) {
		$field_id = self::custom_get_id( $field );

		$html  = "\t" . '<tr id="' . $field_id . '" >';
		$html .= "\t\t" . '<th><label for="' . $field_id . '">' . $field['label'] . '</label></th>' . "\n";
		$html .= "\t\t" . '<td><select class="nice-select" id="' . $field_id . '" name="' . $field['name'] . '">';

		$options = $field['options'];

		if ( $options ) {
			$selected_value = self::custom_get_value( $field );

			foreach ( $options as $id => $option ) {
				$selected = '';

				if ( $id === $selected_value ) {
					$selected = selected( $selected_value, $id, false );
				}

				$html .= '<option value="' . esc_attr( $id ) . '" ' . $selected . '>' . $option . '</option>';
			}
		}

		$html .= '</select><span class="description">' . $field['desc'] . '</span></td>' . "\n";
		$html .= "\t" . '</tr>' . "\n";

		return $html;
	}

	/**
	 * Retrieve file uploader.
	 *
	 * @since 1.1
	 *
	 * @param  array  $field
	 *
	 * @return string
	 */
	protected static function custom_get_file( $field ) {
		printf( '<p>' . esc_html__( '%s method is not implemented yet. Please use another method to display an option for %s', 'nice-testimonials-plugin-textdomain' ) . '</p>', __METHOD__ . '()', esc_html( $field['name'] ) . '<br />' );
	}

	/**
	 * Retrieve option info in order to return the field in html code.
	 *
	 * @since 1.1
	 *
	 * @param  array  $field  Option info in order return the html code.
	 * @return string         Checkbox input.
	 */
	protected static function custom_get_checkbox( $field ) {
		$value   = self::custom_get_value( $field );
		$id      = self::custom_get_id( $field );
		$checked = checked( $value, 'true', false );

		$html  = "\t" . '<tr id="' . $id . '" >';
		$html .= "\t\t" . '<th><label for="' . $id . '">' . $field['label'] . '</label></th>' . "\n";
		$html .= "\t\t" . '<td><input type="checkbox" ' . $checked . ' class="nice-input-checkbox" value="true"  id="' . $id . '" name="' . $field['name'] . '" />';
		$html .= '<span class="description" style="display:inline">' . $field['desc'] . '</span></td>' . "\n";
		$html .= "\t" . '</tr>' . "\n";

		return $html;
	}

	/**
	 * Retrieve option info in order to return the field in html code.
	 *
	 * @since  1.1
	 *
	 * @param  array  $field  Option info in order return the html code.
	 *
	 * @return string         Radio input.
	 */
	protected static function custom_get_radio( $field ) {
		$field_id = self::custom_get_id( $field );
		$options  = $field['options'];

		if ( $options ) {
			$html  = "\t" . '<tr id="' . $field_id . '" >';
			$html .= "\t\t" . '<th><label for="' . $field_id . '">' . $field['label'] . '</label></th>' . "\n";
			$html .= "\t\t" . '<td>';

			$selected_value = self::custom_get_value( $field );

			foreach ( $options as $id => $option ) {
				$checked = checked( $selected_value, $id, false );

				$html .= '<input type="radio" ' . $checked . ' value="' . $id . '" class="nice-input-radio"  name="' . $field['name'] . '" />';
				$html .= '<span class="description" style="display:inline">' . $option . '</span><div class="nice_testimonials_spacer"></div>';
			}

			$html .= "\t" . '</tr>' . "\n";
		}

		return $html;
	}

	/**
	 * Retrieve custom field ID for html purposes.
	 *
	 * @since 1.1
	 *
	 * @param  array  $field
	 *
	 * @return string
	 */
	protected static function custom_get_id( $field ) {
		return 'nicethemes_' . $field['name'];
	}

	/**
	 * Retrieve custom field value. If there's no value in db
	 * it sets the standard value
	 *
	 * @since  1.1
	 *
	 * @param  array  $field
	 *
	 * @return string
	 */
	protected static function custom_get_value( $field ) {
		global $post;

		/**
		 * @var WP_Post $current_post
		 */
		$current_post = $post ? $post : null;

		if ( is_null( $current_post ) && isset( $_GET['post'] ) ) {
			$current_post = get_post( intval( wp_unslash( $_GET['post'] ) ) );
		}

		if ( is_null( $current_post ) ) {
			return null;
		}

		$db_value = get_post_meta( $current_post->ID, $field['name'], true );

		if ( '' === $db_value && isset( $field['std'] ) ) {
			return $field['std'];
		}

		return $db_value;
	}
}
