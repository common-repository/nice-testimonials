<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * Handle the Testimonials widget.
 *
 * @package Nice_Testimonials
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Nice_Testimonials_Widget' ) ) :
/**
 * Class Nice_Testimonials_Widget
 *
 * This class creates a widget to display the latest testimonials.
 *
 * @package Nice_Testimonials
 * @since   1.0
 */
class Nice_Testimonials_Widget extends WP_Widget {
	/**
	 * Internal handler for this widget.
	 *
	 * @since 1.0
	 * @var   string
	 */
	public $id = 'nice-testimonials';

	/**
	 * Public name of the widget.
	 *
	 * @since 1.0
	 * @var   string
	 */
	public $name = '';

	/**
	 * Widget options.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $options = array();

	/**
	 * Default values for widget instance.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $instance_defaults = null;

	/**
	 * Helper object to manage widget cache.
	 *
	 * @since 1.0
	 * @var   Nice_Testimonials_Widget_Cache
	 */
	protected $cache = null;

	/**
	 * Helper object to manage common processes.
	 *
	 * @since 1.0
	 * @var   Nice_Testimonials_Widget_Normalizer
	 */
	protected $normalizer = null;

	/**
	 * How often the widget cache is refreshed (in seconds). Default is five minutes.
	 *
	 * @since 1.0
	 * @var   int
	 */
	public $refresh = 300;

	/**
	 * Internal name for this widget.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $slug = 'nice-testimonials';

	/**
	 * Initialize widget.
	 *
	 * @since 1.0
	 */
	function __construct() {
		/**
		 * Set values to normalize instance settings.
		 */
		$this->instance_defaults = self::get_instance_defaults();

		/**
		 * Set timeout to clear widget cache.
		 */
		$this->refresh = apply_filters( 'nice_widget_testimonials_refresh', $this->refresh );

		/**
		 * Initialize settings normalizer.
		 */
		$this->normalizer = new Nice_Testimonials_Widget_Normalizer( $this->instance_defaults );

		/**
		 * Initialize cache handler.
		 */
		$this->cache = new Nice_Testimonials_Widget_Cache( 'widget_nice_testimonials', $this->refresh );

		/**
		 * Define name of widget. Check first, to allow inheritance.
		 */
		if ( ! $this->name ) {
			$this->name = esc_html__( '(NiceThemes) Testimonials', 'nice-testimonials' );
		}

		/**
		 * Define widget options. Check first, to allow inheritance.
		 */
		$this->options = array_merge( array(
			'classname'   => 'nice-testimonials',
			'description' => esc_html__( 'A widget that displays the most recent testimonials.', 'nice-testimonials' ),
		), $this->options );

		/**
		 * Create widget.
		 */
		parent::__construct( $this->id, $this->name, $this->options );

		/**
		 * Allow hooks here.
		 */
		do_action( 'nice_testimonials_widget_loaded', $this );

		/**
		 * Allow hooks only when the widget is displayed in the front-end.
		 */
		if ( is_active_widget( false, false, $this->id_base, true ) ) {
			do_action( 'nice_testimonials_widget_public_loaded', $this );
		}
	}

	/**
	 * Obtain the current value of a property.
	 *
	 * @since  1.0
	 * @param  string     $property Name of a property of this class.
	 * @return mixed|void           Current value for the requested property.
	 */
	public function __get( $property ) {
		if ( property_exists( $this, $property ) ) {
			return $this->{$property};
		}

		return null;
	}

	/**
	 * Use a custom template for widget single elements.
	 *
	 * @since  1.0
	 * @return string
	 */
	public function widget_template() {
		$tpl = '
		<li class="nice-testimonial %%CLASS%%">
			<blockquote class="nice-testimonial-content">
				%%IMAGE%%
				%%CONTENT%%
			</blockquote>
			<cite class="nice-testimonial-author">%%TITLE%%</cite>
		</li>';

		return $tpl;
	}

	/**
	 * Obtain default values for widget instance.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	protected static function get_instance_defaults() {
		// Allow by-pass.
		if ( $defaults = apply_filters( 'nice_testimonials_widget_instance_defaults', null ) ) {
			if ( ! empty( $defaults ) && is_array( $defaults ) ) {
				return $defaults;
			}
		}

		$settings = nice_testimonials_settings();

		/**
		 * Obtain values.
		 *
		 * Format for each value: {key} => array( {value}, {sanitization_function} )
		 */
		$defaults = array(
			'title'            => array( '', 'sanitize_text_field' ),
			'limit'            => array( $settings['limit'], 'absint' ),
			'orderby'          => array( 'default', 'sanitize_key' ),
			'order'            => array( 'default', 'sanitize_key' ),
			'display_fields'   => array( 'default', 'sanitize_key' ),
			'fields'           => array( $settings['fields'], 'filter_var_array' ),
			'image_size'       => array( $settings['image_size'], 'absint' ),
			'category'         => array( 0, 'absint' ),
			'include_children' => array( $settings['include_children'], 'nice_testimonials_bool', false ),
			'id'               => array( '', 'sanitize_key' ),
		);

