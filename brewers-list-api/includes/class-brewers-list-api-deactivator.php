<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://brewers.test
 * @since      1.0.0
 *
 * @package    Brewers_List_Api
 * @subpackage Brewers_List_Api/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Brewers_List_Api
 * @subpackage Brewers_List_Api/includes
 * @author     Glenny Abellana <glenny.abellana@gmail.com>
 */
class Brewers_List_Api_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// Unregister the post type, so the rules are no longer in memory.
		unregister_post_type( 'brewer' );
		// Clear the permalinks to remove our post type's rules from the database.
		flush_rewrite_rules();
		// Clean the scheduler on deactivation
		wp_clear_scheduled_hook( 'brewery_update_list' );

		// Remove all breweries from the database on plugin deactivation
		// $plugin_public = new Brewers_List_Api();
		// $plugin_public->clear_breweries_from_db();

	}

}
