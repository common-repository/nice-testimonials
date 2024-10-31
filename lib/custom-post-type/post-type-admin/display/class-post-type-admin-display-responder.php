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
 * Class Nice_Testimonials_Post_Type_AdminDisplayResponder
 *
 * This class takes charge of the Nice_Testimonials_Post_Type_Admin instances to
 * be displayed through WordPress APIs.
 *
 * @since 1.1
 */
class Nice_Testimonials_Post_Type_AdminDisplayResponder extends Nice_Testimonials_DisplayResponder {
	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.1
	 */
	protected function set_interactions() {
		$args = $this->data->post_type->args;

		/**
		 * Add thumbnails to column view.
		 */
		add_filter( 'manage_edit-' . $args['name'] . '_columns', array( $this, 'add_image_column' ), 10, 1 );
		add_action( 'manage_posts_custom_column', array( $this, 'display_image' ), 10, 1 );

		/**
		 * Allow filtering of posts by taxonomy in the admin view.
		 */
		add_action( 'restrict_manage_posts', array( $this, 'add_taxonomy_filters' ) );

		/**
		 * Fire default functionality.
		 */
		parent::set_interactions();
	}

	/**
	 * Add columns to post type list screen.
	 *
	 * @sine   1.1
	 *
	 * @link   http://wptheming.com/2010/07/column-edit-pages/
	 *
	 * @param  array $columns Existing columns.
	 *
	 * @return array          Amended columns.
	 */
	public function add_image_column( $columns ) {
		global $typenow;

		$_typenow = $typenow;

		if ( empty( $_typenow ) && nice_testimonials_doing_ajax() && isset( $_REQUEST['post_ID'] ) ) {
			$post = get_post( intval( $_REQUEST['post_ID'] ) );
			$_typenow = $post->post_type;
		}

		if ( $this->data->post_type->{'args'}['name'] === $_typenow ) {
			$column_thumbnail = array( 'thumbnail' => esc_html__( 'Image', 'nice-testimonials-plugin-textdomain' ) );
			$image_column = array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, null, true );

			// Apply general filters.
			$image_column = apply_filters(
				'nice_testimonials_post_type_add_image_column',
				$image_column,
				$columns,
				$this
			);

			// Apply post-type-specific filters.
			$image_column = apply_filters(
				'nice_testimonials_post_type_' . $this->data->post_type->{'args'}['name'] . '_add_image_column',
				$image_column,
				$columns,
				$this
			);

			return $image_column;
		}

