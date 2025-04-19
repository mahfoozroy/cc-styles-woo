<?php
/**
 * Plugin Name: Woo CC Styles
 * Plugin URI: https://www.wpbeans.com/
 * Description: The plugin helps you style the credit card fields.
 * Version: 1.0
 * Author: WP Beans
 * Author URI: https://www.wpbeans.com/
 * Text Domain: woo-cc
 *
 */

defined( 'ABSPATH' ) || exit;

// Define your API key here or in wp-config.php
if ( ! defined( 'WOO_CC_STYLES_PATH' ) ) {
    define( 'WOO_CC_STYLES_PATH', plugin_dir_path(__FILE__) ); // Replace or move to wp-config.php
}

// Include core files
require_once WOO_CC_STYLES_PATH . 'inc/class-woo-cc-options.php';
require_once WOO_CC_STYLES_PATH . 'inc/class-woo-cc-appearance-engine.php';
