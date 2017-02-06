<?php
/**
 * Plugin's Admin code
 *
 * @link [plugin_url]
 * @package [package]
 * @subpackage [package]/Admin
 * @since [version]
 */
if ( ! defined( 'WPINC' ) ) { die; }

class WC_Better_Grouped_Products_Admin {

    /**
	 * Initialize the class and set its properties.
	 * @since      0.1
	 */
	public function __construct() { 
        add_filter( 'plugin_row_meta', array($this, 'plugin_row_links' ), 10, 2 );
        add_filter( 'plugin_action_links_'.WC_BGP_FILE, array($this,'plugin_action_links'),10,10);
        add_filter( 'woocommerce_get_settings_pages',  array($this,'settings_page') ); 
	} 
	/**
	 * Add a new integration to WooCommerce.
	 */
	public function settings_page( $integrations ) { 
        foreach(glob(WC_BGP_ADMIN.'wc-settings/woocommerce-settings*.php' ) as $file){
            $integrations[] = require_once($file);
        }
		return $integrations;
	}
     
 
    /**
	 * Adds Some Plugin Options
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 * @since 0.11
	 * @return array
	 */
    public function plugin_action_links($action,$file,$plugin_meta,$status){
        $menu_link = admin_url('admin.php?page=wc-settings&tab=products&section=wc_bgp_settings');
        $actions[] = sprintf('<a href="%s">%s</a>', $menu_link, __('Settings',WC_BGP_TXT) );
        $actions[] = sprintf('<a href="%s">%s</a>', 'http://varunsridharan.in/plugin-support/', __('Contact Author',WC_BGP_TXT) );
        $action = array_merge($actions,$action);
        return $action;
    }
    
    /**
	 * Adds Some Plugin Options
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 * @since 0.11
	 * @return array
	 */
	public function plugin_row_links( $plugin_meta, $plugin_file ) {
		if ( WC_BGP_FILE == $plugin_file ) {
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://wordpress.org/plugins/wc-better-grouped-products/', __('F.A.Q',WC_BGP_TXT) );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://github.com/technofreaky/wc-better-grouped-products', __('View On Github',WC_BGP_TXT) );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://github.com/technofreaky/wc-better-grouped-products', __('Report Issue',WC_BGP_TXT) );
            $plugin_meta[] = sprintf('&hearts; <a href="%s">%s</a>', 'https://www.paypal.me/varunsridharan23', __('Donate',WC_BGP_TXT) );
		}
		return $plugin_meta;
	}	    
}