		return $columns;
	}

	/**
	 * Custom column callback
	 *
	 * @since  1.1
	 *
	 * @global stdClass $post Post object.
	 *
	 * @param  string $column Column ID.
	 */
	public function display_image( $column ) {
		global $typenow;

		if ( nice_testimonials_doing_ajax() ) {
			$post = get_post();
			$post_type = $post->post_type;
		}

		$post_type = empty( $post_type ) ? $typenow : $post_type;

		if ( $this->data->post_type->{'args'}['name'] === $post_type ) {
			$image = '';
			switch ( $column ) {
				case 'thumbnail':
					$image = get_the_post_thumbnail( get_the_ID(), array( 35, 35 ) );
					break;
			}

			// Apply general filters.
			$image = apply_filters(
				'nice_testimonials_post_type_display_image',
				$image,
				$column,
				$this
			);

			// Apply post-type-specific filters.
			$image = apply_filters(
				'nice_testimonials_post_type_' . $this->data->post_type->{'args'}['name'] . '_display_image',
				$image,
				$column,
				$this
			);

			echo $image; // WPCS: XSS ok.
		}
	}

	/**
	 * Add taxonomy filters to the post type list page.
	 *
	 * Code artfully lifted from http://pippinsplugins.com/
	 *
	 * @since  1.1
	 *
	 * @global string $typenow
	 */
	public function add_taxonomy_filters() {
		global $typenow;

		// Must set this to the post type you want the filter(s) displayed on
		if ( $this->data->post_type->{'args'}['name'] !== $typenow ) {
			return;
		}

		foreach ( $this->data->post_type->{'taxonomies'} as $taxonomy ) {
			$taxonomy_filter = $this->build_taxonomy_filter( $taxonomy['name'] );

			// Apply general filters.
			$taxonomy_filter = apply_filters(
				'nice_testimonials_post_type_taxonomy_filter',
				$taxonomy_filter,
				$typenow,
				$this
			);

			// Apply taxonomy-specific filters.
			$taxonomy_filter = apply_filters(
				'nice_testimonials_post_type_' . $taxonomy['name'] . '_taxonomy_filter',
				$taxonomy_filter,
				$typenow,
				$this
			);

			echo $taxonomy_filter; // WPCS: XSS ok.
		}
	}

	/**
	 * Build an individual dropdown filter.
	 *
	 * @since  1.1
	 *
	 * @param  string $tax_slug Taxonomy slug to build filter for.
	 *
	 * @return string Markup, or empty string if taxonomy has no terms.
	 */
	protected function build_taxonomy_filter( $tax_slug ) {
		$terms = get_terms( $tax_slug );
		if ( 0 === count( $terms ) ) {
			return '';
		}

		$tax_name         = $this->get_taxonomy_name_from_slug( $tax_slug );
		$current_tax_slug = isset( $_GET[ $tax_slug ] ) ? wp_unslash( $_GET[ $tax_slug ] ) : false;

		$filter  = '<select name="' . esc_attr( $tax_slug ) . '" id="' . esc_attr( $tax_slug ) . '" class="postform">';
		$filter .= '<option value="0">' . esc_html( $tax_name ) . '</option>';
		$filter .= $this->build_term_options( $terms, $current_tax_slug );
		$filter .= '</select>';

		// Apply general filters.
		$filter = apply_filters( 'nice_testimonials_post_type_build_taxonomy_filter', $filter, $tax_slug, $this );

		// Apply taxonomy-specific filters.
		$filter = apply_filters(
			'nice_testimonials_post_type_build_' . $tax_slug . '_taxonomy_filter',
			$filter,
			$tax_slug,
			$this
		);

		return $filter;
	}

	/**
	 * Get the friendly taxonomy name, if given a taxonomy slug.
	 *
	 * @since  1.1
	 *
	 * @param  string $tax_slug Taxonomy slug.
	 *
	 * @return string Friendly name of taxonomy, or empty string if not a valid taxonomy.
	 */
	protected function get_taxonomy_name_from_slug( $tax_slug ) {
		$tax_obj = get_taxonomy( $tax_slug );
		if ( ! $tax_obj ) {
			return '';
		}

		$taxonomy_name = $tax_obj->labels->name;

		// Apply general filters.
		$taxonomy_name = apply_filters(
			'nice_testimonials_post_type_taxonomy_name',
			$taxonomy_name,
			$tax_slug,
			$this
		);

		// Apply taxonomy-specific filters.
		$taxonomy_name = apply_filters(
			'nice_testimonials_post_type_' . $tax_slug . '_taxonomy_name',
			$taxonomy_name,
			$tax_slug,
			$this
		);

		return $taxonomy_name;
	}

	/**
	 * Build a series of option elements from an array.
	 *
	 * Also checks to see if one of the options is selected.
	 *
	 * @since  1.1
	 *
	 * @param  array  $terms            Array of term objects.
	 * @param  string $current_tax_slug Slug of currently selected term.
	 *
	 * @return string Markup.
	 */
	protected function build_term_options( $terms, $current_tax_slug ) {
		$options = '';
		foreach ( $terms as $term ) {
			$options .= sprintf(
				'<option value="%s" %s />%s</option>',
				esc_attr( $term->slug ),
				selected( $current_tax_slug, $term->slug, $echo = false ),
				esc_html( $term->name . '(' . $term->count . ')' )
			);
		}

		// Apply general filters.
		$options = apply_filters(
			'nice_testimonials_post_type_term_options',
			$options,
			$terms,
			$current_tax_slug,
			$this
		);

		// Apply taxonomy-specific filters.
		$options = apply_filters(
			'nice_testimonials_post_type_' . $current_tax_slug . '_term_options',
			$options,
			$terms,
			$current_tax_slug,
			$this
		);

		return $options;
	}
}
