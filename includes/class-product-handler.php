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
	public function __construct($atts) {
        $this->template = $atts['template'];
        $this->image_size = $atts['image_size'];
    }
    
    public function render_products(){
        global $product,$post;
        $return_value = '';
        
        if($post->post_type !== 'product'){return;} 
        $current_product = $post->ID;
        $parent_product = wp_get_post_parent_id($post->ID);
        $childs = $this->get_child_products($parent_product);
        
        if($this->template == 'woocommerce_with_image'){
           $content = $this->template_with_image($current_product,$childs,$parent_product);  
        } else if($this->template == 'woocommerce') {
            $content = $this->wc_default_template($current_product,$childs,$parent_product);
        }
        
        return $content;
    }
    
    
    public function wc_default_template($current_product,$childs,$parent_product){
        global $product;  

        $key = array_search($current_product, $childs);
        
        if($key == true){
            unset($childs[$key]);
            array_unshift($childs,$current_product);
        }
        
        ob_start();
        wc_bgp_get_template('wc-better-add-to-cart-grouped.php',array(
            'grouped_product'    => $product,
            'grouped_products'   => $childs,
            'current_grouped_product' => $current_product,
            'parent_product' => $parent_product,
            'quantites_required' => false
        ));
        $content = ob_get_clean(); 
        ob_flush();
        return $content;
    }
    
    public function template_with_image($current_product,$childs,$parent_product){
        ob_start();
        wc_bgp_get_template('wc-better-grouped-header.php');
        $header = ob_get_clean(); 
        ob_flush();
        
        ob_start();
        wc_bgp_get_template('wc-better-grouped-footer.php');
        $footer = ob_get_clean(); 
        ob_flush();
        
        $content = $this->generate_content($current_product,$childs,$parent_product);
        return $header.$content.$footer;
    }
    
    public function get_child_products($id){
        global $product;
        
        $posts_array = $product->get_children();
        
        if(empty($posts_array)){
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
        }
        
        return $posts_array;
    }
    
    public function generate_content($current_product,$childs,$parent_product){
        $return_value = $this->custom_template_1_generate_single_content($current_product);
        foreach($childs as $child){
            if($child == $current_product){continue;}
            $return_value .= $this->custom_template_1_generate_single_content($child);
        }
        return $return_value;
    }
    
    public function custom_template_1_generate_single_content($id){
        $return_value = '';
        $wc_bg_product = wc_get_product($id);
        $img_size = apply_filters('wc_better_grouped_products_image_size',$this->image_size);

        $array = array();
        $array['product_link'] = get_permalink($id);
        $array['price'] = $wc_bg_product->get_price_html();
        $array['image'] = $wc_bg_product->get_image($img_size);
        $array['title'] = get_the_title($id);
        $array['addtocart'] = $wc_bg_product->add_to_cart_url();
        $array['addtocarttxt'] = $wc_bg_product->single_add_to_cart_text();

        ob_start();
        wc_bgp_get_template('wc-better-grouped-single.php',$array);
        $return_value .= ob_get_clean(); 
        ob_flush();
        return $return_value;
    }
    
	
}