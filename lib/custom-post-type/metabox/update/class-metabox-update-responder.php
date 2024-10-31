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
 * Class Nice_Testimonials_MetaboxUpdateResponder
 *
 * This class takes charge of the interaction of updated Nice_Testimonials_Metabox
 * instances with WordPress APIs.
 *
 * @since 1.1
 */
class Nice_Testimonials_MetaboxUpdateResponder extends Nice_Testimonials_UpdateResponder {
	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.1
	 */
	protected function set_interactions() {
		/**
		 * Schedule data saving process.
		 */
		add_action( 'edit_post', array( $this, 'save_data' ) );

		/**
		 * Fire default functionality.
		 */
		parent::set_interactions();
	}

	/**
	 * Save data for custom fields.
	 *
	 * @since  1.1
	 *
	 * @return int
	 */
	public function save_data() {
		$data = $this->data->get_info();
		$post = get_post();

		$post_id = '';

		if ( isset( $_POST['post_ID'] ) ) {
			$post_id = intval( $_POST['post_ID'] );
		}

		// Don't continue if we don't have a valid post ID.
		if ( ! $post_id ) {
			return null;
		}

		if ( empty( $data ) ) {
			return null;
		}

		// Make sure this validation only applies to the correct post types.
		if ( ! in_array( $post->post_type, $data->post_types, true ) ) {
			return $post_id;
		}

		// Return ID if doing autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Return ID if the current user can't edit this post.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		foreach ( $data->fields as $field ) {
			if ( 'info' !== $field['type'] ) {
				// Verify that the nonce is valid.
				if ( ! isset( $_POST[ $field['name'] . '_nonce' ] ) || ! wp_verify_nonce( wp_unslash( $_POST[ $field['name'] . '_nonce' ] ), $field['name'] ) ) {
					continue;
				}

				// Return ID if this is a page and the current user can't edit it.
				if ( ! isset( $_POST['post_type'] ) || ( 'page' === $_POST['post_type'] && ( ! current_user_can( 'edit_page', $post_id ) ) ) ) {
					return $post_id;
				}

				// Return ID if we're not in a editing context.
				if ( ! isset( $_POST['action'] ) || 'editpost' !== $_POST['action'] ) {
					return $post_id;
				}

				$old_value = get_post_meta( $post_id, $field['name'], true );

				if ( isset( $_POST[ $field['name'] ] ) ) {
					$new_value = wp_unslash( $_POST[ $field['name'] ] );

					if ( $new_value && $new_value !== $old_value ) {
						update_post_meta( $post_id, $field['name'], $new_value );
					} elseif ( '' === $new_value && $old_value ) {
						delete_post_meta( $post_id, $field['name'], $old_value );
					} elseif ( '' === $old_value ) {
						add_post_meta( $post_id, $field['name'], $new_value, true );
					}

				} elseif ( 'checkbox' === $field['type'] && ! isset( $_POST[ $field['name'] ] ) ) {
					delete_post_meta( $post_id, $field['name'], $old_value );
				} elseif ( isset( $_POST[ $field['name'] ] ) ) {
					$new_value = wp_unslash( $_POST[ $field['name'] ] );
					update_post_meta( $post_id, $field['name'], $new_value );
				}
			}
		}

		return $post_id;
	}
}
