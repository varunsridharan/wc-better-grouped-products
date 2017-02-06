<?php
/**
 * WooCommerce General Settings
 *
 * @link [plugin_url]
 * @package [package]
 * @subpackage [package]/Admin/WC_Settings
 * @since [version]
 */
if ( ! defined( 'WPINC' ) ) { die; }

if ( ! class_exists( 'WooCommerce_Simple_Settings' ) ) :

/**
 * WC_Admin_Settings_General
 */
class WooCommerce_Simple_Settings extends WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
        add_filter( 'woocommerce_get_sections_products', array( $this, 'add_section' ) );
        add_filter( 'woocommerce_get_settings_products',  array( $this , 'get_settings'), 10, 2 );  
        add_action( 'woocommerce_settings_save_products', array( $this, 'save' ) );
	}
    
    /**
	 * Adds Settings SUB Menu Under Products
	 */
	public function add_section($sections){ 
		$sections['wc_bgp_settings'] = __("WC Better Grouped Products", WC_BGP_TXT );
		return $sections;
		
	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings($settings = '', $current_section = '') {
        if( $current_section == 'wc_bgp_settings'){
            $image_sizes = array_combine(get_intermediate_image_sizes(),get_intermediate_image_sizes());
            $settings = array(

            array( 
                'title' => __( WC_BGP_NAME, WC_BGP_TXT ), 
                'type' => 'title', 
                'desc' => '', 
                'id' => 'wc_simple_intergation' 
            ),
 

            array(
                'title'   => __( 'Hide Default WC Listing', WC_BGP_TXT ),
                'desc'    => __( 'Diable Default WC Grouped Product Listing', WC_BGP_TXT ),
                'id'      => WC_BGP_DB.'disable_default_grouped_list',
                'default' => 'no',
                'type'    => 'checkbox'
            ),
                
            array(
                'title'   => __( 'Show Plugin Template', WC_BGP_TXT ),
                'desc'    => __( 'If checked this will replace the way of listing done by WC ', WC_BGP_TXT ),
                'id'      => WC_BGP_DB.'change_way_listing',
                'default' => 'no',
                'type'    => 'checkbox'
            ),

                
            array(
                'title'    => __( 'Listing Template', WC_BGP_TXT ),
                'desc'     => __( 'How would you like to see the grouped product listing, <br/> you can also use our shortcode <code>[wc_bgp_listing template template="woocommerce"]</code>,<br/>Template Types : 1. woocommerce | 2. woocommerce_with_image', WC_BGP_TXT ),
                'id'       => WC_BGP_DB.'listing_template', 
                'type'     => 'select',
                'options'  => array(
                    'woocommerce' => __("Simple WooCommerce Style",WC_BGP_TXT),
                    'woocommerce_with_image' => __("WooCommerce With Image",WC_BGP_TXT)
                )
            ),
                
            array(
                'title'    => __( 'Image Size', WC_BGP_TXT ),
                'default' => 'shop_thumbnail',
                'desc'     => __( 'This will works only with woocommerce_with_image template', WC_BGP_TXT ),
                'id'       => WC_BGP_DB.'template_image_size', 
                'type'     => 'select',
                'options'  => $image_sizes
            ),

                
                
            
            array( 'type' => 'sectionend', 'id' => 'wc_simple_intergation'),



            );
        }
		

		return $settings;
	}
 
    /**
	 * Save settings
	 */
	public function save() { 
        global $current_section;
        $settings = $this->get_settings(array(),$current_section ); 
        WC_Admin_Settings::save_fields( $settings );
	}

}

endif;

return new WooCommerce_Simple_Settings();