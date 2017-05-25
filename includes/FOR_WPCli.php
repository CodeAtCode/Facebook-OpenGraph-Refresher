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
	 * <ID>
	 * : The Post ID to refresh on Facebook cache
	 * 
	 * @param array $args
	 */
	public function wpcli( $args ) {
		if ( !isset( $args[ 0 ] ) ) {
			WP_CLI::error( 'Missing Post ID ');
		}
		$status = for_refresh_open_graph_by_post_type_id( $args[ 0 ] );
		if ( !is_wp_error( $status ) ) {
			WP_CLI::success( 'Facebook OpenGraph Refreshed for Post ID ' . $args[ 0 ] );
		} else {
			WP_CLI::error( 'Facebook OpenGraph not Refreshed for Post ID ' . $args[ 0 ] );
		}
	}

}

new For_WPCli();
