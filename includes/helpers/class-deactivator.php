<?php
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @link https://wordpress.org/plugins/wc-better-grouped-products/
 * @package WC_Better_Grouped_Products
 * @subpackage WC_Better_Grouped_Products/core
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

class WC_Better_Grouped_Products_Deactivator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

	}

	public static function dependency_deactivate(){ 
		if ( is_plugin_active(WC_BGP_FILE) ) {
			add_action('update_option_active_plugins', array(__CLASS__,'deactivate_dependent'));
		}
	}
	
	public static function deactivate_dependent(){
		deactivate_plugins(WC_BGP_FILE);
	}

}