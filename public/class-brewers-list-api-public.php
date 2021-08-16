<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://brewers.test
 * @since      1.0.0
 *
 * @package    Brewers_List_Api
 * @subpackage Brewers_List_Api/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Brewers_List_Api
 * @subpackage Brewers_List_Api/public
 * @author     Glenny Abellana <glenny.abellana@gmail.com>
 */
class Brewers_List_Api_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/brewers-list-api-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/brewers-list-api-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register a brewer post type, with REST API support
	 *
	 * Based on example at: https://codex.wordpress.org/Function_Reference/register_post_type
	 *
	 * @since    1.0.0
	 */
	public function brewer_cpt() {
		$labels = array(
			'name'               => _x( 'Brewers', 'post type general name', 'brewers-list-api' ),
			'singular_name'      => _x( 'Brewer', 'post type singular name', 'brewers-list-api' ),
			'menu_name'          => _x( 'Brewers', 'admin menu', 'brewers-list-api' ),
			'name_admin_bar'     => _x( 'Brewer', 'add new on admin bar', 'brewers-list-api' ),
			'add_new'            => _x( 'Add New', 'brewer', 'brewers-list-api' ),
			'add_new_item'       => __( 'Add New Brewer', 'brewers-list-api' ),
			'new_item'           => __( 'New Brewer', 'brewers-list-api' ),
			'edit_item'          => __( 'Edit Brewer', 'brewers-list-api' ),
			'view_item'          => __( 'View Brewer', 'brewers-list-api' ),
			'all_items'          => __( 'All Brewers', 'brewers-list-api' ),
			'search_items'       => __( 'Search Brewers', 'brewers-list-api' ),
			'parent_item_colon'  => __( 'Parent Brewers:', 'brewers-list-api' ),
			'not_found'          => __( 'No brewers found.', 'brewers-list-api' ),
			'not_found_in_trash' => __( 'No brewers found in Trash.', 'brewers-list-api' ),
		);

		$args = array(
			'labels'                => $labels,
			'description'           => __( 'Brewers custom post type.', 'brewers-list-api' ),
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'brewer' ),
			'capability_type'       => 'post',
			'has_archive'           => true,
			'menu_icon'             => 'dashicons-coffee',
			'hierarchical'          => false,
			'menu_position'         => null,
			'show_in_rest'          => true,
			'rest_base'             => 'brewers',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'supports'              => array( 'title', 'author' ),
		);

		register_post_type( 'brewer', $args );
	}

	/**
	 * Load a template for brewer custom post type
	 */
	public function brewer_cpt_template( $single_template ) {

		global $post;

		if ( 'brewer' === $post->post_type ) {
			$single_template = plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/brewers-list-api-public-display.php';
		}

		return $single_template;

	}

	/**
	 * Load a template for brewer custom post type
	 */
	public function brewer_home_template( $archive_brewer_template ) {

		if ( is_post_type_archive( 'brewer' ) ) {
			$archive_brewer_template = plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/archive-brewer.php';
		}

		return $archive_brewer_template;

	}

	/**
	 * The Code below will modify the main WordPress loop, before the queries fired,
	 * to only show posts in the halloween category on the home page.
	 */
	public function pre_get_brewer_custom_posts( $query ) {
		if ( ( is_home() && is_front_page() ) && $query->is_main_query() ) {
			$query->set( 'post_type', array( 'brewer' ) );
		}
		return $query;
	}

	/**
	 * Fetch remote data source API from Open Brewery DB and store data to custom post type 'brewer'
	 *
	 * @since    1.0.0
	 */
	public function brewery_sync_api() {

		$current_page   = ( ! empty( $_POST['current_page'] ) ) ? $_POST['current_page'] : 1; // phpcs:ignore error
		$api_url        = 'https://api.openbrewerydb.org/breweries?sort=id:asc&per_page=50&page=' . $current_page; // API from Open Brewery DB
		$response       = wp_remote_get( $api_url );
		$response_body  = wp_remote_retrieve_body( $response );
		$breweries_data = json_decode( $response_body ); // Convert JSON string to PHP variable

		// API not available
		if ( ! is_array( $breweries_data ) || empty( $breweries_data ) ) {
			echo esc_html( 'External API problem.' );
			return false;
		}

		foreach ( $breweries_data as $brewery ) {

			$existing_brewery = get_post( $brewery->id );

			// if brewery does not exist in DB, add brewery
			if ( null === $existing_brewery ) {

				// add brewery to WP
				$this->add_brewery( $brewery );

			} else {

				$existing_brewer_modified = $this->get_existing_brewery_data( $existing_brewery );
				$brewery_meta_api         = $this->get_brewery_post_data( $brewery )['meta_input'];

				// Only update meta fields if data is changed
				if ( $brewery_meta_api !== $existing_brewer_modified ) {

					foreach ( $brewery_meta_api as $key => $value ) {
						update_post_meta( $existing_brewery->ID, $key, sanitize_text_field( $value ) );
					}
				}
			}
		}

		// Increment page number
		$current_page++;

		// Recursive ajax request for brewery_sync_api
		wp_remote_post(
			admin_url( 'admin-ajax.php?action=brewery_sync_api' ), [
				'blocking'  => false,
				'sslverify' => false, // we are sending this to ourselves, so trust it.
				'body'      => [
					'current_page' => $current_page,
				],
			]
		);

	}

	/**
	 * Insert brewery to WordPress database
	 *
	 * @since    1.0.0
	 * @param    array    $brewery       Value from remote source.
	 */
	public function add_brewery( $brewery ) {

		$brewery_post_data              = $this->get_brewery_post_data( $brewery );
		$brewery_post_data['import_id'] = $brewery->id;

		// Insert the post into the database
		wp_insert_post( $brewery_post_data );
	}

	/**
	 * Get brewer data from remote source API and set meta as value
	 *
	 * @since    1.0.0
	 * @param    array    $brewery       Value from remote source.
	 */
	public function get_brewery_post_data( $brewery ) {
		$brewery_post_data = array(
			'post_title'  => sanitize_text_field( $brewery->name . ' - ' . $brewery->id ),
			'post_name'   => sanitize_text_field( $brewery->obdb_id ),
			'post_type'   => 'brewer', // custom post type
			'post_status' => 'publish',
			'post_author' => 1,
			'meta_input'  => array(
				'brewer_name'         => sanitize_text_field( $brewery->name ),
				'brewery_type'        => sanitize_text_field( $brewery->brewery_type ),
				'brewer_street'       => sanitize_text_field( $brewery->street ),
				'brewer_city'         => sanitize_text_field( $brewery->city ),
				'brewer_state'        => sanitize_text_field( $brewery->state ),
				'brewer_postal_code'  => sanitize_text_field( $brewery->postal_code ),
				'brewer_country'      => sanitize_text_field( $brewery->country ),
				'brewer_longitude'    => sanitize_text_field( $brewery->longitude ),
				'brewer_latitude'     => sanitize_text_field( $brewery->latitude ),
				'brewer_phone_number' => sanitize_text_field( $brewery->phone ),
				'brewer_website_url'  => sanitize_text_field( $brewery->website_url ),
				'brewer_updated_at'   => sanitize_text_field( $brewery->updated_at ),
			),
		);

		return $brewery_post_data;
	}

	/**
	 * Get existing brewer meta data from WordPress
	 *
	 * @since    1.0.0
	 * @param    array    $existing_brewery       Meta value from database.
	 */
	public function get_existing_brewery_data( $existing_brewery ) {
		$post_meta = get_post_meta( $existing_brewery->ID );

		$brewery_meta_data = array(
			'brewer_name'         => $post_meta['brewer_name'][0],
			'brewery_type'        => $post_meta['brewery_type'][0],
			'brewer_street'       => $post_meta['brewer_street'][0],
			'brewer_city'         => $post_meta['brewer_city'][0],
			'brewer_state'        => $post_meta['brewer_state'][0],
			'brewer_postal_code'  => $post_meta['brewer_postal_code'][0],
			'brewer_country'      => $post_meta['brewer_country'][0],
			'brewer_longitude'    => $post_meta['brewer_longitude'][0],
			'brewer_latitude'     => $post_meta['brewer_latitude'][0],
			'brewer_phone_number' => $post_meta['brewer_phone_number'][0],
			'brewer_website_url'  => $post_meta['brewer_website_url'][0],
			'brewer_updated_at'   => $post_meta['brewer_updated_at'][0],

		);

		return $brewery_meta_data;
	}

	/**
	 * Load dashicons on frontend
	 *
	 * @since    1.0.0
	 */
	public function brewer_load_dashicons() {
		wp_enqueue_style( 'dashicons' );
	}
	
}
