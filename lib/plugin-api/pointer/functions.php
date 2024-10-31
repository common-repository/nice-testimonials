<?php
/**
 * NiceThemes Plugin API
 *
 * This file contains general helper functions that allow interactions with
 * this module in an easier way.
 *
 * @package Nice_Testimonials_Plugin_API
 * @license GPL-2.0+
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create an admin pointer.
 *
 * @uses   nice_testimonials_create()
 *
 * @since  1.0
 *
 * @param  array $data Information for the new pointer.
 *
 * @return Nice_Testimonials_Pointer
 */
function nice_testimonials_create_pointer( array $data ) {
	return nice_testimonials_create( 'Nice_Testimonials_Pointer', $data );
}

/**
 * Create a new collection of pointers.
 *
 * @uses   nice_testimonials_create()
 *
 * @since  1.0
 *
 * @param  array $pointers List of Nice_Testimonials_Pointer instances.
 *
 * @return Nice_Testimonials_Pointer_Collection
 */
function nice_testimonials_create_pointer_collection( array $pointers = array() ) {
	return nice_testimonials_create( 'Nice_Testimonials_Pointer_Collection', array(
			'pointers' => $pointers,
		)
	);
}

/**
 * Obtain an instance of the pointer service.
 *
 * @uses   nice_testimonials_service()
 *
 * @since  1.0
 *
 * @return Nice_Testimonials_Service
 */
function nice_testimonials_pointer_service() {
	return nice_testimonials_service( 'Nice_Testimonials_Pointer' );
}

/**
 * Obtain an instance of the pointer collection service.
 *
 * @uses   nice_testimonials_service()
 *
 * @since  1.0
 *
 * @return Nice_Testimonials_Pointer_CollectionService
 */
function nice_testimonials_pointer_collection_service() {
	return nice_testimonials_service( 'Nice_Testimonials_Pointer_Collection' );
}

/**
 * Add admin pointers to a previous list.
 *
 * @uses   nice_testimonials_create_pointer()
 *
 * @since  1.0
 *
 * @param  array $pointers List of pointers.
 * @param  array $data     Information to create new pointers.
 *
 * @return array|null
 */
function nice_testimonials_add_pointers( array $pointers = null, array $data = null ) {
	if ( empty( $data ) ) {
		return null;
	}

	/**
	 * Try to register new pointers.
	 */
	foreach ( $data as $pointer_data ) {
		// Break iteration in case the current data-set is empty.
		if ( empty( $pointer_data ) ) {
			continue;
		}

		$pointers[] = nice_testimonials_create_pointer( $pointer_data );
	}

	return $pointers;
}

/**
 * Add a pointer to a specific collection.
 *
 * @uses  Nice_Testimonials_Pointer_CollectionService::add_pointer()
 *
 * @since 1.0
 *
 * @param Nice_Testimonials_Pointer_Collection $collection
 * @param Nice_Testimonials_Pointer            $pointer
 */
function nice_testimonials_add_pointer( Nice_Testimonials_Pointer_Collection $collection, Nice_Testimonials_Pointer $pointer ) {
	static $collection_service = null;

	// Obtain service.
	if ( ! $collection_service ) {
		$collection_service = nice_testimonials_pointer_collection_service();
	}

	$collection_service->add_pointer( $collection, $pointer );
}

/**
 * Associate a list of pointers to a collection.
 *
 * @uses   nice_testimonials_create_pointer_collection()
 * @uses   nice_testimonials_add_pointer()
 *
 * @since  1.0
 *
 * @param  Nice_Testimonials_Pointer_Collection      $collection
 * @param  array                              $pointers
 *
 * @return Nice_Testimonials_Pointer_Collection|null
 */
function nice_testimonials_process_pointer_collection( Nice_Testimonials_Pointer_Collection $collection = null, array $pointers = null ) {
	if ( empty( $pointers ) ) {
		return null;
	}

	if ( ! $collection ) {
		return nice_testimonials_create_pointer_collection( $pointers );
	}

	foreach ( $pointers as $pointer ) {
		nice_testimonials_add_pointer( $collection, $pointer );
	}

	return $collection;
}
