<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * About Page Header for Admin UI.
 *
 * @package Nice_Testimonials_Admin_UI
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
	<div class="heading">
		<div class="masthead about">
			<h1><?php echo esc_html( nice_testimonials_plugin_name() . ' ' . nice_testimonials_plugin_version() ); ?></h1>
			<h2><?php esc_html_e( 'A beautiful and organized way to show quotes from your customers.', 'nice-testimonials' ); ?></h2>
		</div>
	</div>
