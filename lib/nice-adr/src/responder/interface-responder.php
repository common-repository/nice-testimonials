<?php
/**
 * NiceThemes ADR
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
 * Interface Nice_Testimonials_ResponderInterface
 *
 * @package Nice_Testimonials_ADR
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
interface Nice_Testimonials_ResponderInterface {
	/**
	 * Fire main responder functionality.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Testimonials_EntityInterface $instance
	 */
	public function __invoke( Nice_Testimonials_EntityInterface $instance );
}
