<?php
/**
 * Plugin Name:       Woo NovaPoshta. Электронная накладная
 * Plugin URI:        http://www.justcode.in.ua/woo-novaposhta-elektronnaya-nakladnaya
 * Description:       Новая почта электронные накладные. Вывод номера накладной в заказе (woocommerce) и отслеживание накладной
 * Version:           0.16
 * Author:            justcodeUA
 * Author URI:        http://www.justcode.in.ua
 * License:           MIT
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	define( 'WC_NP_DIR', plugin_dir_path( __FILE__ ) );
	define( 'WC_NP_URL', plugin_dir_url( __FILE__ ) );
	require_once( 'NpControllerClass.php' );
	include_once WC_NP_DIR . "wc_np_metbox.php";
	add_action( 'admin_enqueue_scripts', 'admin_widgets_assets' );




	register_activation_hook( __FILE__, 'activate_woo_np_declaration' );
	register_deactivation_hook( __FILE__, 'deactivate_woo_np_declaration' );
	global $Wc_np_metabox;
	$Wc_np_metabox = new \NP\Wc_np_metabox();

}

add_filter( 'plugin_row_meta', 'plugin_row_meta_donation', 10, 4 );
function plugin_row_meta_donation( $meta, $plugin_file ){
	if( false === strpos( $plugin_file, basename(__FILE__) ) )
		return $meta;

	$meta[] = '<a target="_blank" href="https://www.liqpay.com/ru/checkout/justcodedonate">Donate justcodeUA</a>';
	return $meta;
}

function admin_widgets_assets( $hook_suffix ) {
	wp_enqueue_style( 'NPWCSS', WC_NP_URL . 'assets/tracking.css', '1.0' );
	wp_enqueue_script( 'NPWJS', WC_NP_URL . 'assets/track.min.js', array( 'jquery' ), '1.0', true );
}

function activate_woo_np_declaration() {
	\NP\NpControllerClass::activate_plugin();
}

function deactivate_woo_np_declaration() {
	\NP\NpControllerClass::deactivate_plugin();
}

?>