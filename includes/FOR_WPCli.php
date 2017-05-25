<?php

/**
 * This class contain the WP CLI support
 *
 * @package   Facebook_OpenGraph_Refresher
 * @author    Codeat <support@codeat.co>
 * @license   GPL 2.0+
 * @link      http://codeat.co
 * @copyright 2017 Codeat
 */
class For_WPCli {

	/**
	 * Initialize the snippet
	 */
	function __construct() {
		WP_CLI::add_command( 'for_refresh', array( $this, 'wpcli' ) );
	}

	/**
	 * Run the refresh
	 * 
	 * ## OPTIONS
	 * 
	 * ID
     * : The Post ID to refresh on Facebook cache
	 * 
	 * @param array $args
	 */
	public function wpcli( $args ) {
		$plugin = Facebook_OpenGraph_Refresher_Admin::get_instance();
		$status = $plugin->refresh_open_graph_post_type( $args[ 0 ] );
		if ( !is_wp_error( $status ) ) {
			WP_CLI::success( 'Facebook OpenGraph Refreshed for Post id ' . $args[0] );
		} else {
			WP_CLI::error( 'Facebook OpenGraph not Refreshed for Post id ' . $args[0] );
		}
	}

}

new For_WPCli();
