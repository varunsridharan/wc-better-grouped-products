<?php 
if(isset($_REQUEST['change'])){
	$files_check = array();
	get_php_files(__DIR__);
	foreach ($files_check as $f){
		$file = file_get_contents($f);
		
		$file = str_replace('WooCommerce Plugin Boiler Plate','WooCommerce Better Grouped Products',$file);
		$file = str_replace('woocommerce-plugin-boiler-plate','wc-better-grouped-products',$file);
		$file = str_replace('WooCommerce_Plugin_Boiler_Plate','WC_Better_Grouped_Products',$file);
		$file = str_replace('https://wordpress.org/plugins/woocommerce-plugin-boiler-plate/', 'https://wordpress.org/plugins/wc-better-grouped-products/' , $file ); 
		$file = str_replace('[version]', '1.0' , $file ); 
		$file = str_replace('[package]', 'WC_Better_Grouped_Products' , $file ); 
		$file = str_replace('[plugin_name]', 'WooCommerce Better Grouped Products' , $file ); 
		$file = str_replace('[plugin_url]', 'https://wordpress.org/plugins/wc-better-grouped-products/' , $file ); 
		$file = str_replace('wc_pbp_','wc_bgp_',$file);
		$file = str_replace('PLUGIN_FILE', 'WC_BGP_FILE' , $file);
		$file = str_replace('PLUGIN_PATH', 'WC_BGP_PATH' , $file);
		$file = str_replace('PLUGIN_INC', 'WC_BGP_INC' , $file);
		$file = str_replace('PLUGIN_DEPEN', 'WC_BGP_DEPEN' , $file);
		$file = str_replace('PLUGIN_NAME', 'WC_BGP_NAME' , $file);
		$file = str_replace('PLUGIN_SLUG', 'WC_BGP_SLUG' , $file);
		$file = str_replace('PLUGIN_TXT', 'WC_BGP_TXT' , $file);
		$file = str_replace('PLUGIN_DB', 'WC_BGP_DB' , $file);
		$file = str_replace('PLUGIN_V', 'WC_BGP_V' , $file);
		$file = str_replace('PLUGIN_LANGUAGE_PATH', 'WC_BGP_LANGUAGE_PATH' , $file);
		$file = str_replace('PLUGIN_ADMIN', 'WC_BGP_ADMIN' , $file);
		$file = str_replace('PLUGIN_SETTINGS', 'WC_BGP_SETTINGS' , $file);
		$file = str_replace('PLUGIN_URL', 'WC_BGP_URL' , $file);
		$file = str_replace('PLUGIN_CSS', 'WC_BGP_CSS' , $file);
		$file = str_replace('PLUGIN_IMG', 'WC_BGP_IMG' , $file);
		$file = str_replace('PLUGIN_JS', 'WC_BGP_JS' , $file);		
		
		file_put_contents($f,$file); 
	}
}

function get_php_files($dir = __DIR__){
	global $files_check;
	$files = scandir($dir); 
	foreach($files as $file) {
		if($file == '' || $file == '.' || $file == '..' ){continue;}
		if(is_dir($dir.'/'.$file)){
			get_php_files($dir.'/'.$file);
		} else {
			if(pathinfo($dir.'/'.$file, PATHINFO_EXTENSION) == 'php' || pathinfo($dir.'/'.$file, PATHINFO_EXTENSION) == 'txt'){
				if($file == 'generate.php'){continue;}
				$files_check[$file] = $dir.'/'.$file;
			}
		}
	}
}
?>


