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
 * Obtain current plugin instance.
 *
 * @uses   nice_testimonials_request()
 *
 * @since  1.0
 *
 * @return Nice_Testimonials_Plugin
 */
function nice_testimonials_plugin() {
	static $plugin = null;

	if ( ! is_null( $plugin ) ) {
		return $plugin;
	}

	$data = apply_filters( 'nice_testimonials_plugin_data', array() );

	/**
	 * Initialize plugin.
	 */
	return $plugin = nice_testimonials_create( 'Nice_Testimonials_Plugin', $data );
}

/**
 * Initialize public-facing side of plugin.
 *
 * @uses  nice_testimonials_plugin()
 *
 * @since 1.0
 *
 * @return Nice_Testimonials_Plugin
 */
function nice_testimonials_plugin_init() {
	// Return early if we don't want to initialize the plugin.
	if ( ! apply_filters( 'nice_testimonials_plugin_init', true ) ) {
		return null;
	}

	static $i = 0, $plugin = null;

	$plugin_file     = defined( 'NICE_TESTIMONIALS_PLUGIN_FILE' ) ? NICE_TESTIMONIALS_PLUGIN_FILE : __FILE__;
	$basename        = plugin_basename( $plugin_file );
	$allowed_actions = array( 'activate_' . $basename, 'deactivate_' . $basename );

	/**
	 * Trigger error if this function is being called recursively.
	 */
	if ( $i ) {
		if ( in_array( current_filter(), $allowed_actions, true ) ) {
			return $plugin;
		}

		_nice_testimonials_doing_it_wrong( __FUNCTION__, esc_html__( 'This function should not be called more than once. Please hook your actions to nice_testimonials_plugin_after_init in order to prevent recursion.', 'nice-testimonials-plugin-textdomain' ) );
	}

	// Update counter.
	$i++;

	/**
	 * @hook nice_testimonials_plugin_before_init
	 *
	 * Process actions before the main plugin object gets initialized.
	 *
	 * Functions and methods that use internal functionality of the
	 * Nice_Testimonials_Plugin domain should not be hooked here in order to
	 * prevent recursion.
	 *
	 * @since 1.0
	 */
	do_action( 'nice_testimonials_plugin_before_init' );

	/**
	 * Initialize instance.
	 */
	$plugin = nice_testimonials_plugin();

	/**
	 * @hook nice_testimonials_plugin_after_init
	 *
	 * Process actions after the main plugin object gets initialized.
	 *
	 * Functions and methods that use internal functionality of the
	 * Nice_Testimonials_Plugin domain are safe from recursion and can be hooked
	 * from this point on.
	 *
	 * @since 1.0
	 */
	do_action( 'nice_testimonials_plugin_after_init', $plugin );

	return $plugin;
}

/**
 * Obtain an instance of this domain's service.
 *
 * @uses   nice_testimonials_service()
 *
 * @since  1.0
 *
 * @return Nice_Testimonials_PluginService
 */
function nice_testimonials_plugin_service() {
	return nice_testimonials_service( 'Nice_Testimonials_Plugin' );
}

/**
 * Fire activation process.
 *
 * @uses  nice_testimonials_request()
 *
 * @since 1.0
 */
function nice_testimonials_activate() {
	// Return early if we don't want to initialize the plugin.
	if ( ! apply_filters( 'nice_testimonials_plugin_init', true ) ) {
		return;
	}

	/**
	 * Make sure the plugin gets initialized before the activation process.
	 */
	$plugin = nice_testimonials_plugin_init();

	/**
	 * @hook nice_testimonials_activate
	 *
	 * All processes that need to run during the activation process should be
	 * hooked here.
	 *
	 * @since 1.0
	 */
	do_action( 'nice_testimonials_activate', $plugin );
}

/**
 * Fire deactivation process.
 *
 * @uses  nice_testimonials_request()
 *
 * @since 1.0
 */
function nice_testimonials_deactivate() {
	// Return early if we don't want to initialize the plugin.
	if ( ! apply_filters( 'nice_testimonials_plugin_init', true ) ) {
		return;
	}

	/**
	 * Make sure the plugin gets initialized before the activation process.
	 */
	$plugin = nice_testimonials_plugin_init();

	/**
	 * @hook nice_testimonials_activate
	 *
	 * All processes that need to run during the deactivation process should be
	 * hooked here.
	 *
	 * @since 1.0
	 */
	do_action( 'nice_testimonials_deactivate', $plugin );
}

if ( ! function_exists( 'nice_testimonials_plugin_property' ) ) :
/**
 * Get the value for a property of the current plugin instance.
 *
 * @uses   nice_testimonials_plugin()
 *
 * @since  1.0
 *
 * @param  string $property Name of the property to get value from.
 *
 * @return mixed
 */
function nice_testimonials_plugin_property( $property ) {
	$plugin = nice_testimonials_plugin();

	if ( $property && property_exists( $plugin, $property ) ) {
		return $plugin->{$property};
	}

	return null;
}
endif;

