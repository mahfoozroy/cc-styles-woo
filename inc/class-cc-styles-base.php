<?php
/**
 * Plugin Loader for Woo CC Styles
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main Plugin Loader Class
 */
class Woo_CC_Styles_Loader {

	/**
	 * Plugin version
	 */
	const VERSION = '1.0.0';

	/**
	 * Plugin slug
	 */
	const SLUG = 'cc-styles-woo';

	/**
	 * Plugin text domain
	 */
	const TEXT_DOMAIN = 'cc-styles';

	/**
	 * Plugin basename
	 */
	protected $basename;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->basename = plugin_basename( __FILE__ );

		register_deactivation_hook( dirname( __DIR__ ) . '/cc-styles.php', [ $this, 'on_deactivate' ] );

		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Plugin deactivation callback
	 */
	public function on_deactivate() {
		// Cleanup tasks if needed (do not delete options unless uninstalling).
	}

	/**
	 * Initialize the plugin
	 */
	public function init() {
		$this->load_textdomain();
		$this->load_dependencies();
		$this->init_plugin();
	}

	/**
	 * Load plugin text domain
	 */
	protected function load_textdomain() {
		load_plugin_textdomain(
			self::TEXT_DOMAIN,
			false,
			dirname( plugin_basename( dirname( __DIR__ ) . '/cc-styles-woo.php' ) ) . '/languages'
		);
	}

	/**
	 * Include required class files
	 */
	protected function load_dependencies() {
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-stripe-style-injector.php';
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-appearance-style-manager.php';
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-options.php';
	}

	/**
	 * Bootstrap all plugin components
	 */
	protected function init_plugin() {
		$fields  = CC_Style_Options::get_fields();
		$options = CC_Style_Options::get_all_options();

		$style_manager = new StripeAppearanceStyleManager( $options, $fields );
		new Stripe_Style_Injector( $style_manager );
	}
}
