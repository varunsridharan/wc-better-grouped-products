<?php
/**
 * Dependency Checker
 *
 * Checks if required Dependency plugin is enabled
 *
 * @link https://wordpress.org/plugins/wc-better-grouped-products/
 * @package WC_Better_Grouped_Products
 * @subpackage WC_Better_Grouped_Products/core
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

if ( ! class_exists( 'WC_Better_Grouped_Products_Dependencies' ) ){
    class WC_Better_Grouped_Products_Dependencies {
		
        private static $active_plugins;
		
        public static function init() {
            self::$active_plugins = (array) get_option( 'active_plugins', array() );
            if ( is_multisite() )
                self::$active_plugins = array_merge( self::$active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
        }
		
        public static function active_check($pluginToCheck = '') {
            if ( ! self::$active_plugins ) 
				self::init();
            return in_array($pluginToCheck, self::$active_plugins) || array_key_exists($pluginToCheck, self::$active_plugins);
        }
    }
}
/**
 * WC Detection
 */
if(! function_exists('WC_Better_Grouped_Products_Dependencies')){
    function WC_Better_Grouped_Products_Dependencies($pluginToCheck = 'woocommerce/woocommerce.php') {
        return WC_Better_Grouped_Products_Dependencies::active_check($pluginToCheck);
    }
}
?>