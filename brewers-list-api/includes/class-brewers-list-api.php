<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://brewers.test
 * @since      1.0.0
 *
 * @package    Brewers_List_Api
 * @subpackage Brewers_List_Api/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Brewers_List_Api
 * @subpackage Brewers_List_Api/includes
 * @author     Glenny Abellana <glenny.abellana@gmail.com>
 */
class Brewers_List_Api {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Brewers_List_Api_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'BREWERS_LIST_API_VERSION' ) ) {
			$this->version = BREWERS_LIST_API_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'brewers-list-api';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Brewers_List_Api_Loader. Orchestrates the hooks of the plugin.
	 * - Brewers_List_Api_i18n. Defines internationalization functionality.
	 * - Brewers_List_Api_Admin. Defines all hooks for the admin area.
	 * - Brewers_List_Api_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-brewers-list-api-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-brewers-list-api-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-brewers-list-api-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-brewers-list-api-public.php';

		$this->loader = new Brewers_List_Api_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Brewers_List_Api_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Brewers_List_Api_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Brewers_List_Api_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Register custom fields
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'brewer_register_meta_boxes' );

		// Save brewer post custom fields
		$this->loader->add_action( 'save_post', $plugin_admin, 'brewer_save_meta_boxes', 10, 2 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Brewers_List_Api_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Create Brewers Custom Post Type
		$this->loader->add_action( 'init', $plugin_public, 'brewer_cpt' );

		// Filter the single_template for brewer custom post type
		$this->loader->add_filter( 'single_template', $plugin_public, 'brewer_cpt_template' );

		// Filter the home_template for brewer custom post type
		$this->loader->add_filter( 'archive_template', $plugin_public, 'brewer_home_template' );

		// Alter main query on home page to show breweries list
		$this->loader->add_action( 'pre_get_posts', $plugin_public, 'pre_get_brewer_custom_posts' );

		// Fire wp cron brewery_sync_api to update data
		$this->loader->add_action( 'brewery_update_list', $plugin_public, 'brewery_sync_api' );

		// Hande Ajax requests
		$this->loader->add_action( 'wp_ajax_nopriv_brewery_sync_api', $plugin_public, 'brewery_sync_api' );
		$this->loader->add_action( 'wp_ajax_brewery_sync_api', $plugin_public, 'brewery_sync_api' );

		// Shortcode to display list of breweries
		add_shortcode( 'breweries', array( $this, 'brewers_shortcode' ) );

	}

	/**
	 * Add Shortcode to display Rest Countries [breweries]
	 *
	 * @param  array $atts Attributes.
	 *
	 * @return string      Rest Countries HTML
	 */
	public function brewers_shortcode( $atts, $content = '' ) {
		ob_start();

		?>

		<?php
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		$args  = array(
			'post_type' => 'brewer',
			'paged'     => $paged,
		);

		$the_query = new WP_Query( $args );
		?>

		<?php if ( $the_query->have_posts() ) : ?>
			<div class="brewer-post-wrap alignwide">
				<!-- the loop -->
				<?php
				while ( $the_query->have_posts() ) :
					$the_query->the_post();

					include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/loop-template.php';

					?>
				<?php endwhile; ?>
				<!-- end of the loop -->

				<!-- pagination here -->
				<div class="pagination-wrapper">
					<nav class="navigation pagination">
						<?php

						$big = 999999999; // need an unlikely integer
						echo paginate_links( // phpcs:ignore
							array(
								'base'    => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
								'format'  => '?paged=%#%',
								'current' => max( 1, get_query_var( 'paged' ) ),
								'total'   => $the_query->max_num_pages,
							)
						);
						?>
					</nav>
				</div><!-- .pagination-wrapper -->

			</div>

			<?php wp_reset_postdata(); ?>

		<?php endif; ?>

		<?php

		return ob_get_clean();
	}

	/**
	 * Delete all brewer posts from the database
	 *
	 * @since     1.0.0
	 */
	public function clear_breweries_from_db() {

		global $wpdb;

		$wpdb->query( "DELETE FROM wp_posts WHERE post_type='brewer'" );
		$wpdb->query( 'DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts);' );
		$wpdb->query( 'DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Brewers_List_Api_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
