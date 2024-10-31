<?php
namespace NP;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class NpControllerClass {
	public function __construct() {

		// indicates we are running the admin
		if ( is_admin() ) {

			// called just before the woocommerce template functions are included
			add_action( 'init', array( $this, 'include_template_functions' ), 20 );

			// called only after woocommerce has finished loading
			add_action( 'woocommerce_init', array( $this, 'woocommerce_loaded' ) );

			// called after all plugins have loaded
			add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
			add_action( 'admin_menu', array( $this, 'npen_admin_actions' ), 10 );

		}
		add_shortcode( 'getnp_number', array( $this, 'getnp_func' ) );
		// add the action 
		add_action( 'woocommerce_order_items_table',
			array( $this, 'action_woocommerce_order_items_table' ) );


	}
	function getnp_func( $atts) {

		if($atts['order_id']){
			$order_id = esc_html(esc_sql($atts['order_id']));
			$data = get_post_meta( $order_id, '_metatest_data', true );
			return $data;
		}else{
			return '';
		}
	}
	// define the woocommerce_order_items_table callback 
	function action_woocommerce_order_items_table( $order ) {
		// make action magic happen here... 
		$data = get_post_meta( $order->id, '_metatest_data', true );
		$npen_label_text = get_option( 'npen_label_text' );
		echo '<tr>
				<th scope="row"><span class="np_forudpdate">'.(($npen_label_text)? $npen_label_text :esc_html('Номер ЭН', 'novaposhta')).'</span></th>
					<td>' . $data . '</td>
				</tr>';
	}


	protected static $instance;

	public static function init() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}

	public static function activate_plugin() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
		check_admin_referer( "activate-plugin_{$plugin}" );

	}

	public static function deactivate_plugin() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
		check_admin_referer( "deactivate-plugin_{$plugin}" );


	}

	/**
	 *
	 */
	public static function on_uninstall() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		check_admin_referer( 'bulk-plugins' );

		if ( __FILE__ != WP_UNINSTALL_PLUGIN ) {
			return;
		}

	}

	/**
	 * Override any of the template functions from woocommerce/woocommerce-template.php
	 * with our own template functions file
	 */
	public function include_template_functions() {

	}

	/**
	 * Take care of anything that needs woocommerce to be loaded.
	 * For instance, if you need access to the $woocommerce global
	 */
	public function woocommerce_loaded() {

	}

	/**
	 * Take care of anything that needs all plugins to be loaded
	 */
	public function plugins_loaded() {
		/**
		 * create metabox for make NPEN
		 */
		add_action( 'add_meta_boxes', array( $this, 'wc_order_NP_meta_box_add' ) );
		load_plugin_textdomain('novaposhta', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
	}

	public function wc_order_NP_meta_box_add() {
		global $Wc_np_metabox;
		$Wc_np_metabox->NPEN_meta_box_add();
	}

	public function npen_admin_actions() {

		add_menu_page( "Новая почта Электронные накладные", "Новая почта", 'manage_options',
			"npen_admin_settings",
			array( $this, "npen_admin_settings" ) );

	}

	public function npen_admin_settings() {

		if ( isset( $_POST['NPEN_settings_nonce'] ) && isset( $_POST['npen_settings_save'] ) && wp_verify_nonce( $_POST['NPEN_settings_nonce'],
				'NPEN_settings_nonce' )
		) {

			if(isset($_POST['npen_label_text'])){
				update_option( 'npen_label_text', $_POST['npen_label_text'] );
			}

		}
		include_once( 'views/npen_metabox/npen_settigns_template.php' );
	}

}
new NpControllerClass();


