<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       colinmatsonjones.com
 * @since      1.0.0
 *
 * @package    Pub_med_query
 * @subpackage Pub_med_query/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Pub_med_query
 * @subpackage Pub_med_query/includes
 * @author     Colin Matson-Jones <cmatsonjones@gmail.com>
 */
class Pub_med_query_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'pub_med_query',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
