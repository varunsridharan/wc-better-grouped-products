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

class WC_Better_Grouped_Products_Shortcode_Handler {

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
        add_shortcode('wc_bgp_listing',array($this,'list_products'));
    }
    
    public function list_products($atts){
        $atts = shortcode_atts( array(
            'template' => 'wc_default', 
            'image_size' => 'shop_thumbnail',
        ), $atts, 'wc_bgp_listing' );

        $new = new WC_Better_Grouped_Products_Handler($atts);
        $n = $new->render_products();
        return $n;
    }
}