<?php
/**
 * WooCommerce General Settings
 *
 * @author      WooThemes
 * @category    Admin
 * @package     WooCommerce/Admin
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WC_Better_Grouped_Products_Settings' ) ) :

/**
 * WC_Admin_Settings_General
 */
class WC_Better_Grouped_Products_Settings extends WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->id    = WC_BGP_SLUG;
		$this->label = __('WC Better Grouped Products', WC_BGP_TXT );

        add_filter( 'woocommerce_get_sections_products', array( $this,  'add_section' ));
        add_filter( 'woocommerce_get_settings_products', array( $this,'all_settings'), 10, 2 );
		add_action( 'woocommerce_settings_save_products', array( $this, 'save' ),1 );
	}
 

    public function add_section( $sections ) {
        $sections[WC_BGP_SLUG] = __('WC Better Grouped Products', WC_BGP_TXT );
        return $sections;
    }
    
    
    public function all_settings( $settings, $current_section ) {
        if($this->id == $current_section){

            $settings = array();
            
            // Add Title to the Settings
            $settings[] = array( 'name' => __( WC_BGP_NAME.' Settings', WC_BGP_TXT), 
                                 'type' => 'title',
                                 'id' => WC_BGP_SLUG );
            $settings[] = array(
                'name'     => __( 'Modify Product URL ', WC_BGP_TXT ),
                'id'       => WC_BGP_SLUG.'_modify_product_url',
                'type'     => 'checkbox',  
                'desc' => 'if checked all the product urls will be regenerated with the product sku.'
            ); 
            
            $settings[] = array(
                'name'     => __( 'Product URL Format', WC_BGP_TXT ),
                'id'       => WC_BGP_SLUG.'_product_url_format',
                'type'     => 'text',
                'desc'     => __( '<br/>    Use <code>%sku%</code> For Product SKU <br/>
                Use <code>%postname%</code> For Product Slug <br/>
                Use <code>%category%</code> For Product Category <br/>
                Use <code>%id%</code> For Product ID <br/>
                
                ', WC_BGP_TXT ),
            );  
            
            $settings[] = array( 'type' => 'sectionend', 'id' => WC_BGP_SLUG );
            
            $settings[] =   array('title' =>'', 
                                  'type' => 'title', 
                                  'desc' => __( '<h3> Product Url Looks Like :', WC_BGP_TXT ).' <code> <span id="product_sku_url">'.trailingslashit(home_url()).'<span id="product_sku_url_adds">'.get_option(WC_BGP_SLUG.'_product_url_format',true).'</span> </span> </code> </h3> ', 'id' => 'pricing_options' );
            
            $settings[] = array(
                'name'     => __( 'SKU URL Type', WC_BGP_TXT ),
                'id'       => WC_BGP_SLUG.'_url_type',
                'type'     => 'select',
                'options' => array(),
                'class' => 'wc-enhanced-select',
            ); 
            
            $settings[] = array(
                'name'     => __( 'SKU Custom Link', WC_BGP_TXT ),
                'id'       => WC_BGP_SLUG.'_custom_link',
                'type'     => 'text',
                'desc'     => __( ' <br/> 
                Use <code>%sku%</code> to replace the value with sku code <br/>
                Use <code>%any%</code> to replace any type of values like (Category, Slug, ID ) and more (Only Dynamic URL)
                ', WC_BGP_TXT ),
            );          
            
            
            $settings[] = array( 'type' => 'sectionend', 'id' => WC_BGP_SLUG );
            $settings[] =   array('title' =>'', 
                                  'type' => 'title', 
                                  'desc' => __( '<h3> Your Url Looks Like :', WC_BGP_TXT ).' <code> <span id="sku_url">'.trailingslashit(home_url()).'<span id="sku_url_adds">'.get_option(WC_BGP_SLUG.'_custom_link',true).'</span> </span> </code> </h3> ', 'id' => 'pricing_options' );
            
            
            
        }
        
        return $settings;
    }
 
 

	/**
	 * Save settings
	 */
	public function save() {
        global $current_section;
        if($this->id == $current_section){ 
            //$frontend = new WC_Better_Grouped_Products_Frontend;
            //$frontend->add_permalink_force();
        }
	}

}

endif;

return new WC_Better_Grouped_Products_Settings();
