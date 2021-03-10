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

		return require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/templates/sample-settings.php';
	}


	public function register_settings() {

		//we could call the api validation in the callback here 
		register_setting( 'pmq_example_plugin_options', 'pmq_example_plugin_options', array() );

		add_settings_section( 'api_settings', 'API Settings', array($this, 'pmq_plugin_section_text' ), 'pub_med_query' );

		add_settings_field( 'pmq_plugin_setting_api_key', 'API Key', array($this, 'pmq_plugin_setting_api_key' ), 'pub_med_query', 'api_settings' );

		add_settings_field( 'pmq_plugin_setting_researchers', 'Researchers', array($this, 'pmq_plugin_setting_researchers' ), 'pub_med_query', 'api_settings' );

		
	}

	// public function pmq_example_plugin_options_validate( $input ) {
	// 	$newinput['api_key'] = trim( $input['api_key'] );
	// 	if ( ! preg_match( '/^[a-z0-9]{32}$/i', $newinput['api_key'] ) ) {
	// 		$newinput['api_key'] = '';
	// 	}

	// 	return $newinput;
	// }


	public function pmq_plugin_section_text() {
		echo '<p>Enter Your Pub Med API Here</p>';
	}

	public function pmq_plugin_setting_api_key() {
		$options = get_option( 'pmq_example_plugin_options' );
		echo "<input id='pmq_plugin_setting_api_key' name='pmq_example_plugin_options[api_key]' type='text' value='" . esc_attr( $options['api_key'] ) . "' />";


	}


	public function pmq_plugin_setting_researchers() {
		$options = get_option( 'pmq_example_plugin_options' );


		$select = '<select id="pmq_researcher_select" name="pmq_example_plugin_options[researchers][]" multiple>';
		$select .= '<option>Researchers</option>';

		$researchers = get_posts(array('post_type' => 'researcher', 'numberposts' => -1));


		//var_dump( $researchers );
		foreach( $researchers as $researcher ) {

			if( in_array( $researcher->post_name, $options['researchers'])) {
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