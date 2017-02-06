<?php 
/**
 * Plugin Main File
 *
 * @link https://wordpress.org/plugins/wc-better-grouped-products/
 * @package WC_Better_Grouped_Products
 * @subpackage WC_Better_Grouped_Products/core
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }
 
class WC_Better_Grouped_Products {
	public $version = '1.0';
	public $plugin_vars = array();
	
	protected static $_instance = null; # Required Plugin Class Instance
    protected static $functions = null; # Required Plugin Class Instance
	protected static $admin = null;     # Required Plugin Class Instance
	protected static $settings = null;  # Required Plugin Class Instance

    /**
     * Creates or returns an instance of this class.
     */
    public static function get_instance() {
        if ( null == self::$_instance ) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    
    /**
     * Class Constructor
     */
    public function __construct() {
        $this->define_constant();
        $this->load_required_files();
        $this->init_class();
        add_action('plugins_loaded', array( $this, 'after_plugins_loaded' ));
        add_filter('load_textdomain_mofile',  array( $this, 'load_plugin_mo_files' ), 10, 2);
    }
	
	/**
	 * Throw error on object clone.
	 *
	 * Cloning instances of the class is forbidden.
	 *
	 * @since 1.0
	 * @return void
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cloning instances of the class is forbidden.', WC_BGP_TXT), WC_BGP_V );
	}	

	/**
	 * Disable unserializing of the class
	 *
	 * Unserializing instances of the class is forbidden.
	 *
	 * @since 1.0
	 * @return void
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of the class is forbidden.',WC_BGP_TXT), WC_BGP_V);
	}

    /**
     * Loads Required Plugins For Plugin
     */
    private function load_required_files(){
       $this->load_files(WC_BGP_INC.'class-*.php');
	   $this->load_files(WC_BGP_ADMIN.'settings_framework/class-wp-*.php');
        
       if(wc_bgp_is_request('admin')){
           $this->load_files(WC_BGP_ADMIN.'class-*.php');
       } 
 
    }
    
    /**
     * Inits loaded Class
     */
    private function init_class(){
        self::$functions = new WC_Better_Grouped_Products_Functions;
        new WC_Better_Grouped_Products_Shortcode_Handler;
        
        if(wc_bgp_is_request('admin')){
            self::$admin = new WC_Better_Grouped_Products_Admin;     
        }
    }
    
    
	# Returns Plugin's Functions Instance
	public function func(){
		return self::$functions;
	}
	
	# Returns Plugin's Settings Instance
	public function settings(){
		return self::$settings;
	}
	
	# Returns Plugin's Admin Instance
	public function admin(){
		return self::$admin;
	}
    
    /**
     * Loads Files Based On Give Path & regex
     */
    protected function load_files($path,$type = 'require'){
        foreach( glob( $path ) as $files ){
            if($type == 'require'){ require_once( $files ); } 
			else if($type == 'include'){ include_once( $files ); }
        } 
    }
    
    /**
     * Set Plugin Text Domain
     */
    public function after_plugins_loaded(){
        load_plugin_textdomain(WC_BGP_TXT, false, WC_BGP_LANGUAGE_PATH );
    }
    
    /**
     * load translated mo file based on wp settings
     */
    public function load_plugin_mo_files($mofile, $domain) {
        if (WC_BGP_TXT === $domain)
            return WC_BGP_LANGUAGE_PATH.'/'.get_locale().'.mo';

        return $mofile;
    }
    
    /**
     * Define Required Constant
     */
    private function define_constant(){
        $this->define('WC_BGP_NAME', 'WooCommerce Better Grouped Products'); # Plugin Name
        $this->define('WC_BGP_SLUG', 'wc-better-grouped-products'); # Plugin Slug
        $this->define('WC_BGP_TXT',  'wc-better-grouped-products'); #plugin lang Domain
		$this->define('WC_BGP_DB', 'wc_bgp_');
		$this->define('WC_BGP_V',$this->version); # Plugin Version
		
		$this->define('WC_BGP_LANGUAGE_PATH',WC_BGP_PATH.'languages'); # Plugin Language Folder
		$this->define('WC_BGP_ADMIN',WC_BGP_INC.'admin/'); # Plugin Admin Folder
		$this->define('WC_BGP_SETTINGS',WC_BGP_ADMIN.'settings/'); # Plugin Settings Folder
        
		$this->define('WC_BGP_URL',plugins_url('', __FILE__ ).'/');  # Plugin URL
		$this->define('WC_BGP_CSS',WC_BGP_URL.'includes/css/'); # Plugin CSS URL
		$this->define('WC_BGP_IMG',WC_BGP_URL.'includes/img/'); # Plugin IMG URL
		$this->define('WC_BGP_JS',WC_BGP_URL.'includes/js/'); # Plugin JS URL
    }
	
    /**
	 * Define constant if not already set
	 * @param  string $name
	 * @param  string|bool $value
	 */
    protected function define($key,$value){
        if(!defined($key)){
            define($key,$value);
        }
    }
    
} 