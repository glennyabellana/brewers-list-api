<?php
/**
 * Plugin Name:       Brewers List API
 * Plugin URI:        https://glenny.jspreview.com
 * Description:       Create custom post type "brewers" and display brewers list from https://www.openbrewerydb.org API
 * Version:           1.0.0
 * Author:            Glenny Abellana
 * Author URI:        https://glenny.jspreview.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       brewers-list-api
 * Domain Path:       /languages
 *
 * @link              https://brewers.test
 * @since             1.0.0
 * @package           Brewers_List_Api
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'BREWERS_LIST_API_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_brewers_list_api() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-brewers-list-api-activator.php';
	Brewers_List_Api_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_brewers_list_api() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-brewers-list-api-deactivator.php';
	Brewers_List_Api_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_brewers_list_api' );
register_deactivation_hook( __FILE__, 'deactivate_brewers_list_api' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-brewers-list-api.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_brewers_list_api() {

	$plugin = new Brewers_List_Api();
	$plugin->run();

}
run_brewers_list_api();
