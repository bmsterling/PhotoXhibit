<?php
/**
 *	This file will eventually become core to the photxhibit plugin
 */
//error_reporting(E_ERROR);
/**
 *	Load WP-Config File If This File Is Called Directly
 */
if (!function_exists('add_action')) {
	require_once('../../../../../wp-config.php');
} //  end : if (!function_exists('add_action'))
 
if(!class_exists("px_core")){
	class px_core{
		var $flickrapi = "99c12772538849fb2890645771d923f9";
		var $smugmugapi = "8vjhYpC7wz53UTdspu33yRaYXEPgrU5D";

		var $version = "2.1.5";
		var $dirName;
		var $dirPath;
		var $options;
		var $parentFile;
		var $baseFile;
		var $vars;
		var $cssBasePath;
		var $jsBasePath;
		var $styles = array();
		var $js = array();
		var $trueBasePath;
		var $flickrBaseUrl = "http://api.flickr.com/services/rest/?format=json&api_key=";
		var $is_2_5 = false;
		
		function px_core($_file_ = NULL){
			global $wpdb;
			$this->baseFile = $_file_;
			$this->baseName = plugin_basename($_file_);
			$this->dirPath = dirname($_file_);
			$this->dirName = basename($this->dirPath);
			$this->parentFile = array_pop( explode  ('\\',$_file_) );
			$this->parentFileUrl = get_bloginfo('wpurl')  . '/wp-content/plugins/' . $this->baseName;
			$this->cssBasePath = get_bloginfo('wpurl') . '/wp-content/plugins/' . $this->dirName . '/common/css/';
			$this->jsBasePath = get_bloginfo('wpurl') . '/wp-content/plugins/' . $this->dirName . '/photoxhibit.php?option=js&js=';
			$this->trueBasePath = str_replace( array($_SERVER['HTTP_HOST'], "http://"), "", $this->parentFileUrl);

			$options = array(
				// database tables
				'albums' => $wpdb->prefix . "px_albums",
				'albums_version' => "1.2",
				
				'albumPhotos' => $wpdb->prefix . "px_albumPhotos",
				'albumPhotos_version' => "1.2",

				'galleries' => $wpdb->prefix . "px_galleries",
				'galleries_version' => "1.2",

				'photos' => $wpdb->prefix . "px_photos",
				'photos_version' => "1.2",
				
				'plugins' => $wpdb->prefix . "px_plugins",
				'plugins_version' => "1.2",

				'parts' => get_bloginfo('wpurl') . '/wp-content/plugins/' . $this->dirName . '/common/inc/pages/parts/',
				
				'pluginjs' => get_bloginfo('wpurl') . '/wp-content/plugins/' . $this->dirName . '/galleryScripts/',
				'js' => get_bloginfo('wpurl') . '/wp-content/plugins/' . $this->dirName . '/common/js/',
				'css' => get_bloginfo('wpurl') . '/wp-content/plugins/' . $this->dirName . '/common/css/',
				'img' => get_bloginfo('wpurl') . '/wp-content/plugins/' . $this->dirName . '/common/img/'
			);
			$this->options = $options;
			unset($options);
			unset($_file_);
			$this->checkWPVersion();
		}

		
		function getOptions(){
			$this->vars = get_option('photoxhibit');
		}
		
		function getFlickrUrl(){
			return $this->flickrBaseUrl . $this->flickrapi . "&method=";
		}
		
		function loadExternals($path = NULL){
			if ( !is_file($this->dirPath . $path) ) return;
			include($this->dirPath . $path);
		}  //  end : function loadExternals
		
		function checkWPVersion(){
			global $wp_version;
			$this->is_2_5 = false;
			
			$tmp = explode('.',$wp_version);

			if( $tmp[0] == 2 && $tmp[1] >= 5 ){
				$this->is_2_5 = true;
			}
		}
		
		function loadCss(){
			$this->checkWPVersion();
			echo '<style>';
			foreach( $this->styles as $x ){
				echo '@import url( "'. $this->cssBasePath . $x . '");';
			}
			echo '</style>';
		}
		
		function loadJs(){
			$this->checkWPVersion();

			foreach( $this->js as $x ){
				if( $x == 'jquery' && $this->is_2_5 ) continue;

				wp_register_script('px_'.$x, $this->jsBasePath . $x . '&'.time());
				wp_print_scripts('px_'.$x);
			}
		}
		
		function encodeToUtf8($string) {
			$return = @mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
			
			if( !$return ){
				$return = @iconv("ISO-8859-1", "UTF-8", $string);
				if( !$return ){
					$return = $string;
				}
			}			
			return $return;
		}
		
		/**
		 *	Load js files
		 */
		function print_js($which = NULL){
			if($which == NULL) return;
			$arr = array('admin','easing','dimensions');
			if(!in_array($which,$arr)) header('Content-type: application/javascript charset=utf-8');
			
			
			$this->vars = get_option('photoxhibit');
			switch ( $which ){
				case 'panels':
					include($this->dirPath.'/common/js/panels.js'); 
					break;
				case 'jquery':
					include($this->dirPath.'/common/js/jquery.js'); 
					break;
				case 'blockUI':
					include($this->dirPath.'/common/js/jquery.blockUI.js'); 
					break;
				case 'core':
					include($this->dirPath.'/common/js/core.js'); 
					break;
				case 'ui':
					include($this->dirPath.'/common/js/jquery-ui.min.js'); 
					break;
				case 'draggable':
					include($this->dirPath.'/common/js/draggable.js'); 
					break;
				case 'droppable':
					include($this->dirPath.'/common/js/droppable.js'); 
					break;
				case 'selectable':
					include($this->dirPath.'/common/js/selectable.js'); 
					break;
				case 'dimension':
					include($this->dirPath.'/common/js/jquery.dimensions.min.js'); 
					break;
				case 'json':
					include($this->dirPath.'/common/js/json.js'); 
					break;
				case 'ease':
					include($this->dirPath.'/common/js/jquery.easing.1.3.js');
					break;

				case 'edit_styles':
					include($this->dirPath.'/common/js/edit_styles.js'); 
					break;
				case 'edit_image_attr':
					include($this->options['js'].'edit_image_attr.js');
					break;
				case 'easing':
					wp_register_script('px_easing', $this->options['js'] .'jquery.easing.1.3.js');
					wp_print_scripts('px_easing');
					break;
				case 'dimensions':
					wp_register_script('px_dimensions', $this->options['js'] .'jquery.dimensions.min.js');
					wp_print_scripts('px_dimensions');
					break;
				case 'admin':
					if( !$this->is_2_5 ){
						wp_register_script('px_jquery', $this->options['js'] .'jquery.js');
						wp_print_scripts('px_jquery');
					}
					wp_register_script('px_jqueryUI', $this->options['js'] .'jquery-ui.min.js');
					wp_print_scripts('px_jqueryUI');
					wp_register_script('px_core', get_bloginfo('wpurl').'/wp-content/plugins/' . $this->dirName . '/photoxhibit.php?option=js&js=core&'.time());
					wp_print_scripts('px_core');
					wp_register_script('px_json', $this->options['js'] .'json.js');
					wp_print_scripts('px_json');
					wp_register_script('px_block', $this->options['js'] .'jquery.blockUI.js');
					wp_print_scripts('px_block');
					break;
			}
			exit();
		}  //  end : get_pagePart()
		
		function update(){
			global $wpdb;
			echo '<pre>';

			$this->vars = get_option('photoxhibit');

			$jsversion = '';
			$pluginarray = array();

			$file = dirname(__FILE__) . '/pluginArray.php';
			if (file_exists($file)) {
				include($file);

				$jsversion = $galleriesVersion;
				
				$pluginarray  = $galleries;
			}

			$file = dirname(dirname(dirname(__FILE__))) . '/updatepluginarray.php';
			if (file_exists($file)) {
				include($file);
				$jsversion = $galleriesVersion;
				$pluginarray = array_merge($pluginarray, $galleries);
			}

			if ( $this->vars['plugins_version'] != $jsversion ){
				$plugins = $this->options['plugins'];

				foreach($pluginarray as $result => $value){
					$sql = "SELECT plugin_js, plugin_id FROM " . $plugins . " WHERE plugin_js = '" . $value['js'] . "'";
					$results = $wpdb->get_row($sql);
					if( !$results ){
						$sql = "INSERT INTO " . $plugins . " 
								(plugin_title, plugin_js, 
								plugin_css, plugin_example, plugin_params, 
								plugin_framework)  VALUES 
								( '". $wpdb->escape($value['title']) ."', 
								'".$wpdb->escape($value['js'])."', 
								'".$wpdb->escape($value['css'])."', 
								'".$wpdb->escape($value['example'])."', 
								'".$wpdb->escape($value['params'])."', 
								'".$wpdb->escape($value['framework'])."');";

						$wpdb->query($sql);
					}
					else{
						$sql = "UPDATE " . $plugins . " SET
								plugin_title = '". $wpdb->escape($value['title']) ."', 
								plugin_js = '".$wpdb->escape($value['js'])."', 
								plugin_css = '".$wpdb->escape($value['css'])."',
								plugin_example = '".$wpdb->escape($value['example'])."',
								plugin_params = '".$wpdb->escape($value['params'])."', 
								plugin_framework = '".$wpdb->escape($value['framework'])."'
								WHERE
								plugin_id = " . $results->plugin_id;

						$wpdb->query($sql);
					}
					unset($sql);
				}

				$this->vars['plugins_version'] = $jsversion;
				update_option('photoxhibit', $this->vars);
				@unlink($file);
				echo 'JavaScript Plugins have been updated' . "\n";
			}
			else{
				echo '* no update needed *' . "\n";
			}
			echo '</pre>';
		}  //  end : update()
		
		function onetimers($onetime = NULL){
			global $wpdb;
			switch($onetime){
				case 'linkLove':
					$wpdb->query("INSERT INTO $wpdb->links (link_url, link_name, link_category, link_rss, link_notes,link_description) VALUES ('http://benjaminsterling.com/photoxhibit/', 'Photo Gallery Plugn', 0, 'http://benjaminsterling.com/feed/', '','WordPress Photo Gallery Plugin by Benjamin Sterling');");
					$wpdb->query( "INSERT INTO $wpdb->term_relationships (`object_id`, `term_taxonomy_id`) VALUES (".mysql_insert_id().", 2)" );
					break;
			}
		}
		
		function checkforblogrollentry(){
			global $wpdb;
			$sql = "SELECT link_url FROM $wpdb->links WHERE link_url = 'http://benjaminsterling.com/photoxhibit/'";
			$results = $wpdb->get_row($sql);
			if( !$results ){
				include($this->dirPath.'/common/views/notice_link_love.htm');
			}
		}  //  end : checkforblogrollentry()
		
	}  //  end : class px_core
}  //  end : if(!class_exists("px_core"))
?>