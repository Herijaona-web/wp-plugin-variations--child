<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       x
 * @since      4.0.0
 *
 * @package    Etapes_Print child
 * @subpackage Etapes_Print/includes
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
 * @since      4.0.0
 * @package    Etapes_Print child
 * @subpackage Etapes_Print/includes
 * @author     Njakasoa Rasolohery <ras.njaka@gmail.com>
 */
class Etapes_Print {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    4.0.0
	 * @access   protected
	 * @var      Etapes_Print_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    4.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    4.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;


	/**
	 * DATASET
	 *
	 * @since    4.0.0
	 * @access   protected
	 * @var      Etapes_Print_Dataset    $dataset
	 */
	protected $dataset;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    4.0.0
	 */
	public function __construct() {
		if ( defined( 'ETAPES_PRINT_VERSION' ) ) {
			$this->version = ETAPES_PRINT_VERSION;
		} else {
			$this->version = '4.0.0';
		}
		$this->plugin_name = 'etapes-print';

		$this->load_dependencies();
		$this->set_locale();
		$this->set_routes();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Etapes_Print_Loader. Orchestrates the hooks of the plugin.
	 * - Etapes_Print_i18n. Defines internationalization functionality.
	 * - Etapes_Print_Router. Defines studio routes.
	 * - Etapes_Print_Admin. Defines all hooks for the admin area.
	 * - Etapes_Print_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    4.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-etapes-print-dataset.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-etapes-print-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-etapes-print-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the router area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-etapes-print-router.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-etapes-print-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-etapes-print-public.php';

		$this->loader = new Etapes_Print_Loader();
		$this->dataset = new Etapes_Print_Dataset();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Etapes_Print_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    4.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Etapes_Print_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the studio area functionality
	 * of the plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function set_routes() {
		$plugin_routes = new Etapes_Print_Router();
		$this->loader->add_filter( 'template_include', $plugin_routes, 'include_template' );
		$this->loader->add_filter( 'init', $plugin_routes, 'flush_rules' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    4.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Etapes_Print_Admin( $this->get_plugin_name(), $this->get_version(), $this->get_dataset() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu' );

		$this->loader->add_action( 'woocommerce_process_product_meta', $plugin_admin, 'save_fields', 10, 2 );

		// Add Etapes Print Settings
		$this->loader->add_filter( 'woocommerce_product_data_tabs', $plugin_admin, 'product_settings_tabs' );
		$this->loader->add_action( 'woocommerce_product_data_panels', $plugin_admin, 'product_panels' );


		// REST API
		$this->loader->add_action( 'rest_api_init', $plugin_admin, 'init_admin_route' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'getproductApi');

		$this->loader->add_action('woocommerce_product_options_general_product_data', $plugin_admin, 'product_general_panel');

		$this->loader->add_action('wp_ajax_my_action'  ,$plugin_admin,  'my_action');
		$this->loader->add_action('wp_ajax_nopriv_my_action' ,$plugin_admin,'my_action');



	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    4.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Etapes_Print_Public( $this->get_plugin_name(), $this->get_version(), $this->get_dataset() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'woocommerce_before_add_to_cart_button', $plugin_public, 'product_variations', 15 );
		// $this->loader->add_action( 'woocommerce_single_product_summary', $plugin_public, 'product_variations', 15 );
		// $this->loader->add_action( 'woocommerce_after_single_product_summary', $plugin_public, 'product_variations', 15 );
		// $this->loader->add_action( 'woocommerce_before_variations_form', $plugin_public, 'product_variations', 20 );
		$this->loader->add_action( 'woocommerce_get_price_html', $plugin_public, 'get_price_html', 20, 1 );


		/**
		 * Edit cart product before
		 */
		$this->loader->add_filter( 'woocommerce_add_cart_item_data', $plugin_public, 'add_cart_item_data', 15, 3 );
		$this->loader->add_filter('woocommerce_get_item_data', $plugin_public,'get_item_data', 10, 2);
		$this->loader->add_action( 'woocommerce_checkout_create_order_line_item', $plugin_public, 'checkout_create_order_line_item', 10, 4 );
		$this->loader->add_action( 'woocommerce_cart_item_removed', $plugin_public, 'remove_cart_action', 10, 2 );
		$this->loader->add_filter( 'woocommerce_is_sold_individually', $plugin_public, 'is_sold_individually', 10, 2 );
		$this->loader->add_action( 'woocommerce_before_calculate_totals', $plugin_public, 'before_calculate_totals', 20, 1 );

		$this->loader->add_filter( 'woocommerce_cart_item_quantity', $plugin_public, 'cart_item_quantity', 10, 3);


		/**
		 * For Dev only
		 */
		// $this->loader->add_filter( 'woocommerce_cart_needs_payment', $plugin_public, 'cart_needs_payment', 10, 2 ); 

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    4.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     4.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     4.0.0
	 * @return    Etapes_Print_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/***	
	 * Retrieve the version number of the plugin.
	 *
	 * @since     4.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function get_dataset() {
		return $this->dataset;
	}

}
