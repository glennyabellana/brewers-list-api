<?php

/**
 * Fired during plugin activation
 *
 * @link       https://brewers.test
 * @since      1.0.0
 *
 * @package    Brewers_List_Api
 * @subpackage Brewers_List_Api/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Brewers_List_Api
 * @subpackage Brewers_List_Api/includes
 * @author     Glenny Abellana <glenny.abellana@gmail.com>
 */
class Brewers_List_Api_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$plugin_name   = new Brewers_List_Api_i18n(); // Get plugin textdomain
		$plugin_public = new Brewers_List_Api_Public( $plugin_name->load_plugin_textdomain(), BREWERS_LIST_API_VERSION );

		// Trigger function that registers the custom post type plugin.
		$plugin_public->brewer_cpt();

		if ( ! wp_next_scheduled( 'brewery_update_list' ) ) {
			wp_schedule_event( time(), 'weekly', 'brewery_update_list' );
		}

		// Clear the permalinks after the post type has been registered.
		flush_rewrite_rules();

	}

}
