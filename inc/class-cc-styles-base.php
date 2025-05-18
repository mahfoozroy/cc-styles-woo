<?php
/**
 * Plugin Loader for Woo CC Styles
 */

defined('ABSPATH') || exit;

/**
 * Main Plugin Loader Class
 */
class Woo_CC_Styles_Base
{

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
     * Constructor
     */
    public function __construct()
    {

        register_deactivation_hook(CC_STYLES_PATH . 'cc-styles.php', [ $this, 'on_deactivate' ]);

        add_action('plugins_loaded', [ $this, 'init' ]);
        add_action('init', [ $this, 'load_textdomain' ], 99);
    }

    /**
     * Plugin deactivation callback
     */
    public function on_deactivate()
    {
        CC_Styles_Options::clear_woo_transients();
    }

    /**
     * Initialize the plugin
     */
    public function init()
    {
        $this->load_dependencies();
    }

    /**
     * Load plugin text domain
     */
    public function load_textdomain()
    {
        load_plugin_textdomain(
            self::TEXT_DOMAIN,
            false,
            CC_STYLES_PATH . 'languages'
        );
    }

    /**
     * Include required class files
     */
    public function load_dependencies()
    {
        include_once CC_STYLES_PATH . 'inc/options/awesome-options-framework.php';
        include_once CC_STYLES_PATH . 'inc/class-cc-styles-options.php';
        include_once CC_STYLES_PATH . 'inc/class-cc-styles-appearance-engine.php';
        include_once CC_STYLES_PATH . 'inc/class-cc-styles-frontend.php';
    }
}
