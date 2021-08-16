<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://brewers.test
 * @since      1.0.0
 *
 * @package    Brewers_List_Api
 * @subpackage Brewers_List_Api/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Brewers_List_Api
 * @subpackage Brewers_List_Api/admin
 * @author     Glenny Abellana <glenny.abellana@gmail.com>
 */
class Brewers_List_Api_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/brewers-list-api-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/brewers-list-api-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register meta boxes.
	 *
	 * @since    1.0.0
	 */
	public function brewer_register_meta_boxes() {

		add_meta_box(
			'brewer-info',                                      // Unique ID
			esc_html__( 'Brewer Details', 'brewers-list-api' ), // Title
			array( $this, 'brewer_display_meta_box' ),          // Callback function
			'brewer',                                           // brewer custom post type
			'normal',                                           // Context
			'high'                                              // Priority
		);

	}

	/**
	 * Meta box display callback.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function brewer_display_meta_box( $post ) {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/brewers-list-api-admin-display.php';

	}

	/**
	 * Handles saving the meta box.
	 *
	 * @param int     $post_id Post ID.
	 */
	public function brewer_save_meta_boxes( $post_id ) {
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['brewer_post_nonce'] ) ) {
			return $post_id;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['brewer_post_nonce'], 'brewer_post_nonce_action' ) ) {
			return $post_id;
		}

		/*
		 * If this is an autosave, our form has not been submitted,
		 * so we don't want to do anything.
		 */
		if ( wp_is_post_autosave( $post_id ) ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'brewer' === $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return $post_id;
		}

		/* OK, it's safe for us to save the data now. */

		$fields = [
			'brewer_name',
			'brewery_type',
			'brewer_street',
			'brewer_city',
			'brewer_state',
			'brewer_postal_code',
			'brewer_country',
			'brewer_longitude',
			'brewer_latitude',
			'brewer_phone_number',
			'brewer_website_url',
			'brewer_updated_at',
		];
		foreach ( $fields as $field ) {
			if ( array_key_exists( $field, $_POST ) ) {
				// Update the meta field.
				update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
			}
		}
	}

}
