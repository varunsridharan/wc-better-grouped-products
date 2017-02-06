<?php
/**
 * Dependency Checker
 *
 * Checks if required Dependency plugin is enabled
 *
 * @link https://wordpress.org/plugins/wc-better-grouped-products/
 * @package WC_Better_Grouped_Products
 * @subpackage WC_Better_Grouped_Products/FrontEnd
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

class WC_Better_Grouped_Products_Functions {

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
        add_action('woocommerce_init',array($this,'check_wc_init')); 
    }
    
    public function check_wc_init(){
        //add_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
        $status = wc_bgp_option('disable_default_grouped_list');
        if($status == 'yes'){
            remove_action('woocommerce_grouped_add_to_cart','woocommerce_grouped_add_to_cart',30);
        }
        
        $change_way_listing_status = wc_bgp_option('change_way_listing');
        if($change_way_listing_status == 'yes'){
            add_action("woocommerce_grouped_add_to_cart",array($this,'render_plugin_template'));
        }
        
    }
    
    
    public function render_plugin_template(){
        $template = wc_bgp_option('listing_template','woocommerce');
        $template_Image_size = wc_bgp_option('template_image_size','shop_thumbnail'); 
        echo do_shortcode('[wc_bgp_listing template="'.$template.'" image_size="'.$template_Image_size.'"]');
        
    }
     
}
