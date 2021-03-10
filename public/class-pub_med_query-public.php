<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       colinmatsonjones.com
 * @since      1.0.0
 *
 * @package    Pub_med_query
 * @subpackage Pub_med_query/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Pub_med_query
 * @subpackage Pub_med_query/public
 * @author     Colin Matson-Jones <cmatsonjones@gmail.com>
 */
class Pub_med_query_Public {

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
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pub_med_query_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pub_med_query_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pub_med_query-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pub_med_query_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pub_med_query_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pub_med_query-public.js', array( 'jquery' ), $this->version, false );

	}

	public function localize_scripts() {

		$options = get_option( 'pmq_example_plugin_options' );


		wp_localize_script( $this->plugin_name, 'values', array(
			'api_key' => $options['api_key'],
			'researchers' => $options['researchers'],
		) );


	}


	public function render_publications_container()
	{
		return require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/filter.php';
	}


	public function register_shortcodes()
	{
		add_shortcode('pub_med_query', array($this, 'render_publications_container'));
	}

}
