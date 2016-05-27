<?php 
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org/plugins/wc-better-grouped-products/
 * @since             1.0
 * @package           WooCommerce Better Grouped Products
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Better Grouped Products
 * Plugin URI:        https://wordpress.org/plugins/wc-better-grouped-products/
 * Description:       Sample Plugin For WooCommerce
 * Version:           1.0
 * Author:            Varun Sridharan
 * Author URI:        http://varunsridharan.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-better-grouped-products
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) { die; }
 
define('WC_BGP_FILE',plugin_basename( __FILE__ ));
define('WC_BGP_PATH',plugin_dir_path( __FILE__ )); # Plugin DIR
define('WC_BGP_INC',WC_BGP_PATH.'includes/'); # Plugin INC Folder
define('WC_BGP_DEPEN','woocommerce/woocommerce.php');

register_activation_hook( __FILE__, 'wc_bgp_activate_plugin' );
register_deactivation_hook( __FILE__, 'wc_bgp_deactivate_plugin' );
register_deactivation_hook( WC_BGP_DEPEN, 'wc_bgp_dependency_deactivate' );



/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function wc_bgp_activate_plugin() {
	require_once(WC_BGP_INC.'helpers/class-activator.php');
	WC_Better_Grouped_Products_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function wc_bgp_deactivate_plugin() {
	require_once(WC_BGP_INC.'helpers/class-deactivator.php');
	WC_Better_Grouped_Products_Deactivator::deactivate();
}


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function wc_bgp_dependency_deactivate() {
	require_once(WC_BGP_INC.'helpers/class-deactivator.php');
	WC_Better_Grouped_Products_Deactivator::dependency_deactivate();
}


require_once(WC_BGP_INC.'functions.php');
require_once(plugin_dir_path(__FILE__).'bootstrap.php');
	
if(!function_exists('WC_Better_Grouped_Products')){
    function WC_Better_Grouped_Products(){
        return WC_Better_Grouped_Products::get_instance();
    }
}
WC_Better_Grouped_Products();