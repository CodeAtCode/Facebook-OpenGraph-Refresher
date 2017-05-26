<?php

/**
 * @package   Facebook_OpenGraph_Refresher
 * @author    Codeat <support@codeat.co>
 * @copyright 2017 Codeat
 * @license   GPL 2.0+
 * @link      http://codeat.co
 *
 * Plugin Name:       Facebook OpenGraph Refresher
 * Plugin URI:        https://wordpress.org/plugins/for-facebook-opengraph-refresher/
 * Description:       Refresh the OpenGraph of the post type on Facebook automatically
 * Version:           1.0.1
 * Author:            Codeat
 * Author URI:        http://codeat.co
 * Text Domain:       for-facebook-opengraph-refresher
 * License:           GPL 2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * WordPress-Plugin-Boilerplate-Powered: v2.0.5
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}
define( 'FOR_VERSION', '1.0.1' );
define( 'FOR_TEXTDOMAIN', 'for-facebook-opengraph-refresher' );
define( 'FOR_NAME', 'Facebook OpenGraph Refresher' );

function for_load_plugin_textdomain() {
	$locale = apply_filters( 'plugin_locale', get_locale(), FOR_TEXTDOMAIN );
	load_textdomain( FOR_TEXTDOMAIN, trailingslashit( WP_PLUGIN_DIR ) . FOR_TEXTDOMAIN . '/languages/' . FOR_TEXTDOMAIN . '-' . $locale . '.mo' );
}

add_action( 'plugins_loaded', 'for_load_plugin_textdomain', 1 );
require_once( plugin_dir_path( __FILE__ ) . 'composer/autoload.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/functions.php' );
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/FOR_WPCli.php' );
}

if ( is_admin() &&
		(function_exists( 'wp_doing_ajax' ) && !wp_doing_ajax() ||
		(!defined( 'DOING_AJAX' ) || !DOING_AJAX ) )
 ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/Facebook_OpenGraph_Refresher_Admin.php' );
}