		return $defaults;
	}

	/**
	 * Create widget form.
	 *
	 * @since  1.0
	 *
	 * @param  array $instance Instance of this widget.
	 * @return void
	 */
	function form( $instance ) {
		// Normalize our instance.
		$instance = $this->normalizer->normalize_instance( $instance );

		// Prepare values to pass to template getter.
		$extract = $instance;

		/**
		 * Add current object to values for template getter, so it can be used
		 * inside the template.
		 */
		$extract['widget'] = $this;

		/**
		 * Call form template.
		 */
		nice_testimonials_admin_get_template_part( 'widget-testimonials-form', '', false, $extract );
	}

	/**
	 * Update widget.
	 *
	 * @since 1.0
	 *
	 * @param  array $new_instance
	 * @param  array $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$this->cache->flush();

		// Normalize instance.
		$new_instance = $this->normalizer->normalize_instance( $new_instance );

		return $new_instance;
	}

	/**
	 * Display widget in the front-end.
	 *
	 * @since  1.0
	 *
	 * @param  array $args
	 * @param  array $instance
	 */
	function widget( $args, $instance ) {
		_nice_testimonials_doing_widget( true );

		// If widget cache is found, print it and return early.
		if ( $cache = $this->cache->get() ) {
			echo $cache; // WPCS: XSS ok.

			_nice_testimonials_doing_widget( false );

			return;
		}

		// Normalize instance.
		$instance = $this->normalizer->normalize_instance( $instance );
		$instance = apply_filters( 'nice_testimonials_widget_instance', $instance );

		// Use a custom template for widget single elements.
		add_filter( 'nice_testimonials_post_template', array( $this, 'widget_template' ) );

		$settings = nice_testimonials_settings();

		// Define custom fields to be displayed.
		$show_default_fields = ( 'default' === $instance['display_fields'] );
		$fields = array();
		foreach ( $instance['fields'] as $key => $value ) {
			$fields[ $key ] = $show_default_fields ? $settings['fields'][ $key ] : $value;
		}

		// Define sorting criteria.
		$orderby = ( 'default' === $instance['orderby'] ) ? $settings['orderby'] : $instance['orderby'];

		// Define order criteria.
		$order = ( 'default' === $instance['order'] ) ? $settings['order'] : $instance['order'];

		// Build query for taxonomies.
		$tax_query = array();
		if ( $instance['category'] ) {
			$tax_query[] = array(
				'taxonomy'         => nice_testimonials_category_name(),
				'field'            => 'id',
				'terms'            => explode( ',', $instance['category'] ),
				'include_children' => $instance['include_children'],
			);
		}
		$tax_query = apply_filters( 'nice_testimonials_widget_tax_query', $tax_query, $instance );

		ob_start();

		// Begin widget.
		$testimonials  = isset( $args['before_widget'] ) ? $args['before_widget'] : '';
		$testimonials .= '<div class="nice-testimonials-widget-box widget-entries">';

		// Get and add title.
		$before_title = isset( $args['before_title'] ) ? $args['before_title'] : '';
		$after_title = isset( $args['after_title'] ) ? $args['after_title'] : '';
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$testimonials .= $title ? ( $before_title . $title . $after_title ) : '';

		$testimonials .= nice_testimonials( apply_filters( 'nice_testimonials_widget_query_args', array(
			'columns'          => 1,
			'avoidcss'         => $settings['avoidcss'],
			'limit'            => $instance['limit'],
			'orderby'          => $orderby,
			'order'            => $order,
			'category'         => $instance['category'],
			'image_size'       => $instance['image_size'],
			'include_children' => $instance['include_children'],
			'author'           => $fields['author'],
			'avatar'           => $fields['avatar'],
			'url'              => $fields['url'],
			'id'               => $instance['id'],
			'tax_query'        => $tax_query,
			'echo'             => false,
		) ) );

		$testimonials .= '</div>';
		$testimonials .= isset( $args['after_widget'] ) ? $args['after_widget'] : '';

		echo $testimonials; // WPCS: XSS ok.

		// Remove custom template.
		remove_filter( 'nice_testimonials_post_template', array( $this, 'widget_template' ) );

		$this->cache->set( ob_get_flush() );

		_nice_testimonials_doing_widget( false );
	}
}
endif;
