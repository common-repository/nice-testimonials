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
 * Class Nice_Testimonials_Post_Type_AdminCreateResponder
 *
 * This class takes charge of the interaction of created Nice_Testimonials_Post_Type_Admin
 * instances with WordPress APIs.
 *
 * @since 1.1
 */
class Nice_Testimonials_Post_Type_AdminCreateResponder extends Nice_Testimonials_CreateResponder {
	/**
	 * Fire main responder functionality.
	 *
	 * @since 1.1
	 *
	 * @param Nice_Testimonials_EntityInterface $post_type_admin
	 */
	public function __invoke( Nice_Testimonials_EntityInterface $post_type_admin ) {
		// Abort if we don't have a post type name.
		if ( empty( $post_type_admin->post_type->args['name'] ) ) {
			return;
		}

		/**
		 * Fire default functionality.
		 */
		parent::__invoke( $post_type_admin );
	}

	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.1
	 */
	protected function set_interactions() {
		/**
		 * Add thumbnail support for this post type if required.
		 */
		$this->add_theme_support_maybe();

		/**
		 * Fire default functionality.
		 */
		parent::set_interactions();
	}

	/**
	 * Add thumbnail support for this post type if required.
	 *
	 * @since 1.0
	 */
	protected function add_theme_support_maybe() {
		if ( ! in_array( 'thumbnail', $this->data->post_type->args['args']['supports'], true ) ) {
			return;
		}

		global $pagenow;

		if ( ! in_array( $pagenow, array( 'post.php', 'post-new.php' ), true ) ) {
			return;
		}

		if ( 'post.php' === $pagenow ) {
			$current_post_type = empty( $_GET['post'] ) ? null : get_post_type( wp_unslash( $_GET['post'] ) );
		}

		if ( empty( $current_post_type ) ) {
			$current_post_type = empty( $_GET['post_type'] ) ? null : wp_unslash( $_GET['post_type'] );
		}

		if ( ( $post_type = $this->data->post_type->args['name'] ) !== $current_post_type ) {
			return;
		}

		add_theme_support( 'post-thumbnails', array( $post_type ) );
	}
}
