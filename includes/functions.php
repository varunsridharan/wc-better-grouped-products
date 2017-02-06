<?php
/**
 * Common Plugin Functions
 * 
 * @link https://wordpress.org/plugins/wc-better-grouped-products/
 * @package WC_Better_Grouped_Products
 * @subpackage WC_Better_Grouped_Products/core
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }


global $wc_bgp_db_settins_values;
$wc_bgp_db_settins_values = array();
add_action('wc_bgp_loaded','wc_bgp_get_settings_from_db',1);

if(!function_exists('wc_bgp_option')){
	function wc_bgp_option($key = '',$default = false){
        if($key == ''){return $default;}
        
        $value = get_option(WC_BGP_DB.$key,true);
        
        if($value){
            return $value;
        } else {
            return $default;
        }
         
	}
}

if(!function_exists('wc_bgp_get_settings_from_db')){
	/**
	 * Retrives All Plugin Options From DB
	 */
	function wc_bgp_get_settings_from_db(){
		global $wc_bgp_db_settins_values;
		$section = array();
		$section = apply_filters('wc_bgp_settings_section',$section); 
		$values = array();
		foreach($section as $settings){
			foreach($settings as $set){
				$db_val = get_option(WC_BGP_DB.$set['id']);
				if(is_array($db_val)){ unset($db_val['section_id']); $values = array_merge($db_val,$values); }
			}
		}        
		$wc_bgp_db_settins_values = $values;
	}
}

if(!function_exists('wc_bgp_is_request')){
    /**
	 * What type of request is this?
	 * string $type ajax, frontend or admin
	 * @return bool
	 */
    function wc_bgp_is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();
            case 'ajax' :
                return defined( 'DOING_AJAX' );
            case 'cron' :
                return defined( 'DOING_CRON' );
            case 'frontend' :
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
        }
    }
}

if(!function_exists('wc_bgp_current_screen')){
    /**
     * Gets Current Screen ID from wordpress
     * @return string [Current Screen ID]
     */
    function wc_bgp_current_screen(){
       $screen =  get_current_screen();
       return $screen->id;
    }
}

if(!function_exists('wc_bgp_get_screen_ids')){
    /**
     * Returns Predefined Screen IDS
     * @return [Array] 
     */
    function wc_bgp_get_screen_ids(){
        $screen_ids = array();
        $screen_ids[] = 'woocommerce_page_wc-better-grouped-products-settings';
        return $screen_ids;
    }
}

if(!function_exists('wc_bgp_dependency_message')){
	function wc_bgp_dependency_message(){
		$text = __( WC_BGP_NAME . ' requires <b> WooCommerce </b> To Be Installed..  <br/> <i>Plugin Deactivated</i> ', WC_BGP_TXT);
		return $text;
	}
}

if(!function_exists('wc_bgp_get_template')){
	function wc_bgp_get_template($name,$args = array()){
		wc_get_template( $name, $args ,'woocommerce/', WC_BGP_PATH.'/templates/' );
	}
}

if(!function_exists('wc_bgp_settings_products_json')){
    function wc_bgp_settings_products_json($ids){
        $json_ids    = array();
        if(!empty($ids)){
            $ids = explode(',',$ids);
            foreach ( $ids as $product_id ) {
                $product = wc_get_product( $product_id );
                $json_ids[ $product_id ] = wp_kses_post( $product->get_formatted_name() );
            }   
        }
        return $json_ids;
    }
}

if(!function_exists('wc_bgp_settings_get_categories')){
    function wc_bgp_settings_get_categories($tax='product_cat'){
        $args = array();
        $args['hide_empty'] = false;
        $args['number'] = 0; 
        $args['pad_counts'] = true; 
        $args['update_term_meta_cache'] = false;
        $terms = get_terms($tax,$args);
        $output = array();
        
        foreach($terms as $term){
            $output[$term->term_id] = $term->name .' ('.$term->count.') ';
        }
        
        return $output; 
    }
}

if(!function_exists('wc_bgp_settings_page_link')){
    function wc_bgp_settings_page_link($tab = '',$section = ''){
        $settings_url = admin_url('admin.php?page='.WC_BGP_SLUG.'-settings');
        if(!empty($tab)){$settings_url .= '&tab='.$tab;}
        if(!empty($section)){$settings_url .= '#'.$section;}
        return $settings_url;
    }   
}

if(!function_exists('wc_bgp_get_settings_sample')){
	/**
	 * Retunrs the sample array of the settings framework
	 * @param [string] [$type = 'page' | 'section' | 'field'] [[Description]]
	 */
	function wc_bgp_get_settings_sample($type = 'page'){
		$return = array();
		
		if($type == 'page'){
			$return = array( 
				'id'=>'settings_general', 
				'slug'=>'general', 
				'title'=>__('General',WC_BGP_TXT),
				'multiform' => 'false / true',
				'submit' => array( 
					'text' => __('Save Changes',WC_BGP_TXT), 
					'type' => 'primary / secondary / delete', 
					'name' => 'submit'
				)
			);
			
		} else if($type == 'section'){
			$return['page_id'][] = array(
				'id'=>'general',
				'title'=>'general', 
				'desc' => 'general',
				'submit' => array(
					'text' => __('Save Changes',WC_BGP_TXT), 
					'type' => 'primary / secondary / delete', 
					'name' => 'submit'
				)
			);
		} else if($type == 'field'){
			$return['page_id']['section_id'][] = array(
				'id' => '',
				'type' => 'text, textarea, checkbox, multicheckbox, radio, select, field_row, extra',
				'label' => '',
				'options' => 'Only required for type radio, select, multicheckbox [KEY Value Pair]',
				'desc' => '',
				'size' => '',
				'default' => '',
				'attr' => "Key Value Pair",
				'before' => 'Content before the field label',
				'after' => 'Content after the field label',
				'content' => 'Content used for type extra' ,
				'text_type' => "Set the type for text input field (e.g. 'hidden' )",
			);
		}
	}
}

if(!function_exists('wc_bgp_admin_notice')){
    function wc_bgp_admin_notice($msg , $type = 'updated'){
        $notice = ' <div class="'.$type.' settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p>'.$msg.'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
        return $notice;
    }
}

if(!function_exists('wc_bgp_get_ajax_overlay')){
	/**
	 * Prints WC PBP Ajax Loading Code
	 */
	function wc_bgp_get_ajax_overlay($echo = true){
		$return = '<div class="wc_bgp_ajax_overlay">
		<div class="sk-folding-cube">
		<div class="sk-cube1 sk-cube"></div>
		<div class="sk-cube2 sk-cube"></div>
		<div class="sk-cube4 sk-cube"></div>
		<div class="sk-cube3 sk-cube"></div>
		</div>
		</div>';
		if($echo){echo $return;}
		else{return $return;}
	}
}
?>