<?php
/**
 * Plugin's Admin code
 *
 * @link https://wordpress.org/plugins/wc-better-grouped-products/
 * @package WC_Better_Grouped_Products
 * @subpackage WC_Better_Grouped_Products/Admin
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

class WC_Better_Grouped_Products_Admin {

    /**
	 * Initialize the class and set its properties.
	 * @since      0.1
	 */
	public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ),99);
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_init', array( $this, 'admin_init' ));

        add_filter( 'plugin_row_meta', array($this, 'plugin_row_links' ), 10, 2 ); 
        add_filter( 'woocommerce_get_settings_pages',  array($this,'settings_page') );  
	} 
    
    /**
     * Inits Admin Sttings
     */
    public function admin_init(){
        new WC_Better_Grouped_Products_Admin_Ajax_Handler;
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
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() { 
        $current_screen = wc_bgp_current_screen();
        $addon_url = admin_url('admin-ajax.php?action=wc_bgp_addon_custom_css');
        
        wp_register_style(WC_BGP_SLUG.'_backend_style',WC_BGP_CSS.'backend.css' , array(), WC_BGP_V, 'all' );  
        wp_register_style(WC_BGP_SLUG.'_addons_style',$addon_url , array(), WC_BGP_V, 'all' );  
        
        if(in_array($current_screen , wc_bgp_get_screen_ids())) {
            wp_enqueue_style(WC_BGP_SLUG.'_backend_style');  
            wp_enqueue_style(WC_BGP_SLUG.'_addons_style');  
        }
        
        do_action('wc_bgp_admin_styles',$current_screen);
	}
	
    
    /**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {
        $current_screen = wc_bgp_current_screen();
        $addon_url = admin_url('admin-ajax.php?action=wc_bgp_addon_custom_js');
        
        wp_register_script(WC_BGP_SLUG.'_backend_script', WC_BGP_JS.'backend.js', array('jquery'), WC_BGP_V, false ); 
        
        if(in_array($current_screen , wc_bgp_get_screen_ids())) {
            wp_enqueue_script(WC_BGP_SLUG.'_backend_script' ); 
        } 
        
        do_action('wc_bgp_admin_scripts',$current_screen); 
 
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
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://wordpress.org/plugins/wc-better-grouped-products/faq', __('F.A.Q',WC_BGP_TXT) ); 
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://wordpress.org/plugins/wc-better-grouped-products', __('Report Issue',WC_BGP_TXT) ); 
		}
		return $plugin_meta;
	}	    
}
