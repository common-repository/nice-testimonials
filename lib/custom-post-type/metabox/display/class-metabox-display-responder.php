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
 * Class Nice_Testimonials_MetaboxDisplayResponder
 *
 * This class takes charge of the Nice_Testimonials_Metabox instances
 * to be displayed through WordPress APIs.
 *
 * @since 1.1
 */
class Nice_Testimonials_MetaboxDisplayResponder extends Nice_Testimonials_DisplayResponder {
	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.1
	 */
	protected function set_interactions() {
		/**
		 * Print metabox when the `nice_testimonials_metabox` action is called.
		 */
		add_action( 'nice_testimonials_metabox', array( $this, 'print_metabox' ) );

		/**
		 * Add scripts for current metabox.
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/**
		 * Fire default functionality.
		 */
		parent::set_interactions();
	}

	/**
	 * Print metabox when the `nice_testimonials_metabox` action is called.
	 *
	 * @since 1.1
	 *
	 * @param Nice_Testimonials_Metabox $metabox
	 */
	public static function print_metabox( Nice_Testimonials_Metabox $metabox ) {
		$data = $metabox->get_info();

		static $done = array();

		if ( isset( $done[ $data->id ] ) ) {
			return;
		}

		$done[ $data->id ] = true;

		/**
		 * Generate HTML using metabox instance.
		 */
		$html_handler = new Nice_Testimonials_Metabox_HTMLHandler( $metabox );

		/**
		 * Print HTML.
		 */
		$html_handler->print_html();
	}

	/**
	 * Add scripts for current metabox.
	 *
	 * @since 1.1
	 *
	 * @param string $hook Current admin hook.
	 */
	public function enqueue_scripts( $hook ) {
		/**
		 * Make sure scripts are only enqueued once, no matter how many
		 * metaboxes have been registered.
		 */
		static $done = null;

		if ( ! is_null( $done ) ) {
			return;
		}

		if ( in_array( $hook, array( 'post.php', 'post-new.php', 'page-new.php', 'page.php' ), true ) ) {
			/**
			 * Schedule CSS injection.
			 */
			add_action( 'admin_head', array( __CLASS__, 'print_styles' ) );

			/**
			 * Enqueue required scripts.
			 */
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'jquery-input-mask' );

			// Set flag to true.
			$done = true;
		}
	}

	/**
	 * Add custom styles to metaboxes.
	 *
	 * @since 1.1
	 */
	public static function print_styles() {
		?>
		<style type="text/css">
			/* Some Nice CSS for MetaBoxes*/
			#nice-metabox input[type=text] { margin: 0 0 10px 0; width:80%; padding: 5px; color: #222; }
			#nice-metabox td .nice-select { margin: 0 0 10px 0; color:#222; width: 60%; padding: 5px; }
			#nice-metabox th label { color:#555; font-weight:bold; }
			#nice-metabox span.description { display:block; cursor:help; color:#999;-webkit-transition: color 0.2s ease-in; /*safari and chrome */
				-o-transition: color 0.2s ease-in; /* opera */ -moz-transition: color 0.2s ease-in;  /* FF4+ */ -ms-transition: color 0.2s ease-in;  /* IE10? */ transition: color 0.2s ease-in;  }
			#nice-metabox span.description:hover { color: #555; }
			#nice-metabox th,
			#nice-metabox td,
			#nice-metabox .nice-row{ border-bottom:1px solid #e3e3e3; padding:15px 5px;text-align: left; vertical-align:top; }
			#nice-metabox tr:last-child td,
			#nice-metabox tr:last-child th{ border-bottom:none; }
			#nice-metabox td .nice_testimonials_textarea { width:80%; height:100px;margin:0 0 10px 0; color:#222;padding: 5px; }
			#nice-metabox td .nice-input-checkbox{ display: inline-block; float: left; margin-right: 8px; }
			#nice-metabox tr.nice-custom-info{ font-size: 11px; line-height: 1.5em; }
			.branch-3-7, .branch-3-6 #nice-metabox tr.nice-custom-info{ background: #f8f8f8; }
			#nice-metabox .border-bottom-none { border-bottom: none; }
		</style>
		<?php
	}
}