/**
 * Use this function to either initialize plugin settings or normalize them in
 * case some value is missing from the DB.
 *
 * @since  1.0
 *
 * @return array
 */
function nice_testimonials_default_settings() {
	static $defaults = null;

	if ( is_null( $defaults ) ) {
		$defaults = apply_filters( 'nice_testimonials_default_settings', array() );

		if ( ! is_array( $defaults ) ) {
			_nice_testimonials_doing_it_wrong( __FUNCTION__, 'The <code>nice_testimonials_default_settings</code> filter should always return an array.' );
		}
	}

	return $defaults;
}

/**
 * Reload plugin settings. This is useful if the options entry in the DB has
 * been modified by another plugin or theme.
 *
 * @since 1.0
 */
function nice_testimonials_refresh_settings() {
	$service = nice_testimonials_plugin_service();
	$service::refresh_settings( nice_testimonials_plugin() );
}

/**
 * Obtain current plugin settings.
 *
 * @uses   nice_testimonials_plugin_property()
 * @uses   nice_testimonials_default_settings()
 *
 * @since  1.0
 *
 * @param  bool  $refresh Set to true if settings have been updated.
 *
 * @return array
 */
function nice_testimonials_settings( $refresh = false ) {
	// Refresh settings if needed.
	if ( $refresh ) {
		nice_testimonials_refresh_settings();
	}

	$args     = (array) nice_testimonials_plugin_property( 'settings' );
	$settings = nice_testimonials_wp_parse_args( $args, (array) nice_testimonials_default_settings() );

	return apply_filters( 'nice_testimonials_settings', $settings );
}

/**
 * Obtain internal name of plugin settings.
 *
 * @uses   nice_testimonials_plugin_property()
 *
 * @since  1.0
 *
 * @return string
 */
function nice_testimonials_settings_name() {
	static $name = null;

	if ( ! is_null( $name ) ) {
		return $name;
	}

	return $name = apply_filters( 'nice_testimonials_settings_name', nice_testimonials_plugin_property( 'settings_name' ) );
}

/**
 * Check if we're in an AJAX context.
 *
 * @uses   nice_testimonials_plugin_property()
 *
 * @since  1.0
 *
 * @return bool
 */
function nice_testimonials_doing_ajax() {
	static $doing_ajax = null;

	if ( ! is_null( $doing_ajax ) ) {
		return $doing_ajax;
	}

	return $doing_ajax = apply_filters( 'nice_testimonials_doing_ajax', nice_testimonials_plugin_property( 'doing_ajax' ) );
}

/**
 * Obtain the name of the plugin.
 *
 * @uses   nice_testimonials_plugin_property()
 *
 * @since  1.0
 *
 * @return string
 */
function nice_testimonials_plugin_name() {
	static $name = null;

	if ( ! is_null( $name ) ) {
		return $name;
	}

	return $name = apply_filters( 'nice_testimonials_plugin_name', nice_testimonials_plugin_property( 'name' ) );
}

/**
 * Obtain the name of the plugin file.
 *
 * @uses   nice_testimonials_plugin_property()
 *
 * @since  1.0
 *
 * @param  bool   $use_constant Use `NICE_TESTIMONIALS_PLUGIN_FILE` constant to get plugin file.
 *
 * @return string
 */
function nice_testimonials_plugin_file( $use_constant = false ) {
	if ( $use_constant ) {
		return defined( 'NICE_TESTIMONIALS_PLUGIN_FILE' ) ? NICE_TESTIMONIALS_PLUGIN_FILE : null;
	}

	static $plugin_file = null;

	if ( ! is_null( $plugin_file ) ) {
		return $plugin_file;
	}

	return $plugin_file = apply_filters( 'nice_testimonials_plugin_file', nice_testimonials_plugin_property( 'plugin_file' ) );
}

/**
 * Obtain the name of the plugin domain.
 *
 * @uses   nice_testimonials_plugin_property()
 *
 * @since  1.0
 *
 * @param  bool   $use_constant Use `NICE_TESTIMONIALS_PLUGIN_DOMAIN_FILE` constant to get plugin domain.
 *
 * @return string
 */
function nice_testimonials_plugin_domain( $use_constant = false ) {
	if ( $use_constant ) {
		return defined( 'NICE_TESTIMONIALS_PLUGIN_DOMAIN_FILE' )
			 ? trailingslashit( plugin_basename( dirname( NICE_TESTIMONIALS_PLUGIN_DOMAIN_FILE ) ) )
			 : null;
	}

	static $plugin_domain = null;

	if ( ! is_null( $plugin_domain ) ) {
		return $plugin_domain;
	}

	return $plugin_domain = apply_filters( 'nice_testimonials_plugin_domain', nice_testimonials_plugin_property( 'plugin_domain' ) );
}

/**
 * Obtain the plugin's basename.
 *
 * @uses   nice_testimonials_plugin_property()
 *
 * @since  1.0
 *
 * @return string
 */
