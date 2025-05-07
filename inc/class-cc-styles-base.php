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
	const TEXT_DOMAIN = 'cc-styles-woo';

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
		CC_Styles_Options::clear_woo_transients();
	}

	/**
	 * Initialize the plugin
	 */
	public function init() {
		$this->load_textdomain();
		$this->load_dependencies();
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
		require_once CC_STYLES_PATH . 'inc/options/awesome-options-framework.php';
		require_once CC_STYLES_PATH . 'inc/class-cc-styles-options.php';
		require_once CC_STYLES_PATH . 'inc/class-cc-styles-appearance-engine.php';
		require_once CC_STYLES_PATH . 'inc/class-cc-styles-frontend.php';
	}
}
