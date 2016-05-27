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

class WC_Better_Grouped_Products_Handler {

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
        //$this->render_products();
    }
    
    public function render_products(){
        global $product,$post;
        $return_value = '';
        if($post->post_type !== 'product'){return;} 
        $current_product = $post->ID;
        $parent_product = wp_get_post_parent_id($post->ID);
        $childs = $this->get_child_products($parent_product);
        
        ob_start();
        wc_bgp_get_template('grouped-header.php');
        $header = ob_get_clean(); 
        ob_flush();
        
        ob_start();
        wc_bgp_get_template('grouped-footer.php');
        $footer .= ob_get_clean(); 
        ob_flush();
        
        $content = $this->generate_content($current_product,$childs,$parent_product);
        return $header.$content.$footer;
    }
    
    public function get_child_products($id){
        $args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'post_type'        => 'product',
            'post_parent'      => $id,
            'post_status'      => 'publish',
            'suppress_filters' => true,
            'fields' => 'ids'
        );
        $posts_array = get_posts( $args );
        return $posts_array;
    }
    
    public function generate_content($current_product,$childs,$parent_product){
        $return_value = $this->generate_single_content($current_product);
        foreach($childs as $child){
            if($child == $current_product){continue;}
            $return_value .= $this->generate_single_content($child);
        }
        return $return_value;
    }
    
    public function generate_single_content($id){
        $return_value = '';
        $wc_bg_product = wc_get_product($id);
        $img_size = apply_filters('wc_better_grouped_products_image_size','shop_thumbnail');

        $array = array();
        $array['product_link'] = get_permalink($id);
        $array['price'] = $wc_bg_product->get_price_html();
        $array['image'] = $wc_bg_product->get_image($img_size);
        $array['title'] = get_the_title($id);
        $array['addtocart'] = $wc_bg_product->add_to_cart_url();
        $array['addtocarttxt'] = $wc_bg_product->single_add_to_cart_text();

        ob_start();
        wc_bgp_get_template('grouped-single.php',$array);
        $return_value .= ob_get_clean(); 
        ob_flush();
        return $return_value;
    }
    
	
}