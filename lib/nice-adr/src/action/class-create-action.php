<?php
/**
 * NiceThemes ADR
 *
 * @package Nice_Testimonials_ADR
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Testimonials_CreateAction
 *
 * This class takes charge of the creation process of
 * Nice_Testimonials_EntityInterface instances, and the preparation of the related
 * responder. It's meant to be used as a default class for domains that, while
 * needing to implement a Create action, don't need any specific functionality
 * for it.
 *
 * @since 1.0
 */
class Nice_Testimonials_CreateAction extends Nice_Testimonials_CreateActionAbstract {}
