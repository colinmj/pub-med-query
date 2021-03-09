<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              colinmatsonjones.com
 * @since             1.0.0
 * @package           Pub_med_query
 *
 * @wordpress-plugin
 * Plugin Name:       Pub Med Query
 * Plugin URI:        forgeandsmith.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Colin Matson-Jones
 * Author URI:        colinmatsonjones.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pub_med_query
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PUB_MED_QUERY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pub_med_query-activator.php
 */
function activate_pub_med_query() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pub_med_query-activator.php';
	Pub_med_query_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pub_med_query-deactivator.php
 */
function deactivate_pub_med_query() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pub_med_query-deactivator.php';
	Pub_med_query_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pub_med_query' );
register_deactivation_hook( __FILE__, 'deactivate_pub_med_query' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pub_med_query.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pub_med_query() {

	$plugin = new Pub_med_query();
	$plugin->run();

}
run_pub_med_query();
