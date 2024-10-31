<?php
/**
 * NiceThemes Widget API
 *
 * @package Nice_Testimonials_Widget_API
 * @license GPL-2.0+
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Nice_Testimonials_Widget
 *
 * Standard abstract class for widget creation.
 *
 * @see   WP_Widget
 *
 * @since 1.0
 *
 * @property-read $textdomain
 */
abstract class Nice_Testimonials_WP_Widget extends WP_Widget {
	/**
	 * Internal handler for the current widget.
	 *
	 * @since 1.0
	 * @var   string
	 */
	public $id = 'nice-testimonials-widget';

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
	 * List of arguments to construct widget output.
	 *
	 * @since 1.0
	 * @var   null|array
	 */
	public $args = null;

	/**
	 * Name of the template for the public-facing side of the widget.
	 *
	 * @since 1.0
	 * @var   string
	 */
	public $template = '';

	/**
	 * Name of the template for the admin-facing side of the widget.
	 *
	 * @since 1.0
	 * @var   string
	 */
	public $form_template = '';

	/**
	 * List of hooks to run when loading widgets publicly.
	 *
	 * @since 1.0
	 * @var   array
	 */
	public $template_hooks = array();

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
	 * Text domain for this widget.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $textdomain = '';

	/**
	 * Setup initial data.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		static $order = 1;

		/**
		 * Process values.
		 */
		$this->instance_defaults = $this->get_instance_defaults();
		$this->template_hooks    = $this->get_template_hooks();
		$this->refresh           = apply_filters( 'nice_testimonials_widget_refresh', $this->refresh );
		$this->normalizer        = new Nice_Testimonials_Widget_Normalizer( $this->instance_defaults );
		$this->cache             = new Nice_Testimonials_Widget_Cache( $this->id . ':' . $order, $this->refresh );
		$this->textdomain        = nice_testimonials_textdomain();

		/**
		 * Initialize widget.
		 */
		parent::__construct( $this->id, $this->name, $this->options );

		/**
		 * Let plugins and themes hook in here.
		 */
		do_action( 'nice_testimonials_widget_loaded', $this );

		$order++;
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
	 * Obtain default values for widget instance.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	protected function get_instance_defaults() {
		return array();
	}

	/**
	 * Normalize a settings instance.
	 *
	 * This is a alias for `$this->normalizer->normalize_instance()`.
	 *
	 * @see   Nice_Testimonials_Widget::normalizer::normalize_instance()
	 *
	 * @since 1.0
	 *
	 * @param $instance
	 *
	 * @return array
	 */
	protected function normalize_instance( $instance ) {
		if ( ! $this->normalizer ) {
			return $instance;
		}

		return $this->normalizer->normalize_instance( $instance );
	}

	/**
	 * Cache contents of the widget.
	 *
	 * @see   Nice_Testimonials_Widget::cache::set()
	 *
	 * @since 1.0
	 *
	 * @param string $data Data to be stored.
	 */
	protected function cache( $data = '' ) {
		if ( ! $this->cache ) {
			return;
		}

		$this->cache->set( $data );
	}

	/**
	 * Obtain cached contents of the widget.
	 *
	 * @see   Nice_Testimonials_Widget::cache::get()
	 *
	 * @since 1.0
	 *
	 * @return null|string
	 */
	protected function get_cached() {
		if ( ! $this->cache ) {
			return null;
		}

		return $this->cache->get();
	}

	/**
	 * Cache contents of the widget.
	 *
	 * @see    Nice_Testimonials_Widget::cache::flush_cache()
	 *
	 * @since  1.0
	 *
	 * @return null|string
	 */
	public function flush_cache() {
		if ( ! $this->cache ) {
			return null;
		}

		$this->cache->flush();
	}

