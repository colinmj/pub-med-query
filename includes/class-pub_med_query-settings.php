<?php


/**
 * Fired during plugin deactivation
 *
 * @link       colinmatsonjones.com
 * @since      1.0.0
 *
 * @package    Pub_med_query
 * @subpackage Pub_med_query/includes
 */

/**
 * Fired during plugin init
 *
 * This class sets up the plugin settings page
 *
 * @since      1.0.0
 * @package    Pub_med_query
 * @subpackage Pub_med_query/includes
 * @author     Colin Matson-Jones <cmatsonjones@gmail.com>
 */
class Pub_med_query_Settings{

	//todo:  add a more dynamic add pages approach

	/**
	 * 
	 *
	 * 
	 *
	 * @since    1.0.0
	 */
	
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
		add_action('admin_init', array( $this, 'register_settings') );
		
	}

	public function add_admin_pages() {
		add_menu_page( 'Pubmed', 'Pubmed', 'manage_options', 'pub_med_query', array( $this, 'render_settings' ), 'dashicons-store', 110 );
	}

	
	public function render_settings() {

		return require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/templates/settings.php';
	}


	public function register_settings() {

		//we could call the api validation in the callback here 
		register_setting( 'pmq_options', 'pmq_options', array() );

		add_settings_section( 'pmq_settings', 'Filter Settings', array($this, 'pmq_plugin_section_text' ), 'pub_med_query' );

		add_settings_field( 'pmq_plugin_setting_load_results', 'Load Initial Results', array($this, 'pmq_plugin_setting_load_results' ), 'pub_med_query', 'pmq_settings' );

		//removing for now, it appears that the api key is not needed
		//add_settings_field( 'pmq_plugin_setting_api_key', 'API Key', array($this, 'pmq_plugin_setting_api_key' ), 'pub_med_query', 'pmq_settings' );

		add_settings_field( 'pmq_plugin_setting_researchers', 'Researchers', array($this, 'pmq_plugin_setting_researchers' ), 'pub_med_query', 'pmq_settings' );

		add_settings_field( 'pmq_plugin_setting_no_results', 'No Results Message', array($this, 'pmq_plugin_setting_no_results' ), 'pub_med_query', 'pmq_settings' );
		


		add_settings_field( 'pmq_plugin_setting_categories', 'Research Categories', array($this, 'pmq_plugin_setting_categories' ), 'pub_med_query', 'pmq_settings' );

	}


	public function pmq_plugin_setting_load_results() {
		$options = get_option( 'pmq_options' );
		echo '<input type="checkbox" id="pmq_plugin_settings_load_results" name="pmq_options[load_results]" value="1"' . checked( true, $options['load_results'], false ) . '/>';
	}


	public function pmq_plugin_section_text() {

		echo '<p> Here you can choose whether to load publications on the initial page load, or force the user to make a query. While you manage the researchers who are a part of your team using the post type in the dashboard, you will manage any categories you wish to include here. Separate the categories with a comma </p>';
	}

	public function pmq_plugin_setting_api_key() {
		$options = get_option( 'pmq_options' );
		echo "<input id='pmq_plugin_setting_api_key' name='pmq_options[api_key]' type='text' value='" . esc_attr( $options['api_key'] ) . "' />";
	}


	public function pmq_plugin_setting_no_results() {

		echo '<p> Enter a message to display if the user makes a query that returns no results </p>';

		$options = get_option( 'pmq_options' ); 

		echo "<input id='pmq_plugin_setting_no_results' name='pmq_options[no_results]' type='text' value='" . esc_attr( $options['no_results'] ) . "' />";
	}




	public function pmq_plugin_setting_categories() {

		echo '<p> Add any categories that you would like to include in the filter, separate categories with a comma </p>';

		$options = get_option( 'pmq_options' ); 

		echo "<input id='pmq_plugin_setting_categories' name='pmq_options[categories]' type='text' value='" . esc_attr( $options['categories'] ) . "' />";
	}


	public function pmq_plugin_setting_researchers() {

		echo '<p> Choose the researchers whose articles you would like to display on the initial page load. The user will be able to subsequently filter the articles from a list of all researchers included. This will only occur if you have selected "Load Initial Results" as an option above  </p>';

		$options = get_option( 'pmq_options' );


		$select = '<select id="pmq_researcher_select" name="pmq_options[researchers][]" multiple>';
		//$select .= '<option>Researchers</option>';
		$researchers = get_posts(array('post_type' => 'researcher', 'numberposts' => -1));



		foreach( $researchers as $researcher ) {

			if( is_array($options['researchers']) && in_array( $researcher->post_name, $options['researchers']) ) {
				$selected = 'selected';
			} else {
				$selected = '';
			}

			$select .= '<option value="' . $researcher->post_name . '"'. $selected . '>' . $researcher->post_title . '</option>';
		}

		$select .= '</select>';
		echo $select;


	}


}