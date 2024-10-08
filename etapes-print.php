<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              x
 * @since             4.0.0
 * @package           Etapes_Print Client
 *
 * @wordpress-plugin
 * Plugin Name:       Etapes print Client
 * Plugin URI:        x
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           4.0.0
 * Author:            Takamoa
 * Author URI:        x
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       etapes-print
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 4.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ETAPES_PRINT_VERSION', '4.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-etapes-print-activator.php
 */
function activate_etapes_print() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-etapes-print-activator.php';
	Etapes_Print_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-etapes-print-deactivator.php
 */
function deactivate_etapes_print() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-etapes-print-deactivator.php';
	Etapes_Print_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_etapes_print' );
register_deactivation_hook( __FILE__, 'deactivate_etapes_print' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-etapes-print.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    4.0.0
 */
function run_etapes_print() {

	$plugin = new Etapes_Print();
	$plugin->run();

}

$plugin_path = trailingslashit( WP_PLUGIN_DIR ) . 'woocommerce/woocommerce.php';
// if (function_exists('wp_get_active_and_valid_plugins') && function_exists('wp_get_active_network_plugins')) {
	if (in_array( $plugin_path, wp_get_active_and_valid_plugins() ) || in_array( $plugin_path, wp_get_active_network_plugins() )) {
    // Custom code here. WooCommerce is active, however it has not 
    // necessarily initialized (when that is important, consider
    // using the `woocommerce_init` action).
		add_action( 'woocommerce_init', 'run_etapes_print');
	}
// }



