<?php
/**
 * NiceThemes Plugin API
 *
 * @package Nice_Testimonials_Plugin_API
 * @since   1.1
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Testimonials_GlancerDisplayResponder
 *
 * This class takes charge of the Nice_Testimonials_Glancer instances to be
 * displayed through WordPress APIs.
 *
 * @since 1.1
 */
class Nice_Testimonials_GlancerDisplayResponder extends Nice_Testimonials_DisplayResponder {
	/**
	 * Fire main responder functionality.
	 *
	 * @since 1.1
	 *
	 * @param Nice_Testimonials_EntityInterface $glancer Initialised glancer instance.
	 */
	public function __invoke( Nice_Testimonials_EntityInterface $glancer ) {
		global $wp_version;

		/**
		 * Kill process if WordPress version is lower than 3.8.
		 */
		if ( ! version_compare( $wp_version, '3.8', '>=' ) ) {
			return;
		}

		/**
		 * Fire default functionality.
		 */
		parent::__invoke( $glancer );
	}

	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.1
	 */
	protected function set_interactions() {
		/**
		 * Create custom glancer items.
		 */
		add_action( 'dashboard_glance_items', array( $this, 'show' ) );

		/**
		 * Print styles for custom glancer.
		 */
		add_action( 'admin_head', array( $this, 'print_styles' ) );

		/**
		 * Fire default functionality.
		 */
		parent::set_interactions();
	}

	/**
	 * Show the items on the dashboard widget.
	 *
	 * @uses  Nice_Testimonials_GlancerDisplayResponder::get_single_item()
	 *
	 * @since 1.1
	 */
	public function show() {
		$data = $this->data->get_info();

		if ( empty( $data->items ) ) {
			return;
		}

		foreach ( $data->items as $item ) {
			if ( get_post_type_object( $item['type'] ) ) {
				echo self::get_single_item( $item ); // WPCS: XSS ok.
			}
		}

		// Reset items, so items aren't shown again if show() is re-called
		unset( $this->items );
	}

	/**
	 * Build and return the data and markup for a single item.
	 *
	 * If the item count is zero, return an empty string, to avoid visual clutter.
	 *
	 * @uses   Nice_Testimonials_GlancerDisplayResponder::get_markup()
	 *
	 * @since  1.1
	 *
	 * @param  array  $item Registered item.
	 *
	 * @return string       Markup, or empty string if item count is zero.
	 */
	protected static function get_single_item( array $item ) {
		if ( empty( $item['type'] ) ) {
			return null;
		}

		$num_posts = wp_count_posts( $item['type'] );
		$count = $num_posts->{ $item['status'] };

		if ( ! $count ) {
			return '';
		}

		$text = number_format_i18n( $count ) . ' ' . self::get_label( $item, $count );
		$text = self::get_link( $text, self::get_link_url( $item ) );

		return self::get_markup( $text, $item['type'] );
	}

	/**
	 * Get the singular or plural label for an item.
	 *
	 * @uses  get_post_type_object()
	 *
	 * @since 1.1
	 *
	 * @param array   $item  Registered item.
	 * @param int     $count Number of items present in WP.
	 *
	 * @return string
	 */
	protected static function get_label( array $item, $count ) {
		$post_type = get_post_type_object( $item['type'] );
		$label     = ( 1 === $count ) ? $post_type->labels->singular_name : $post_type->labels->name;

		// Append status for non-publish statuses for disambiguation
		if ( 'publish' !== $item['status'] ) {
			$label .= ' (' . $item['status'] . ')';
		}

		return $label;
	}

	/**
	 * Build the URL that linked items use.
	 *
	 * @since  1.1
	 *
	 * @param  array $item Registered item.
	 *
	 * @return string      Admin URL to view the entries of the given post type with the given status
	 */
	protected static function get_link_url( array $item ) {
		return 'edit.php?post_status=' . $item['status'] . '&amp;post_type=' . $item['type'];
	}

	/**
	 * Wrap a glance item in a link, if the current user can edit posts.
	 *
	 * @since  1.1
	 *
	 * @param  string  $text Text to potentially wrap in a link.
	 * @param  string  $href Link target.
	 *
	 * @return string        Text wrapped in a link if current user can edit posts, or original text otherwise.
	 */
	protected static function get_link( $text, $href ) {
		if ( current_user_can( 'edit_posts' ) ) {
			return '<a href="' . esc_url( $href ) . '">' . $text . '</a>';
		}

		return $text;
	}

	/**
	 * Wrap number and text within list item markup.
	 *
	 * @since 1.1
	 *
	 * @param  string $text      Text to display. May be wrapped in a link.
	 * @param  string $post_type
	 * @return string
	 */
	protected static function get_markup( $text, $post_type ) {
		return '<li class="' . sanitize_html_class( $post_type . '-count' ) . '">' . $text . '</li>' . "\n";
	}

	/**
	 * Print styles for the currently supported items.
	 *
	 * @since 1.1
	 */
	public function print_styles() {
		$data = $this->data->get_info();

		foreach ( $data->items as $item ) :
			if ( ! empty( $item['glyph'] ) ) : ?>
				<style type="text/css">
					#dashboard_right_now li.<?php echo esc_attr( $item['type'] ); ?>-count a:before,
					#dashboard_right_now li.<?php echo esc_attr( $item['type'] ); ?>-count span:before {
						content: "<?php echo esc_attr( $item['glyph'] ); ?>";
					}
				</style>
			<?php endif;
		endforeach;
	}
}
