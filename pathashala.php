<?php

/**
 * Plugin Name:       Pathshala
 * Description:       Above And Beyond The Learning Management System.
 * Version:           1.0.0
 * Author:            emazharulislam
 * Author URI:        https://profiles.wordpress.org/emazharulislam/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pathshala
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
define( 'PATHSHALA_VERSION', '1.0.0' );
define( 'PATHSHALA_FILE', __FILE__ );
define( 'PATHSHALA_ROOT_PATH', plugin_dir_path( __FILE__ ) );
define( 'PATHSHALA_ROOT_URL', plugins_url( '/', __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pathshala-activator.php
 */
function activate_pathshala() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pathshala-activator.php';
	pathshala_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pathshala-deactivator.php
 */
function deactivate_pathshala() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pathshala-deactivator.php';
	pathshala_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pathshala' );
register_deactivation_hook( __FILE__, 'deactivate_pathshala' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pathshala.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_pathshala() {

	$plugin = new pathshala();
	$plugin->run();

}


add_filter( "template_include", function( $template ) {
	$post_type = get_query_var( 'post_type' );

	if ( 'pathshala' != $post_type ) {
		return $template;
	}

	$theme_file_path = get_stylesheet_directory() . '/pathshala/single-pathshala.php';

	if ( file_exists( $theme_file_path ) ) {
		return $theme_file_path;
	}

	$plugin_file_path = PATHSHALA_ROOT_PATH . 'templates/single-pathshala.php';

	if ( file_exists( $plugin_file_path ) ) {
		return $plugin_file_path;
	}

	return $template;
});



run_pathshala();
