<?php

/**
 * Refresh the OpenGraph by edit on a post type
 *
 * @since 1.0.0
 */
function for_refresh_open_graph_by_post_type_id( $post_id ) {
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	$do_refresh = apply_filters( 'for_execute_refresh', true, $post_id );
	if ( $do_refresh ) {
		if ( get_post_status( $post_id ) === 'publish' ) {
			do_action( 'for_before_request', $post_id );
			$response = wp_remote_post( 'https://graph.facebook.com/', array(
				'method' => 'POST',
				'timeout' => 20,
				'body' => array( 'id' => get_permalink( $post_id ), 'scrape' => 'true' )
					)
			);
			do_action( 'for_after_request', $post_id );
			return $response;
		}
	}
	return false;
}
