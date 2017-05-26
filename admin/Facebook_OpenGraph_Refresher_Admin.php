<?php

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * @package   Facebook_OpenGraph_Refresher
 * @author    Codeat <support@codeat.co>
 * @copyright 2017 Codeat
 * @license   GPL 2.0+
 * @link      http://codeat.co
 */
class Facebook_OpenGraph_Refresher_Admin {

	/**
	 * Instance of this class.
	 *
	 * @var      object
	 *
	 * @since 1.0.0
	 */
	protected static $instance = null;
	private $status = '';

	/**
	 * Initialize the plugin 
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		add_action( 'save_post', array( $this, 'refresh_open_graph_post_type' ) );
		add_action( 'admin_init', array( $this, 'show_alert' ) );
		add_action( 'admin_print_footer_scripts', array( $this, 'force_refresh' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		  if( ! is_super_admin() ) {
		  return;
		  }
		 */
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Refresh the OpenGraph by edit on a post type
	 *
	 * @since 1.0.0
	 */
	public function refresh_open_graph_post_type( $post_id ) {
		$response = for_refresh_open_graph_by_post_type_id( $post_id );
		$this->status = false;
		if ( !is_wp_error( $response ) ) {
			$this->status = true;
		}
		add_filter( 'redirect_post_location', array( $this, 'query_var' ), 99 );
		return true;
	}

	/**
	 * Add a parameter in the url to show the alert
	 * 
	 * @param string $location
	 * @return string
	 */
	public function query_var( $location ) {
		remove_filter( 'redirect_post_location', array( $this, 'query_var' ), 99 );
		return add_query_arg( array( 'for_refresh' => $this->status ), $location );
	}

	/**
	 * Show an alert about the status of the refresh
	 */
	public function show_alert() {
		$refresh = 'no';
		if ( isset( $_GET[ 'for_refresh' ] ) ) {
			$refresh = esc_html( $_GET[ 'for_refresh' ] );
		} elseif ( isset( $_GET[ 'for_refresh_it' ] ) ) {
			$this->refresh_open_graph_post_type( esc_html( $_GET[ 'post' ] ) );
			$refresh = $this->status;
		}
		if ( $refresh === '1' || $refresh === true ) {
			new WP_Admin_Notice( __( 'Facebook OpenGraph refreshed!', FOR_TEXTDOMAIN ), 'updated' );
		}
	}

	public function force_refresh() {
		$screen = get_current_screen();
		if ( $screen->parent_base === 'edit' ) {
			?>
			<script>
				jQuery('.wrap .page-title-action').after('<a href="<?php echo add_query_arg( 'for_refresh_it', true ); ?>" class="add-new-h2"><?php _e( 'Refresh Facebook OpenGraph', FOR_TEXTDOMAIN ) ?></a>');
			</script>
			<?php
		}
	}

}

add_action( 'plugins_loaded', array( 'Facebook_OpenGraph_Refresher_Admin', 'get_instance' ) );