function nice_testimonials_plugin_basename() {
	static $basename = null;

	if ( ! is_null( $basename ) ) {
		return $basename;
	}

	return $basename = apply_filters( 'nice_testimonials_plugin_basename', nice_testimonials_plugin_property( 'plugin_basename' ) );
}

/**
 * Obtain the plugin's slug.
 *
 * @uses   nice_testimonials_plugin_property()
 *
 * @since  1.0
 *
 * @return string
 */
function nice_testimonials_plugin_slug() {
	static $slug = null;

	if ( ! is_null( $slug ) ) {
		return $slug;
	}

	return $slug = apply_filters( 'nice_testimonials_plugin_slug', nice_testimonials_plugin_property( 'plugin_slug' ) );
}

/**
 * Obtain the plugin's version.
 *
 * @uses   nice_testimonials_plugin_property()
 *
 * @since  1.0
 *
 * @return string
 */
function nice_testimonials_plugin_version() {
	static $version = null;

	if ( ! is_null( $version ) ) {
		return $version;
	}

	return $version = apply_filters( 'nice_testimonials_plugin_version', nice_testimonials_plugin_property( 'version' ) );
}

/**
 * Obtain the plugin's required version of WordPress.
 *
 * @uses   nice_testimonials_plugin_property()
 *
 * @since  1.0
 *
 * @return string
 */
function nice_testimonials_wp_required_version() {
	static $version = null;

	if ( ! is_null( $version ) ) {
		return $version;
	}

	return $version = apply_filters( 'nice_testimonials_wp_required_version', nice_testimonials_plugin_property( 'wp_required_version' ) );
}

/**
 * Obtain the plugin's required version of PHP.
 *
 * @uses   nice_testimonials_plugin_property()
 *
 * @since  1.0
 *
 * @return string
 */
function nice_testimonials_php_required_version() {
	static $version = null;

	if ( ! is_null( $version ) ) {
		return $version;
	}

	return $version = apply_filters( 'nice_testimonials_php_required_version', nice_testimonials_plugin_property( 'php_required_version' ) );
}

/**
 * Obtain text domain for the current plugin.
 *
 * @uses   nice_testimonials_plugin_property()
 *
 * @since  1.0
 *
 * @return string
 */
function nice_testimonials_textdomain() {
	static $textdomain = null;

	if ( ! is_null( $textdomain ) ) {
		return $textdomain;
	}

	/**
	 * Obtain i18n instance.
	 */
	$i18n = nice_testimonials_plugin_property( 'i18n' );

	return $textdomain = apply_filters( 'nice_testimonials_textdomain', $i18n->{'domain'} );
}

/**
 * Initialize i18n instance for this plugin.
 *
 * @uses   nice_testimonials_i18n_create()
 *
 * @since  1.0
 *
 * @param Nice_Testimonials_Plugin $plugin
 */
function nice_testimonials_plugin_i18n_init( Nice_Testimonials_Plugin $plugin ) {
	static $i18n = null;

	// Return early if the instance has already been set.
	if ( ! is_null( $i18n ) ) {
		return;
	}

	/**
	 * Obtain plugin data from plugin file headers.
	 */
	$headers = nice_testimonials_plugin_headers();

	/**
	 * Create i18n instance.
	 */
	$i18n = nice_testimonials_i18n_create( apply_filters( 'nice_testimonials_plugin_i18n_data', array(
				'domain' => $headers['TextDomain'],
				'path'   => nice_testimonials_plugin_domain( true ),
				'locale' => get_locale(),
			)
	) );

	nice_testimonials_update( $plugin, array( 'i18n' => $i18n ) );
}

if ( ! function_exists( 'nice_testimonials_theme_template' ) ) :
/**
 * Obtain the name of the active theme template.
 *
 * @since 1.0
 */
function nice_testimonials_theme_template() {
	return apply_filters( 'nice_testimonials_theme_template', nice_testimonials_plugin_property( 'theme_template' ) );
}
endif;

if ( ! function_exists( 'nice_testimonials_get_nicethemes' ) ) :
/**
 * Obtain the list of themes by NiceThemes.
 *
 * @since  1.0
 *
 * @return array
 */
function nice_testimonials_get_nicethemes() {
	return array(
		'bbq',
		'bossa',
		'bref',
		'flatbase',
		'folly',
		'netelier',
		'paeon',
	);
}
endif;

if ( ! function_exists( 'nice_testimonials_is_nicetheme' ) ) :
/**
 * Check if the given theme is from NiceThemes.
 *
 * @since  1.0
 *
 * @param  string $theme Name of the theme to check.
 *
 * @return bool
 */
function nice_testimonials_is_nicetheme( $theme ) {
	return in_array( $theme, nice_testimonials_get_nicethemes(), true );
}
endif;

if ( ! function_exists( 'nice_testimonials_using_nicetheme' ) ) :
/**
 * Obtain the name of the active theme template.
 *
 * @since 1.0
 */
function nice_testimonials_using_nicetheme() {
	return apply_filters( 'nice_testimonials_using_nicetheme', nice_testimonials_plugin_property( 'using_nicetheme' ) );
}
endif;
