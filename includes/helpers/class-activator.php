<?php 
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link https://wordpress.org/plugins/wc-better-grouped-products/
 * @package WC_Better_Grouped_Products
 * @subpackage WC_Better_Grouped_Products/core
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

class WC_Better_Grouped_Products_Activator {
	
    public function __construct() {
    }
	
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		require_once(WC_BGP_INC.'helpers/class-version-check.php');
		require_once(WC_BGP_INC.'helpers/class-dependencies.php');
		
		if(WC_Better_Grouped_Products_Dependencies(WC_BGP_DEPEN)){
			WC_Better_Grouped_Products_Version_Check::activation_check('3.7');	
		} else {
			if ( is_plugin_active(WC_BGP_FILE) ) { deactivate_plugins(WC_BGP_FILE);} 
			wp_die(wc_bgp_dependency_message());
		}
	} 
 
}