	/**
	 * Obtain the list of hooks to be applied to the template of the widget.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	protected function get_template_hooks() {
		return array();
	}

	/**
	 * Add actions to generate widget content.
	 *
	 * @since 1.0
	 */
	protected function add_template_hooks() {
		if ( empty( $this->template_hooks ) || ! is_array( $this->template_hooks ) ) {
			return;
		}

		foreach ( $this->template_hooks as $hook ) {
			/**
			 * Add actions.
			 */
			if ( ! isset( $hook['type'] ) || 'action' === $hook['type'] ) {
				add_action( $hook['tag'], $hook['function'], isset( $hook['priority'] ) ? $hook['priority'] : 10, isset( $hook['accepted_args'] ) ? $hook['accepted_args'] : 1 );
				continue;
			}

			/**
			 * Add filters.
			 */
			if ( 'filter' === $hook['type'] ) {
				add_filter( $hook['tag'], $hook['function'], isset( $hook['priority'] ) ? $hook['priority'] : 10, isset( $hook['accepted_args'] ) ? $hook['accepted_args'] : 1 );
			}
		}
	}

	/**
	 * Remove actions to prevent recursion in future instances.
	 *
	 * @since 1.0
	 */
	protected function remove_template_hooks() {
		if ( empty( $this->template_hooks ) || ! is_array( $this->template_hooks ) ) {
			return;
		}

		foreach ( $this->template_hooks as $hook ) {
			/**
			 * Remove actions.
			 */
			if ( ! isset( $hook['type'] ) || 'action' === $hook['type'] ) {
				remove_action( $hook['tag'], $hook['function'], isset( $hook['priority'] ) ? $hook['priority'] : 10 );
				continue;
			}

			/**
			 * Remove filters.
			 */
			if ( 'filter' === $hook['type'] ) {
				remove_filter( $hook['tag'], $hook['function'], isset( $hook['priority'] ) ? $hook['priority'] : 10 );
			}
		}
	}

	/**
	 * Run processes before the widget is printed.
	 *
	 * @since 1.0
	 */
	protected function before_output() {
		$this->add_template_hooks();
	}

	/**
	 * Run processes after the widget is printed.
	 *
	 * @since 1.0
	 */
	protected function after_output() {
		$this->remove_template_hooks();
	}

	/**
	 * Create widget form.
	 *
	 * @since  1.0
	 *
	 * @uses   nice_testimonials_admin_get_template_part()
	 *
	 * @param  array $instance Instance of this widget.
	 *
	 * @return void
	 */
	function form( $instance ) {
		// Normalize our instance.
		$this->args = $this->normalize_instance( $instance );

		/**
		 * Set the current widget, so we can get its values from the runtime
		 * of the template.
		 */
		nice_testimonials_admin_set_current_widget( $this );

		/**
		 * Call form template.
		 */
		nice_testimonials_admin_get_template_part( str_replace( '.php', '', $this->form_template ) );

		/**
		 * Kill current widget.
		 */
		nice_testimonials_admin_unset_current_widget();
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
		$this->flush_cache();

		// Normalize instance.
		$new_instance = $this->normalize_instance( $new_instance );

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
	function widget( $args, $instance = null ) {
		// If widget cache is found, print it and return early.
		if ( $cache = $this->get_cached() ) {
			echo $cache; // WPCS: XSS ok.

			return;
		}

		// Normalize our instance.
		$this->args = $this->normalize_instance( $instance );

		$this->print_widget();
	}

	/**
	 * Print widget in the front-end.
	 *
	 * @since 1.0
	 */
	protected function print_widget() {
		/**
		 * Set the current widget, so we can get its values from other contexts.
		 */
		nice_testimonials_set_current_widget( $this );

		/**
		 * Start buffering output, so we can store it to cache.
		 */
		ob_start();

		/**
		 * Run processes before output.
		 */
		$this->before_output();

		/**
		 * Load template for the current widget.
		 */
		nice_testimonials_get_template( $this->template );

		/**
		 * Run processes after output.
		 */
		$this->after_output();

		/**
		 * Save output to cache and flush buffered output.
		 */
		$this->cache( ob_get_flush() );

		/**
		 * Kill the current widget.
		 */
		nice_testimonials_unset_current_widget();
	}

	/**
	 * Output the title of a widget.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Testimonials_WP_Widget $widget Instance of widget object.
	 */
	public static function widget_title( Nice_Testimonials_WP_Widget $widget ) {
		$title = isset( $widget->args['title'] ) ? $widget->args['title'] : '';

		$widget_title = '<h3 class="widget-title">' . $title . '</h3>';

		echo apply_filters( 'nice_testimonials_widget_title', $widget_title, $title, $widget ); // WPCS: XSS ok.
	}
}
