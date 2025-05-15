<?php
/**
 * Plugin Name:       Credit Card Styles For Woo
 * Description:       The plugin helps you style the stripe credit card fields for woo.
 * Plugin URI:        https://www.roymahfooz.com/
 * Version:           1.0.0
 * Author:            Roy Mahfooz
 * Author URI:        https://www.roymahfooz.com/
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:       /languages
 * Text Domain:       cc-styles-woo
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'CC_STYLES_PATH' ) ) {
    define( 'CC_STYLES_PATH', plugin_dir_path(__FILE__) );
}
if ( ! defined( 'CC_STYLES_URL' ) ) {
    define( 'CC_STYLES_URL', plugin_dir_url(__FILE__) );
}

// Include core files
require_once CC_STYLES_PATH . 'inc/class-cc-styles-base.php';
new Woo_CC_Styles_Base();
