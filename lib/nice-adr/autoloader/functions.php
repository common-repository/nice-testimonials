<?php
/**
 * NiceThemes ADR
 *
 * This file contains general functions that allow interactions with
 * this helper in an easier way.
 *
 * @package Nice_Testimonials_ADR
 * @license GPL-2.0+
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load a given directory recursively.
 *
 * @uses   Nice_Testimonials_AutoLoader::__construct()
 *
 * @since  1.0
 *
 * @param  string                $path           File or folder to be loaded recursively.
 * @param  string                $root_directory Base folder of main namespace.
 * @param  array                 $exclude        List of files and folders to exclude.
 *
 * @return Nice_Testimonials_AutoLoader
 */
function nice_testimonials_autoload( $path, $root_directory = '', array $exclude = null ) {
	return new Nice_Testimonials_AutoLoader( $path, $root_directory, $exclude );
}

/**
 * Load a list of directories recursively.
 *
 * @uses   nice_testimonials_autoload()
 *
 * @since  1.0
 *
 * @param  array  $libraries      List of files or folders to be loaded recursively.
 * @param  string $root_directory Base folder of main namespace.
 * @param  array  $exclude        List of files and folders to exclude.
 *
 * @return Nice_Testimonials_AutoLoader
 */
function nice_testimonials_autoload_libraries( array $libraries, $root_directory = '', array $exclude = null ) {
	if ( ! empty( $libraries ) ) {
		foreach ( $libraries as $library ) {
			nice_testimonials_autoload( $library, $root_directory, $exclude );
		}
	}
}
