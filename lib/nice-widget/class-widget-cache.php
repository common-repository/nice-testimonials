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
 * Nice_Testimonials_Widget_Cache
 *
 * Manage cache for widgets.
 *
 * @since 1.0
 */
class Nice_Testimonials_Widget_Cache {
	/**
	 * Internal ID for caching purposes.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $cache_id = '';

	/**
	 * Expiration time for the widget cache.
	 *
	 * @since 1.0
	 * @var   int
	 */
	protected $expiration = 300;

	/**
	 * Indicate if cache is enabled.
	 *
	 * @since 1.0
	 * @var   bool
	 */
	protected $enabled = true;

	/**
	 * Initialize widget properties.
	 *
	 * @since 1.0
	 *
	 * @param string $cache_id
	 * @param int    $expiration
	 */
	public function __construct( $cache_id, $expiration = 300 ) {
		// Check if cache should be used.
		$enabled = ! ( defined( 'WP_DEBUG' ) && WP_DEBUG );
		$this->enabled = apply_filters( 'nice_testimonials_use_widget_cache', $enabled );

		if ( $this->enabled ) {
			$this->cache_id   = $cache_id;
			$this->expiration = $expiration;
		}
	}

	/**
	 * Retrieve widget cache.
	 *
	 * @since  1.0
	 *
	 * @return bool|mixed
	 */
	public function get() {
		if ( ! $this->enabled ) {
			return null;
		}

		return wp_cache_get( $this->cache_id, 'widget' );
	}

	/**
	 * Save widget cache.
	 *
	 * @since 1.0
	 *
	 * @param  mixed $data
	 *
	 * @return void
	 */
	public function set( $data ) {
		if ( ! $this->enabled ) {
			return;
		}

		wp_cache_set( $this->cache_id, $data, 'widget', $this->expiration );
	}

	/**
	 * Remove widget cache.
	 *
	 * @since 1.0
	 */
	public function flush() {
		if ( ! $this->enabled ) {
			return null;
		}

		wp_cache_delete( $this->cache_id, 'widget' );
	}
}
