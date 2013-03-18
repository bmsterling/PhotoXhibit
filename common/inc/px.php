<?php
//error_reporting(E_ERROR | E_WARNING);
header('Content-Type: text/html; charset=UTF-8');
include_once('core.php');
if(!class_exists("px")){
	class px extends px_core{
		var $dirName;
		var $dirPath;
		var $options;
		var $parentFile;
		var $baseFile;
		var $vars;
		
		var $api_smugmug = '8vjhYpC7wz53UTdspu33yRaYXEPgrU5D';
		var $api_flickr = '99c12772538849fb2890645771d923f9';
		 
		var $cur_album_id = 0;
		var $cur_album_info = NULL;
		 
		var $cur_gallery_id = 0;
		var $cur_gallery_info = NULL;
		var $cur_image_group = array();
		var $cur_return = '';
		var $cur_js_func = '';
		var $cur_js_show = '';
		
		var $cur_upload_dir = '';
		var $cur_album_dir = '';
		var $cur_image_info = '';
		
		var $album_list = '';
		
		var $safe_mode = false;
		
		function px($file=''){
			global $wpdb;
			$this->baseFile = $file;
			$this->baseName = plugin_basename($this->baseFile);
			$this->dirPath = dirname($file);
			$this->dirName = basename($this->dirPath);
			$this->parentFile = array_pop( explode  ('\\',$file) );
			$this->parentFileUrl = get_bloginfo('wpurl')  . '/wp-content/plugins/' . $this->baseName;

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

				'js' => get_bloginfo('wpurl') . '/wp-content/plugins/' . $this->dirName . '/common/js/',

				'css' => get_bloginfo('wpurl') . '/wp-content/plugins/' . $this->dirName . '/common/css/',

				'img' => get_bloginfo('wpurl') . '/wp-content/plugins/' . $this->dirName . '/common/img/',
				
				'pluginjs' => get_bloginfo('wpurl') . '/wp-content/plugins/' . $this->dirName . '/galleryScripts/',
				
				'parts' => get_bloginfo('wpurl') . '/wp-content/plugins/' . $this->dirName . '/common/inc/pages/parts/'
			);
			$this->options = $options;
			unset($options);


			if ((gettype(ini_get('safe_mode')) == 'string')) {
				if (ini_get('safe_mode') == 'off'){
					$this->safe_mode = false;
				}
				else{
					$this->safe_mode = ini_get('safe_mode');
				}
			}
			else{
				echo ini_get('safe_mode');
				$this->safe_mode = ini_get('safe_mode');
			}
			
			add_action('admin_menu', array(&$this, 'adminMenu'));
			
			if( isset( $_POST['onetimer'] ) ){
				$this->onetimers( $_POST['onetimer'] );
			}
			parent::px_core($file);
			unset($file);
			$this->init();
		}


		/**
		 *	
		 */
		function init(){
			add_action('activate_' . $this->dirName . '/photoxhibit.php',array(&$this,'install'));
			add_action('deactivate_' . $this->dirName . '/photoxhibit.php',array(&$this,'unintall'));
		}

		function unintall(){}


		/**
		 *	
		 */
		function adminMenu(){
			if (function_exists('add_menu_page')) {
				add_menu_page('PhotoXhibit','PhotoXhibit', 7, $this->baseFile, array(&$this, 'adminOverView'));
			}
			if (function_exists('add_submenu_page')) {
				add_submenu_page($this->baseFile, __('OverView', 'photoxhibit'), __('OverView', 'photoxhibit'), 7, $this->baseFile, array(&$this, 'adminOverView'));
				add_submenu_page($this->baseFile, __('Manage Gallery', 'photoxhibit'), __('Manage Gallery', 'photoxhibit'), 7, 'px_manage', array(&$this, 'adminManageGallery'));
				add_submenu_page($this->baseFile, __('Build Gallery', 'photoxhibit'), __('Build Gallery', 'photoxhibit'), 7, 'px_build', array(&$this, 'adminBuild'));
			
				add_submenu_page($this->baseFile, __('Manage Album', 'photoxhibit'), __('Manage Album', 'photoxhibit'), 7, 'px_manageAlbum', array(&$this, 'adminManageAlbum'));

				add_submenu_page($this->baseFile, __('Options', 'photoxhibit'), __('Options', 'photoxhibit'), 7, 'px_options', array(&$this, 'adminOptions'));

				add_submenu_page($this->baseFile, __('About', 'photoxhibit'), __('About', 'photoxhibit'), 7, 'px_about', array(&$this, 'adminAbout'));
			}
		}  //  end : adminMenu()
		
		function edit_image_form( $id = NULL ){
			global $wpdb;
			if( $id == NULL ){
				$id = $_GET['iid'];
			}
			$this->cur_image_info = $wpdb->get_row("SELECT * FROM ".$this->options['albumPhotos']." WHERE albumPhotos_id = ".$wpdb->escape($id));
			if( !empty($_GET['iid']) ){
				include($this->dirPath.'/common/views/album/edit_image_attr.php');
			}
		}
		
		function edit_image_single(){
			global $wpdb;
				$sql = "UPDATE ".$this->options['albumPhotos'] . " SET 
						albumPhotos_alt='". $wpdb->escape($_GET['albumPhotos_alt'])."', 
						albumPhotos_tags='". $wpdb->escape($_GET['albumPhotos_tags'])."',
						albumPhotos_isactive='". $wpdb->escape($_GET['albumPhotos_isactive'])."' ,
						albumPhotos_desc='". $wpdb->escape($_GET['albumPhotos_desc'])."' 
						WHERE albumPhotos_id=" . $wpdb->escape($_GET['albumPhotos_id']);
				$wpdb->query($sql);
				
			echo '{"id":'.$_GET['albumPhotos_id'].'}';
			
		}
		
		function delete_image( $id = NULL ){
			global $wpdb;
			if( $id == NULL ){
				$id = $_GET['iid'];
			}
			

			$this->edit_image_form( $id );
			$sql = "DELETE FROM ".$this->options['photos']." WHERE albumPhotos_id = " . $wpdb->escape($id) . " LIMIT 1";
			@mysql_query( $sql ) or die("An unexpected error occured.".mysql_error());
			$sql = "DELETE FROM ".$this->options['albumPhotos']." WHERE albumPhotos_id = " . $wpdb->escape($id) . " LIMIT 1";
			@mysql_query( $sql ) or die("An unexpected error occured.".mysql_error());
			$options = get_option('photoxhibit');
			

			if( $options['options_delete'] == 1 ){
				$this->get_upload_dir($this->cur_image_info->album_id);
 
				$dir = $this->cur_upload_dir;

				@unlink($dir . '/' . $this->cur_image_info->albumPhotos_file . '.' . $this->cur_image_info->albumPhotos_ext);
				@unlink($dir . '/' . $this->cur_image_info->albumPhotos_file . '_tn.' . $this->cur_image_info->albumPhotos_ext);
				@unlink($dir . '/' . $this->cur_image_info->albumPhotos_file . '_ltn.' . $this->cur_image_info->albumPhotos_ext);
				@unlink($dir . '/' . $this->cur_image_info->albumPhotos_file . '_o.' . $this->cur_image_info->albumPhotos_ext);
			}

			if( $id != NULL ){
				echo '{"complete":true}';
				exit(0);
			}
		}

		/**
		 *	
		 */
		function get_set_album($get){
			global $wpdb;
			$id = $get['album_id'];
			
			if( $id == 0 ){
				$sql = "INSERT INTO ".$this->options['albums'] . "
						(album_name) VALUES ('". $wpdb->escape($get['album_name'])."')";
				$wpdb->query($sql);

				$id = mysql_insert_id();
			}
			else{
				$sql = "UPDATE ".$this->options['albums'] . " SET album_name='". $wpdb->escape($get['album_name'])."' WHERE album_id=" . $id;
				$wpdb->query($sql);
			}
				
			echo '{"id":'.$id.',"album_name":"'.$get['album_name'].'"}';
		}
		
		function get_photos_from_album($id = NULL){
			global $wpdb;
			if( $id == NULL ){
				$id = $_GET['aid'];
			}
			return $wpdb->get_results("SELECT * FROM ".$this->options['albumPhotos']." WHERE album_id=".$wpdb->escape($id));
		}


		/**
		 *	
		 */
		function adminManageAlbum(){
			global $wpdb;

			$this->styles = array('base.css');
			$this->loadCss();

			$this->js = array('jquery','ui','core','json');
			$this->getOptions();
			$this->loadJs();
			
			$imageGroup = '';

			if( isset($_GET['do']) ){
				$this->imageUpload();
			}
			
			$this->vars = get_option('photoxhibit');
			if( isset( $_GET['aid'] ) ){
				$imageGroup = $this->get_photos_from_album();
				$this->get_album_dir();
			}

			switch($_GET['action']){
				case 'edit_images':
					include($this->dirPath.'/common/views/album/edit_images.php');
					break;
				case 'edit_image':
					include('pages/parts/edit_image.php');
					break;
				case 'build_album':
					include('pages/build_album.php');
					break;
				case 'delete_album':
					$this->deleteAlbum();
				default:
					include('pages/albumManager.php');
			}
		}  //  end : adminManageGallery()
		
		function deleteAlbum(){
			global $wpdb;
		//	$sql = "DELETE FROM ".$this->options['albums']." WHERE album_id = " . $wpdb->escape($_GET['aid']) . " LIMIT 1";
		//	@mysql_query( $sql ) or die("(deleteAlbum) An unexpected error occured.".mysql_error());
			
			$options = get_option('photoxhibit');
			
			if( $options['options_dropall'] == 1 ){

				$this->get_upload_dir($_GET['aid']);
				$this->removeFolder($this->cur_upload_dir);

				$results = $wpdb->get_results("SELECT albumPhotos_id FROM ".$this->options['albumPhotos']." 
											WHERE album_id=".$wpdb->escape($_GET['aid']));
				if(is_array($results) && is_a($results[0], 'stdClass')){
					foreach($results as $result => $v){
						$sql = "DELETE FROM ".$this->options['photos']." 
								WHERE albumPhotos_id = " . $wpdb->escape($v->albumPhotos_id) . " 
								LIMIT 1";
						@mysql_query( $sql ) or die("An unexpected error occured.".mysql_error());
					}
				}
				
				$sql = "DELETE FROM ".$this->options['albumPhotos']." 
						WHERE album_id = " . $wpdb->escape($_GET['aid']);
				@mysql_query( $sql ) or die("An unexpected error occured.".mysql_error());

			}
			else{
				$sql = "UPDATE ".$this->options['albumPhotos'] ."
						SET album_id = 0 
						WHERE album_id = " . $_GET['aid'];
				$wpdb->query($sql);			
			}

			$sql = "DELETE FROM ".$this->options['albums']." WHERE album_id = " . $wpdb->escape($_GET['aid']) . " LIMIT 1";
			@mysql_query( $sql ) or die("An unexpected error occured.".mysql_error());
		}

		function removeFolder($dir){
			if(!is_dir($dir))
				return false;
			for($s = DIRECTORY_SEPARATOR, $stack = array($dir), $emptyDirs = array($dir); $dir = array_pop($stack);){
				if(!($handle = @dir($dir)))
					continue;
				while(false !== $item = $handle->read())
					$item != '.' && $item != '..' && (is_dir($path = $handle->path . $s . $item) ?
					array_push($stack, $path) && array_push($emptyDirs, $path) : unlink($path));
				$handle->close();
			}
			for($i = count($emptyDirs); $i--; rmdir($emptyDirs[$i]));
		}


		/**
		 *	Load overview page
		 */
		function adminOverView(){
			$this->write_baseCss();
			$this->checkforblogrollentry();
			include('pages/overview.php');
		}  //  end : adminOverView()

		
		function update_styles($local = false){
			global $wpdb;//editStyles
			
			if($local){
			
				$return = '';
				$returnA = array();
				//if(empty($_POST['px_stylesTextarea'])) array_push($returnA,'{"error":"error_no_styles"}');
				if(empty($_POST['gid'])) array_push($returnA,__('No gallery id'));
				
				if( count($returnA) <= 0 ){
					$sql = "UPDATE " . $this->options['galleries'] . " SET gallery_css='".$wpdb->escape($_POST['px_stylesTextarea']) ."' WHERE gallery_id = " . $wpdb->escape($_POST['gid']);
					$r = @mysql_query($sql) or die("An unexpected error occured.".mysql_error());;
				}
				if($r){
					echo '<div class="wrap">'.__('Styles have been updated') .'</div>';
				}
				else{
					echo '<div class="wrap">' . __('Error(s) on update:') . '<br/>' . join('<br/>',$returnA) .'</div>';
				}
			}
			else{
			
				$return = '';
				$returnA = array();
				if(empty($_POST['styles'])) array_push($returnA,'{"error":"error_no_styles"}');
				if(empty($_POST['gid'])) array_push($returnA,'{"error":"error_no_id"}');
				
				if( count($returnA) <= 0 ){
					$sql = "UPDATE " . $this->options['galleries'] . " SET gallery_css='".$wpdb->escape($_POST['styles']) ."' WHERE gallery_id = " . $wpdb->escape($_POST['gid']);
					$r = @mysql_query($sql) or die("An unexpected error occured.".mysql_error());;
				}
				if($r){
					echo '{"good":"no_errors"}';
				}
				else{
					echo '['.'{"error":"error_update"}'.join(',',$returnA) . ']';
				}
			}
		}

		/**
		 *	Load build page
		 */
		function get_gallery_data($id=0){
			global $wpdb;
			$id = ($id==0) ? $this->cur_gallery_id : $id;
			$sql = "SELECT * FROM ".$this->options['galleries']." WHERE gallery_id = ".$wpdb->escape($id);
			return $wpdb->get_row($sql);
		}// end : get_album_data


		/**
		 *	Get Gallery Information
		 */
		function get_gallery_info(){
			global $wpdb;
			$this->cur_gallery_info = $this->get_gallery_data();
		}// end : get_album_info


		/**
		 *	Build Image Gallery
		 */
		function build_image_set($gallery_id=0, $r = false, $js = true){
			if( $gallery_id == 0 ) return;

			$this->cur_gallery_id = $gallery_id;
			$this->cur_js_show = $js;
			$this->get_gallery_info();
			
			if($this->cur_gallery_info){
				$this->get_js_func();
				$this->get_imgs_group();
				$this->buildout_images();
				
				$this->get_css_link();
				$this->get_js_code();
			}

			if($r){
				return $this->cur_return;
			}
			else{
				echo $this->cur_return;
			}
		 }  //  end :  function build_image_set()


		/**
		 *	
		 */
		function get_css_link(){
			$this->cur_return .= '<link id="px_editstylesheet" type="text/css" href="'.$this->parentFileUrl.'?option=css&gid='.$this->cur_gallery_id.'&'.time().'" rel="stylesheet"/>';
		}  // end : get_css_link


		/**
		 *	
		 */
		function get_js_func(){
			global $wpdb;
			$sql = "SELECT * FROM " . $this->options['plugins'] .' where plugin_id ='.$this->cur_gallery_info->plugin_id;
			$tmp = $wpdb->get_row($sql);
			$this->cur_js_func = $tmp->plugin_js;
		}  // end : get_js_func


		/**
		 *	
		 */
		function get_js_code(){
			if(!$this->cur_js_show) return;

			if (!extension_loaded('json')){
				include_once('JSON.php');
				$json = new JSON;
				$objs = $json->unserialize(stripslashes($this->cur_gallery_info->gallery_params));
			}
			else{
				$objs = json_decode(stripslashes($this->cur_gallery_info->gallery_params));
			}
			$jsParam = array();
			if($objs){
				foreach($objs as $obj => $k){
					$k = (is_numeric($k) || is_bool($k)) ? $k : '"'.$k.'"';
					array_push($jsParam, $obj . ':' . $k);
				}
			}
			
			if (function_exists('wp_register_script')) {
				wp_register_script('px_jquery', $this->options['js'] .'jquery.js');
				wp_print_scripts('px_jquery');
		
				wp_register_script('px_tmpjs'.$this->cur_js_func, $this->options['pluginjs'].$this->cur_js_func.'/'.$this->cur_js_func.'.js', null, '2.01');
				wp_print_scripts('px_tmpjs'.$this->cur_js_func);
			}
			
			$showA = '';
			//'a.'.$this->cur_js_func .',
			switch($this->cur_js_func){
				case 'lightBox':
				case 'lightboxbe':
				case 'thickbox':
					$selector = '#px'.$this->cur_gallery_id.' a';
					break;
				default:
					$selector = '#px'.$this->cur_gallery_id;
					break;
			}
			
			$this->cur_return .= '<script type="text/javascript">(function($){$(document).ready(function(){$("'.$selector.'").'.$this->cur_js_func.'({'.join(',',$jsParam).'});});})(jQuery);</script>';
		}  //  end : get_js_code
		
		/**
		 * @name buildout_images
		 * @example	buildout_images()
		 * @description Builds out a list item with images and links
		 */
		function buildout_images(){	
			$return="";
			if($this->cur_gallery_info->gallery_structure == '0'){
				$return .= '<ul id="px'.$this->cur_gallery_id;
				$return .= '" title="'.htmlentities($this->cur_gallery_info->gallery_title,ENT_COMPAT, 'UTF-8').'">'."\n";

				foreach ($this->cur_image_group as $result) {
					$title = htmlentities($result->photo_alt,ENT_COMPAT, 'UTF-8');

					if( $title == 'null' || $title == 'NULL' || $title == null || $title == NULL ){
						$title = '';
					}

					if(!$this->cur_gallery_info->album_uselarge){
						$return .= '<li><a href="'.$result->photo_url;
						$return .= '" rel="g'.$this->cur_gallery_id.'" ';
						$return .= '" title="'.$title.'" ';
						$return .= '" alt="'.$title.'"><img src="';
						$return .= ($album_large) ? $result->photo_url : $result->photo_tnurl;
						$return .= '" metadata="';
						$return .= encodeURIComponent('{"tnurl":"'.$result->photo_tnurl.'","url":"'.$result->photo_url.'","alt":"'.$title.'"}');
						$return .= '" alt="'.$title.'"/></a></li>'."\n";
					}
					else{
						$return.= '<li><img alt="'.$title.'" src="';
						$return .= $result->photo_url;
						$return .= '" metadata="'.encodeURIComponent('{"t":"'.$result->photo_tnurl.'","f":"'.$result->photo_url.'","a":"'.$title.'"}').'"/></li>';
					}
				}
				$return .= '</ul>'."\n";
				$this->cur_return .= $return;
			}
			else if($this->cur_gallery_info->gallery_structure == '1'){
				$return .= '<table id="px'.$this->cur_gallery_id;
				$return .= '" title="'.htmlentities($this->cur_gallery_info->gallery_title,ENT_COMPAT, 'UTF-8').'" border="0" cellspacing="0" cellpadding="0">';
				$i = 1;
				$cols = $this->cur_gallery_info->gallery_extra;
				$total = count($this->cur_image_group);
				foreach ($this->cur_image_group as $result) {
					$title = htmlentities($result->photo_alt,ENT_COMPAT, 'UTF-8');
					
					if( $title == 'null' || $title == 'NULL' || $title == null || $title == NULL ){
						$title = '';
					}

					if(($i % $cols) == 1){
						$return .= "<tr>\n";
					}
					
					$return .= "<td>\n";
					
					$return .= '<a class="'.$this->cur_js_func.'" rel="g'.$this->cur_gallery_id.'" href="'.$result->photo_url;
					$return .= '" title="'.$title;
					$return .= '" alt="'.$title.'"><img src="';
					$return .= ($album_large) ? $result->photo_url : $result->photo_tnurl;
					$return .= '" metadata="'.encodeURIComponent('{"t":"'.$result->photo_tnurl.'","f":"'.$result->photo_url.'","a":"'.$title.'"}');
					$return .= '" alt="'.$title.'"/></a>';

					$return .= '<p>'.$result->photo_alt.'</p>';
					
					$return .= "</td>\n";
		
					if(($i % $cols) == 0){
						$return .= "</tr>\n";
					}
					else if($i == $total){
						//echo $cols-($total%$cols);
						for($j = 1; $j <= ($cols-($total%$cols)); $j++){
							$return .= "<td>&nbsp;</td>\n";
						}
						$return .= "</tr>\n";			
					}
					$i++;
				}
				
				$return .= '</table>';
				$this->cur_return .= $return;
				
			}
			else if($this->cur_gallery_info->gallery_structure == '2'){
				$return .= '<table id="px'.$this->cur_gallery_id;
				$return .= '" title="'.htmlentities($this->cur_gallery_info->gallery_title,ENT_COMPAT, 'UTF-8').'" border="0" cellspacing="0" cellpadding="0">';
				$i = 1;
				$cols = $this->cur_gallery_info->gallery_extra;
				$total = count($this->cur_image_group);
				foreach ($this->cur_image_group as $result) {
					$title = htmlentities($result->photo_alt,ENT_COMPAT, 'UTF-8');
					
					if( $title == 'null' || $title == 'NULL' || $title == null || $title == NULL ){
						$title = '';
					}

					if(($i % $cols) == 1){
						$return .= "<tr>\n";
					}
					
					$return .= "<td>\n";
					
					$return .= '<a class="'.$this->cur_js_func.'" rel="g'.$this->cur_gallery_id.'" href="'.$result->photo_url;
					$return .= '" title="'.$title;
					$return .= '" alt="'.$title.'"><img src="';
					$return .= ($album_large) ? $result->photo_url : $result->photo_tnurl;
					$return .= '" metadata="'.encodeURIComponent('{"t":"'.$result->photo_tnurl.'","f":"'.$result->photo_url.'","a":"'.$title.'"}');
					$return .= '" alt="'.$title.'"/></a>';

					$return .= "</td>\n";
		
					if(($i % $cols) == 0){
						$return .= "</tr>\n";
					}
					else if($i == $total){
						//echo $cols-($total%$cols);
						for($j = 1; $j <= ($cols-($total%$cols)); $j++){
							$return .= "<td>&nbsp;</td>\n";
						}
						$return .= "</tr>\n";			
					}
					$i++;
				}
				
				$return .= '</table>';
				$this->cur_return .= $return;
				
			}
			else if($this->cur_gallery_info->gallery_structure == '3'){
				$return .= '<div id="px'.$this->cur_gallery_id;
				$return .= '" title="'.htmlentities($this->cur_gallery_info->gallery_title,ENT_COMPAT, 'UTF-8').'" >';

				foreach ($this->cur_image_group as $result) {
					$title = htmlentities($result->photo_alt,ENT_COMPAT, 'UTF-8');
					
					if( $title == 'null' || $title == 'NULL' || $title == null || $title == NULL ){
						$title = '';
					}
				
					$return .= '<div class="pxDivWrapper"><a class="'.$this->cur_js_func.'" rel="g'.$this->cur_gallery_id.'" href="'.$result->photo_url;
					$return .= '" title="'.$title.'" ';
					$return .= '" alt="'.$title.'"><img src="';
					$return .= ($album_large) ? $result->photo_url : $result->photo_tnurl;
					$return .= '" metadata="'.encodeURIComponent('{"t":"'.$result->photo_tnurl.'","f":"'.$result->photo_url.'","a":"'.$title.'"}');
					$return .= '" alt="'.$title.'"/></a></div>';
				}
				$return .= '</div>';
				$this->cur_return .= $return;
			}
			else if($this->cur_gallery_info->gallery_structure == '4'){
				$return .= '<div id="px'.$this->cur_gallery_id;
				$return .= '" title="'.htmlentities($this->cur_gallery_info->gallery_title,ENT_COMPAT, 'UTF-8').'" >'."\n";

				foreach ($this->cur_image_group as $result) {
					$title = htmlentities($result->photo_alt,ENT_COMPAT, 'UTF-8');
					
					if( $title == 'null' || $title == 'NULL' || $title == null || $title == NULL ){
						$title = '';
					}
				
					$return .= '<div class="pxDivWrapper"><a class="'.$this->cur_js_func.'" rel="g'.$this->cur_gallery_id.'" href="'.$result->photo_url;
					$return .= '" title="'.$title.'" ';
					$return .= '" alt="'.$title.'"><img src="';
					$return .= ($album_large) ? $result->photo_url : $result->photo_tnurl;
					$return .= '" metadata="'.encodeURIComponent('{"t":"'.$result->photo_tnurl.'","f":"'.$result->photo_url.'","a":"'.$title.'"}');
					$return .= '" alt="'.$title.'"/></a>';
					
					$return .= '<p>'.$result->photo_alt.'</p>';
					
					$return .= '</div>'."\n";
				}
				$return .= '</div>';
				$this->cur_return .= $return;
			}
			else if($this->cur_gallery_info->gallery_structure == 'empty'){
				$return .= '<div id="px'.$this->cur_gallery_id;
				$return .= '" title="'.htmlentities($this->cur_gallery_info->gallery_title,ENT_COMPAT, 'UTF-8').'" >'."\n";
				foreach ($this->cur_image_group as $result) {
					$return .= '<a class="'.$this->cur_js_func.'" rel="g'.$this->cur_gallery_id.'" href="'.$result->photo_url;
					$return .= '" title="'.$title.'" ';
					$return .= '" alt="'.$title.'"><img src="';
					$return .= ($album_large) ? $result->photo_url : $result->photo_tnurl;
					$return .= '" metadata="'.encodeURIComponent('{"t":"'.$result->photo_tnurl.'","f":"'.$result->photo_url.'","a":"'.$title.'"}');
					$return .= '" alt="'.$title.'"/></a>';
				}
				$return .= '</div>';
				$this->cur_return .= $return;
			}
		}// end : print_img_list
		


		/**
		 *	Load build page
		 */
		function adminBuild(){
			$this->vars = get_option('photoxhibit');
			$this->styles = array('base.css');
			$this->loadCss();

			$this->js = array(/*'jquery',*/'ui','core','json','blockUI','ease'/*,'dimension'*/);
			$this->getOptions();
			$this->loadJs();

			if( isset( $_GET['gid'] ) ){
				 $this->cur_gallery_info = $this->get_gallery_data( $_GET['gid'] );

				$this->get_imgs_group();
			}
			
			$this->get_album_list();

			//$this->print_supportProject();
			include('pages/build.php');
			unset($this->vars);
		}  //  end : adminBuild()
		
		function get_album_list(){
			global $wpdb;
			$this->album_list = $wpdb->get_results("SELECT * FROM ".$this->options['albums']);
		}
		
		/**
		 * @name get_image
		 * @example	get_imgs_group()
		 * @description Gets the images that are related to the album
		 */
		function get_imgs_group(){
			global $wpdb;
			$this->cur_image_group = $wpdb->get_results("SELECT * FROM ".$this->options['photos']." WHERE gallery_id=".$wpdb->escape($this->cur_gallery_id)." ORDER BY photo_order ASC");
		}// end : get_imgs_group
		
		function build_img_admin_list(){
			if(empty($this->cur_image_group)) return;
			$return = '';
			foreach ($this->cur_image_group as $result) {
				$return.= '<li><img alt="'.htmlentities($result->photo_alt).'" src="';
				$return .= $result->photo_tnurl;
				$return .= '" metadata="'.encodeURIComponent('{"t":"'.$result->photo_tnurl.'","f":"'.$result->photo_url.'","a":"'.$result->photo_alt.'","i":'.$result->albumPhotos_id.'}').'"/></li>';
			}
			
			echo $return;
		}


		/**
		 *	Load about page
		 */
		function adminAbout(){
			$this->print_supportProject();
			include('pages/about.php');
		}  //  end : adminAbout()



		
		function update_photos(){
			global $wpdb;
			if(empty($_GET['value'])) return '{"error":"error_no_text"}';
			if(empty($_GET['pid'])) return '{"error":"error_no_id"}';
			
			$sql = "UPDATE " . $this->options['photos'] . " SET photo_alt='".$wpdb->escape($_GET['value']) ."' WHERE photo_id = " . $wpdb->escape($_GET['pid']);
			
			$r = @mysql_query($sql) or die("An unexpected error occured.".mysql_error());;
			
			if($r){
				echo '{"good":"no_errors"}';
			}
			else{
				echo '{"error":"error_update"}';
			}
			
		}

		/**
		 *	Load page parts
		 */
		function get_pagePart($part = NULL){
			switch($part){
				case 'picasaParams':
					include('pages/parts/picasaParams.php');
					break;
				case 'flickrParams':
					include('pages/parts/flickrParams.php');
					break;
				case 'smugMugParams':
					include('pages/parts/smugMugParams.php');
					break;
				case 'optionsBasic':
					include('pages/parts/optionsBasic.php');
					break;
				case 'optionsServices':
					include('pages/parts/optionsServices.php');
					break;
				case 'usage':
					include('pages/parts/usage.php');
					break;
				case 'buildServices':
					include('pages/parts/buildServices.php');
					break;
				case 'buildPicasaOptions':
					include('pages/parts/buildPicasaOptions.php');
					break;
				case 'buildPicasaBasic':
					include('pages/parts/buildPicasaBasic.php');
					break;
				case 'buildPicasaAdvanced':
					include('pages/parts/buildPicasaAdvanced.php');
					break;
				case 'buildPicasaThumbnails':
					include('pages/parts/buildPicasaThumbnails.php');
					break;
				case 'buildFlickrOptions':
					include('pages/parts/buildFlickrOptions.php');
					break;
				case 'buildFlickrBasic':
					include('pages/parts/buildFlickrBasic.php');
					break;
				case 'buildFlickrAPI':
					include('pages/parts/buildFlickrAPI.php');
					break;
				case 'buildFlickrPhotoset':
					include('pages/parts/buildFlickrPhotoset.php');
					break;
				case 'buildFlickrSearch':
					include('pages/parts/buildFlickrSearch.php');
					break;
				case 'buildFlickrThumbnails':
					include('pages/parts/buildFlickrThumbnails.php');
					break;
				case 'buildSmugMugOptions':
					include('pages/parts/buildSmugMugOptions.php');
					break;
				case 'buildSmugMugBasic':
					include('pages/parts/buildSmugMugBasic.php');
					break;
				case 'buildSmugMugAPI':
					include('pages/parts/buildSmugMugAPI.php');
					break;
				case 'buildSmugMugAdvance':
					include('pages/parts/buildSmugMugAdvance.php');
					break;
				case 'buildSmugMugThumbnails':
					include('pages/parts/buildSmugMugThumbnails.php');
					break;
				case 'buildAlbumList':
					include('pages/parts/buildAlbumList.php');
					break;
				case 'buildAlbumThumbnails':
					include('pages/parts/buildAlbumThumbnails.php');
					break;
					
				case 'buildLocal':
					include('pages/parts/buildLocal.php');
					break;	
				case 'buildBrowse':
					include('pages/parts/buildBrowse.php');
					break;
				case 'buildStructure':
					include('pages/parts/buildStructure.php');
					break;
				case 'buildGalleryOptions':
					include('pages/parts/buildGalleryOptions.php');
					break;
				case 'optionsBasics':
					include('pages/parts/optionsBasics.php');
					break;
			}
		}  //  end : get_pagePart()


		function get_plugins_selectMenu($id=0){
			$results = $this->get_plugins();
			$return = '<select name="px_selectPlugin" id="px_selectPlugin"><option';
			$return .=  ($id==0)? ' selected="selected" ' : '';
			$return .=  ' value="0"></option>';
			foreach ($results as $result) {
				$return.= '<option value="'.$result->plugin_id.'" title="'.$result->plugin_example.'" metadata="'.encodeURIComponent($result->plugin_params).'"';
				$return .= ($id == $result->plugin_id) ? ' selected="selected" ':'';
				$return .= '>'.$result->plugin_title.'</option>';
			}
			echo $return .= '</select>';
		}  //  end : get_galleries_selectMenu()

		/**
		 *	
		 */
		function get_plugins($id=0){
			global $wpdb;
			$sql = "SELECT * FROM " . $this->options['plugins'];
			if( $id != 0 ){
				$sql .= ' where plugin_id ='.$wpdb->escape($id);
			}
			return $wpdb->get_results($sql);
		}  //  end : get_galleries()


		/**
		 *	Load options page
		 */
		function adminOptions(){
			$this->styles = array('base.css');
			$this->loadCss();
			$this->js = array('jquery','ui','core');
			$this->getOptions();
			$this->loadJs();
			echo '<style>@import url( "'.$this->options['css'] .'ui.flora.css");</style>';
			$this->vars = get_option('photoxhibit');
			include('pages/options.php');
			unset($this->vars);
		}  //  end : adminOverView()


		/**
		 *	The SQL statement for Albums
		 */
		function adminManageGallery(){
			global $wpdb;
			$this->js = array('jquery','ui','core','json','jquery.blockUI');
			$this->getOptions();
			$this->loadJs();


			if( isset( $_GET['gid'] ) ){
				$this->cur_gallery_info = $this->get_gallery_data( $_GET['gid'] );
				$this-> get_imgs_group();
			}

			$this->print_supportProject();
			switch($_GET['action']){
				case 'edit_styles':
					if( isset($_GET['do']) && !empty($_GET['do']) && $_GET['do']=='editStyles' ){
						$this->update_styles(true);
					}
					include('pages/edit_styles.php');
					break;
				case 'edit_image_attr':
					include('pages/edit_image_attr.php');
					break;
				case 'delete_gallery':
					$this->delete_gallery();
				default:
					include($this->dirPath.'/common/views/gallery/manager.php');
			}
			unset($this->vars);
		}  //  end : adminManageGallery()
		
		function delete_gallery(){
			global $wpdb;
			$sql = "DELETE FROM ".$this->options['galleries']." WHERE gallery_id = " . $wpdb->escape($_GET['gid']) . " LIMIT 1";
			@mysql_query( $sql ) or die("An unexpected error occured.".mysql_error());

			$sql = "DELETE FROM ".$this->options['photos']." WHERE gallery_id = " . $wpdb->escape($_GET['gid']);
			@mysql_query( $sql ) or die("An unexpected error occured.".mysql_error());
		}
	
		function install(){
			global $wpdb;
			require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
			add_option('photoxhibit', NULL, 'Options for the PhotoXhibit plugin', 'no');
			$options = get_option('photoxhibit');
			
	
			$album = $this->options['albums'];
			if($wpdb->get_var("show tables like '$album'") != $album) {
				dbDelta($this->get_albumsCreateSql());
				$options['album_version'] = $this->options['albums_version'];
			}
			else{
				if($options['album_version'] != $this->options['albums_version']){
					dbDelta($this->get_albumsCreateSql());
					$options['album_version'] = $this->options['albums_version'];
				}
			}
	
			$plugins = $this->options['plugins'];
	
			if($wpdb->get_var("show tables like '$plugins'") != $plugins) {
				dbDelta($this->get_pluginsCreateSql());
				$options['plugins_version'] = $this->options['plugins_version'];
				include('pluginArray.php');
	
				$sql = "INSERT INTO " . $plugins . " (plugin_id, plugin_title, plugin_js, plugin_css, plugin_example, plugin_params, plugin_framework)  VALUES ";
				$sqlArray = array();
				for ($i = 0; $i < count($galleries); $i++) {
					array_push($sqlArray, "( ".($i+1).", '". $wpdb->escape($galleries[$i]['title']) ."', '".$wpdb->escape($galleries[$i]['js'])."', '".$wpdb->escape($galleries[$i]['css'])."', '".$wpdb->escape($galleries[$i]['example'])."', '".$wpdb->escape($galleries[$i]['params'])."', '".$wpdb->escape($galleries[$i]['framework'])."')");
				}
				$sql .= join(',',$sqlArray);

				$wpdb->query($sql);
			}
			else{
				if(	$options['plugins_version'] != $this->options['plugins_version'] ){
					dbDelta($this->get_pluginsCreateSql());
					$options['plugins_version'] = $this->options['plugins_version'];
				}
			}
		
			$galleries = $this->options['galleries'];
			if($wpdb->get_var("show tables like '$galleries'") != $galleries) {
				dbDelta($this->get_galleriesCreateSql());
				$options['galleries_version'] = $this->options['galleries_version'];
			}
			else{
				if( $options['galleries_version'] != $this->options['galleries_version'] ){
					dbDelta($this->get_galleriesCreateSql());
					$options['galleries_version'] = $this->options['galleries_version'];
				}
			}
		
			$photos = $this->options['photos'];
			if($wpdb->get_var("show tables like '$photos'") != $photos) {
				dbDelta($this->get_photoCreateSql());
				$options['photos_version'] = $this->options['photos_version'];
			}
			else{
				if( $options['photos_version'] != $this->options['photos_version'] ){
					dbDelta($this->get_photoCreateSql());
					$options['photos_version'] = $this->options['photos_version'];
				}
			}
		
			$aphotos = $this->options['albumPhotos'];
			if($wpdb->get_var("show tables like '$aphotos'") != $aphotos) {
				dbDelta($this->get_albumPhotosCreateSql());
				$options['albumPhotos_version'] = $this->options['albumPhotos_version'];
			}
			else{
				if( $options['albumPhotos_version'] != $this->options['albumPhotos_version'] ){
					dbDelta($this->get_albumPhotosCreateSql());
					$options['albumPhotos_version'] = $this->options['albumPhotos_version'];
				}
			}

			$options['use_picasa'] = 1;
			$options['use_flickr'] = 1;
			$options['use_smugmug'] = 1;
			$options['use_album'] = 1;
			$options['use_local'] = 1;
			$options['use_browse'] = 0;
			$options['options_thumbailSet'] = 0;
		
			$options["options_thumbailW"] = 100;
			$options["options_thumbailH"] = 100;
			$options["options_thumbailW2"] = 250;
			$options["options_thumbailH2"] = 250;
	
			$options['options_MaxWidth'] = 800;
			$options['options_MaxHeight'] = 600;
			
			$options['options_imageQuality'] = 80;
			$options['options_tnimageQuality'] = 90;
			
			$options['options_original'] = 0;
			$options['options_dropall'] = 0;
			
			
			$options["use_effectSlide"] = 0;

			
			$options['options_path'] = attribute_escape(str_replace(ABSPATH, '', get_option('upload_path')));
			$options['options_delete'] = 1;
			$options["use_manager"] = 0;
			
			$options["flash_version_multi_upload"] = 1;
			$options["none_ajax_styles"] = 1;
			
			update_option('photoxhibit', $options);
		}  //  end : install()

		/**
		 *	Get Import CSS
		 */
		function write_baseCss(){
			echo '<style>@import url( "'.$this->options['css'] .'base.css");</style>';
		}

		/**
		 *	Get CSS
		 */
		function print_css($id=0){
			global $wpdb;
			header('Content-type: text/css');
			$r = $wpdb->get_row('SELECT gallery_css from ' . $this->options['galleries'] . ' WHERE gallery_id = ' . $id);
			echo $r->gallery_css;
		}

		/**
		 *	Get Album JSON
		 */
		function get_album_json_special($url = NULL){
			include('clsParseXML.php');
			$xmlparse = new ParseXML;

			$xml = $xmlparse->GetXMLTree($url);

			if (!extension_loaded('json')){
				include('JSON.php');
				$json = new JSON;
				$return = $json->serialize($xml['RSS'][0]['CHANNEL'][0]['ITEM']);
			}
			else{
				$return = json_encode($xml['RSS'][0]['CHANNEL'][0]['ITEM']);
			}
			
			
			//$return = json_encode($xml['RSS'][0]['CHANNEL'][0]['ITEM']);
			return  ($return) ? $return : '{"result":"error","errorType":"NoEncode"}';
		}
		
		function check_set_allow_url_fopen($do = NULL){
			$allow_fopen = (ini_get('allow_url_fopen') == '1');
			
			switch($do){
				case 'open':
					if (!$allow_fopen) {
						ini_set('allow_url_fopen', 'On');
						if(ini_get('allow_url_fopen') != 'On'){
							die("{'result':'error','errorType':'no_fopen'}");
						}
					}
					break;
				case 'close':
					if (!$allow_fopen) {
						ini_set('allow_url_fopen', '0');
					}
					break;
			}
		}
		
		/**
		 *	Get Album JSON
		 */
		function get_albumListSmugMug_json($api=NULL,$un=NULL){
			$this->check_set_allow_url_fopen('open');
			$url = "http://api.smugmug.com/hack/json/1.2.0/?APIKey=".$this->api_smugmug."&method=smugmug.login.anonymously";
			$info = @file_get_contents($url);
			if (!extension_loaded('json')){
				include('JSON.php');
				$json = new JSON;
				$return = $json->unserialize($info);
			}
			else{
				$return = json_decode($info);
			}

			$return = @file_get_contents("http://api.smugmug.com/hack/json/1.2.0/?APIKey=".$this->api_smugmug."&method=smugmug.albums.get&Heavy=1&NickName=".$un."&SessionID=".$return->Login->Session->id);

			$this->check_set_allow_url_fopen('close');
			return  ($return) ? $return : '{"result":"error","errorType":"NoEncode"}';
		}

		/**
		 *	Get Album JSON
		 */
		function get_album_json($url = NULL){
			$this->check_set_allow_url_fopen('open');
			$url = str_replace(array('rss_200','rss'),'json',$url);
			if(strpos($url, 'flickr') === false){}
			else{
				$url .= '&nojsoncallback=1&format=json';
			}
			
			if(preg_match("/smugmug/", $url)){
				preg_match('/APIKey=(.*)&method/ise', $url, $matches);
				$info = file_get_contents("http://api.smugmug.com/hack/json/1.2.0/?APIKey=".$matches[1]."&method=smugmug.login.anonymously");
				if (!extension_loaded('json')){
					include('JSON.php');
					$json = new JSON;
					$return = $json->unserialize($info);
				}
				else{
					$return = json_decode($info);
				}
				
				$url .= "&SessionID=".$return->Login->Session->id;
			}
			$return = @file_get_contents($url);
			$this->check_set_allow_url_fopen('close');
			return  ($return) ? $return : '{"result":"error","errorType":"fileGetContent"}';
		}

		/**
		 *
		 */
		function getImagesFromDir($dir = NULL, $combine=false){
			$allowed_types = array('png','jpg','jpeg','gif');
			$d 	=	dir($dir);
			$x	=	array();
			
			while(false !== ($r = $d->read())){
				if($r!="."&&$r!=".."){
					if(is_dir($dir.$r)){
						$x = array_merge($x, $this->getImagesFromDir($dir.$r.'/', false));
					}
					else if(is_file($dir.$r)){
						if(in_array(strtolower(substr($dir.$r,-3)),$allowed_types)){
							array_push($x, $r);
						}
						
					}
				}
			}
			
			if($combine){
				$v = array();
				for($i=0; $i < count($x); $i++){
					array_push($v, array('img'=>array($x[$i],$x[$i++ + 1])));
				}
				
				unset($x);
				$x = $v;
			}
			
			return $x;
		}

		/**
		 *	The SQL statement for albums
		 */
		function get_albumsCreateSql(){
			return "CREATE TABLE " . $this->options['albums'] . " (
				album_id bigint(20) NOT NULL auto_increment,
				album_name varchar(255) NOT NULL,
				album_sortorder int(2) NOT NULL default '99',
				PRIMARY KEY  (album_id)
			);";
		}  //  end : get_ablumCreateSql()


		/**
		 *	The SQL statement for Galleries
		 */
		function get_galleriesCreateSql(){
			return "CREATE TABLE " . $this->options['galleries'] . " (
				gallery_id mediumint(9) NOT NULL auto_increment,
				gallery_title varchar(100) NOT NULL,
				plugin_id mediumint(9) default '0',
				gallery_params varchar(255) default NULL,
				gallery_framework varchar(100) default 'jQuery',
				gallery_css text,
				gallery_uselarge char(1) NOT NULL default '0',
				gallery_structure int(1) NOT NULL default '0',
				gallery_extra varchar(100)  default NULL,
				PRIMARY KEY  (gallery_id)
			);";
		}  //  end : get_ablumCreateSql()


		/**
		 *	The SQL statement for Plugins
		 */
		function get_pluginsCreateSql(){
			return "CREATE TABLE " . $this->options['plugins'] . " (
				plugin_id mediumint(9) NOT NULL auto_increment,
				plugin_title varchar(100) NOT NULL,
				plugin_js varchar(100) NOT NULL,
				plugin_css text,
				plugin_example varchar(255) default NULL,
				plugin_params text,
				plugin_framework varchar(100) default 'jQuery',
				PRIMARY KEY  (plugin_id)
			);";
		}  //  end : get_galleryCreateSql()


		/**
		 *	The SQL statement for Photo
		 */
		function get_photoCreateSql(){
			return "CREATE TABLE " . $this->options['photos'] . " (
				photo_id mediumint(9) NOT NULL auto_increment,
				photo_alt varchar(255) default NULL,
				photo_url varchar(255) NOT NULL,
				photo_tnurl varchar(255) NOT NULL,
				photo_order int(3) NOT NULL default '99',
				gallery_id int(3) NOT NULL,
				albumPhotos_id int(10) NULL default 0,
				PRIMARY KEY  (photo_id)
			);";
		}  //  end : get_photoCreateSql()


		/**
		 *	The SQL statement for albumPhotos
		 */
		function get_albumPhotosCreateSql(){
			return "CREATE TABLE " . $this->options['albumPhotos'] . " (
				albumPhotos_id int(10) NOT NULL auto_increment,
				album_id int(10) default '0',
				post_id int(10) default '0',
				albumPhotos_file varchar(255) NOT NULL,
				albumPhotos_ext varchar(4) NOT NULL default 'jpg',
				albumPhotos_desc text,
				albumPhotos_alt mediumtext,
				albumPhotos_tags varchar(255) default NULL,
				albumPhotos_isactive char(1) default '1',
				PRIMARY KEY  (albumPhotos_id),
				KEY album_id (album_id,post_id)
			);";
		}  //  end : get_albumPhotosCreateSql()


		/**
		 *	The Support Project Message
		 */
		function print_supportProject(){
?>
<div class="wrap">
	<table cellpadding="3" cellspacing="3" border="0">
		<tr>
			<td valign="top">
				<p><?php echo __('Please help support this project with a donation.  All monies donated will go toward hosting and bandwidth.', 'photoxhibit');?></p>
			</td>
			<td>
	<form action="https://www.paypal.com/cgi-bin/webscr" target="_blank" method="post"><input type="hidden" name="cmd" value="_s-xclick"><input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!"><img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"><input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----"></form>
			</td>
		</tr>
	</table>
</div>
<?php
		}  //  end : print_supportProject()
		
		function processGallery($post = null){
			global $wpdb;
			$return = array();

			$imgs = $this->encodeToUtf8(stripslashes($post['images']));
			$imgs = stripslashes($post['images']);
			include('JSON.php');
			$json = new JSON;
			$objs = $json->unserialize($imgs);
/*
			if (!extension_loaded('json')){
			}
			else{
				$objs = json_decode($imgs);
			}
*/
			
			if(!is_array($objs) && !is_a($objs[0], 'stdClass')){
				return '{"result":"error","errorType":"notObj"}';
				exit();
			}
			
			array_push($return,'"images":'.stripslashes($post['images']).'');
			array_push($return,'"params":'.stripslashes($post['gallery_params']).'');
			array_push($return,'"structure":"'.$post['gallery_structure'].'"');
			array_push($return,'"title":"'.$post['gallery_title'].'"');
			array_push($return,'"useLarge":'.$post['gallery_uselarge'].'');
			array_push($return,'"cols":"'.$post['gallery_extra'].'"');

			$sql = "SELECT * FROM ".$this->options['plugins']." WHERE plugin_id = ".$post['plugin_id'];
			$pluginResult = @$wpdb->get_row($sql);

			array_push($return,'"gallery":"'.$pluginResult->plugin_js.'"');

			if( isset($post['gallery_id']) && !empty($post['gallery_id']) ){
				$id = $post['gallery_id'];

				$sql = "UPDATE ".$this->options['galleries'] . " SET 
						gallery_title = '". $wpdb->escape($post['gallery_title'])."',
						plugin_id = ". $wpdb->escape($post['plugin_id']).",
						gallery_params = '". $wpdb->escape($post['gallery_params'])."',
						gallery_framework = '". $wpdb->escape($pluginResult->plugin_framework)."',
						gallery_uselarge = '". $wpdb->escape($post['gallery_uselarge'])."',
						gallery_structure = ". $wpdb->escape($post['gallery_structure']).",
						gallery_extra = '". $wpdb->escape($post['gallery_extra'])."'
						WHERE gallery_id = ".$wpdb->escape($id)." LIMIT 1";
				$wpdb->query($sql);
				
				if( $post['plugin_id'] != $post['curplugin_id'] ){
					$css = preg_replace(array('/#px/','/{PXPATH}/'), array('#px'.$id,$this->options['pluginjs'].$pluginResult->plugin_js),$pluginResult->plugin_css);

					$sql = "UPDATE ".$this->options['galleries'] . " SET 
							gallery_css = '". $css ."'
							WHERE gallery_id = ".$wpdb->escape($id)." LIMIT 1";
					$wpdb->query($sql);
				}
			}
			else{

				$sql = "INSERT INTO ".$this->options['galleries'] . "
						(gallery_title, plugin_id, gallery_params, gallery_css, 
						gallery_framework, gallery_uselarge, gallery_structure,gallery_extra) VALUES (
						'". $wpdb->escape($post['gallery_title'])."',
						". $wpdb->escape($post['plugin_id']).",
						'". $wpdb->escape($post['gallery_params'])."',
						'". $wpdb->escape($pluginResult->plugin_css)."',
						'". $wpdb->escape($pluginResult->plugin_framework)."',
						'". $wpdb->escape($post['gallery_uselarge'])."',
						". $wpdb->escape($post['gallery_structure']).",
						'". $wpdb->escape($post['gallery_extra'])."')";
				$wpdb->query($sql);

				$id = mysql_insert_id();
				$sql = "UPDATE ".$this->options['galleries'];
				$sql .= " SET gallery_css = '".preg_replace(array('/#px/','/{PXPATH}/'), array('#px'.$id,$this->options['pluginjs'].$pluginResult->plugin_js),$pluginResult->plugin_css) ."'";
				$sql .= " WHERE gallery_id = " . $id;
				$wpdb->query($sql);//
			}
			
			$sql = "DELETE FROM ".$this->options['photos']." WHERE gallery_id = ".$id ;
			$wpdb->query($sql);
	
			foreach($objs as $obj => $v){
				$sql = "INSERT INTO ".$this->options['photos']." 
						(photo_alt, photo_url, photo_tnurl, photo_order,gallery_id, albumPhotos_id) 
						VALUES 
						('".$wpdb->escape($v->a)."','".$v->f."','".$v->t."','".$obj."',$id,".$v->i.")";
				$wpdb->query($sql);
			}
				
			return '{"result":"done","id":"'.$id.'",'.join(',',$return).'}';
		}  //  end : processGallery()



		function get_OptionTable($params=NULL, $plugin_id=0){
			global $wpdb;
/*
			if($params == NULL){
			echo '
		<script type="text/javascript">
			$(document).ready(function(){
				$("#selectGallery").trigger("change");
			});
		</script>
			';
			}
			else{
*/
				if (!extension_loaded('json')){
					include_once('JSON.php');
					$json = new JSON;
					$objs = $json->unserialize(stripslashes($params));
				}
				else{
					$objs = json_decode(stripslashes($params));
				}
				
				if( $plugin_id != 0 ){
				
					$sql = "SELECT * FROM ".$this->options['plugins']." WHERE plugin_id = ".$wpdb->escape($plugin_id);
					$r = $wpdb->get_row($sql);
				}
				
				if (!extension_loaded('json')){
					include_once('JSON.php');
					$json = new JSON;
					$galparams = $json->unserialize(stripslashes($r->plugin_params));
				}
				else{
					$galparams = json_decode(stripslashes($r->plugin_params));
				}
				$return = '';
				if($galparams->parameters){
					foreach ($galparams->parameters as $galparam => $v) {
						$return .= '<tr><td>'.$v->param.'</td><td><input type="text" size="30" name="'.$v->param.'"';
						$tmp = $v->param;
						$return .= ($objs->$tmp) ? ' value="'.$objs->$tmp.'" ' : '';
						$return .= '/></td><td>'.$v->desc.'</td></tr>';
					}
				}
				echo $return;
/*
			}
*/
		}

		//*****************************************//
			
		function get_album_dir($id = NULL){
			global $wpdb;
			if( $id == NULL ){
				$id = $_GET['aid'];
			}
			$sql = "SELECT * FROM ".$this->options['albums']." WHERE album_id = ".$wpdb->escape($id);
			$r = $wpdb->get_row($sql);
			$options = get_option('photoxhibit');

			
			$this->cur_album_dir = get_bloginfo('wpurl').'/'.$options["options_path"].'/'.sanitize_title($r->album_name);
		}
			
		function get_upload_dir($id = NULL){
			global $wpdb;
			if( $id == NULL ){
				$id = $_GET['aid'];
			}
			$sql = "SELECT * FROM ".$this->options['albums']." WHERE album_id = ".$wpdb->escape($id);
			$r = $wpdb->get_row($sql);
			$options = get_option('photoxhibit');
			/*

			if (!is_dir(ABSPATH.$options["options_path"].'/'.sanitize_title($r->album_name))) {
				@mkdir(ABSPATH.$options["options_path"].'/'.sanitize_title($r->album_name),0777);
			}
			
			*/
			
			$this->cur_upload_dir = ABSPATH.$options["options_path"].'/'.sanitize_title($r->album_name);
			wp_mkdir_p($this->cur_upload_dir);
			$this->cur_album_dir = get_bloginfo('wpurl').'/'.$options["options_path"].'/'.sanitize_title($r->album_name);
		}
		
		function imageUpload(){
			global $wpdb;
			
			$endMessage = '';
			
			include('class.upload.php');
/*			
			if (isset($post["PHPSESSID"])) {
				session_id($post["PHPSESSID"]);
			}
			session_start();
*/
			$files = array();
			foreach ($_FILES['Filedata'] as $k => $l) {
				foreach ($l as $i => $v) {
					if (!array_key_exists($i, $files)){
						$files[$i] = array();
					}
					$files[$i][$k] = $v;
				}
			} 
			
			foreach( $files as $file ){
				
				if (!isset($file) || !is_uploaded_file($file["tmp_name"]) || $file["error"] != 0) {
					if( $_GET['do'] != "upload" ){
						header("HTTP/1.1 500 File Upload Error");
						if (isset($file)) {
							echo $file["error"];
						}		
						exit(0);
					}
				}
				else{
					$handle = new Upload($file);
					$options = get_option('photoxhibit');
	
				    // then we check if the file has been uploaded properly
				    // in its *temporary* location in the server (often, it is /tmp)
				    if ($handle->uploaded) {
						$this->get_upload_dir();
						
						if($options['options_original'] == 1){
							$handle->file_name_body_add = '_o';
							$handle->process($this->cur_upload_dir);
						}
						
						// yes, the file is on the server
						// below are some example settings which can be used if the uploaded file is an image.
						$handle->image_resize		= true;
						$handle->image_ratio        	= true;
						$handle->image_ratio_no_zoom_in = true;
						$handle->image_x              = $options["options_MaxWidth"];
						$handle->image_y              = $options["options_MaxHeight"];
						$handle->jpeg_quality		= $options["options_imageQuality"];
						$handle->process($this->cur_upload_dir);
						
						$file_dst_name_ext = $handle->file_dst_name_ext;
						$file_dst_name = $handle->file_dst_name_body;
	
						// we now process the image a second time, with some other settings
						$handle->image_resize    = true;
						$handle->image_ratio   = true;
						$handle->image_ratio_no_zoom_in = true;
						$handle->image_x              = $options["options_thumbailW"];
						$handle->image_y              = $options["options_thumbailH"];
						$handle->jpeg_quality		= $options["options_tnimageQuality"];
						$handle->file_new_name_body = $file_dst_name . '_tn';
						$handle->process($this->cur_upload_dir);
						
						
						$file_dst_name_body = $handle->file_dst_name_body;
						
						if( $options['options_thumbailSet'] == 1 ){
						
							$handle->image_resize    	= true;
							$handle->image_ratio   		= true;
							$handle->image_ratio_no_zoom_in = true;
							$handle->image_x              = $options["options_thumbailW2"];
							$handle->image_y              = $options["options_thumbailH2"];
							$handle->jpeg_quality		= $options["options_tnimageQuality"];
							$handle->file_new_name_body = $file_dst_name.'_ltn';
							$handle->process($this->cur_upload_dir);
						
						}
						// we delete the temporary files
						$handle->clean();
						
						if ($handle->processed) {
							$sql = "INSERT INTO ".$this->options['albumPhotos']." 
									(album_id,albumPhotos_file, albumPhotos_ext) VALUES (".$_GET['aid'].",'".$file_dst_name."','".$file_dst_name_ext."')";
							$wpdb->query($sql);
							$id = mysql_insert_id();
							
							$return = '{"albumPhotos_id":'.$id.', "albumPhotos_file":"'.$file_dst_name_body.'", "albumPhotos_ext":"'.$file_dst_name_ext.'", "path":"'.$this->cur_album_dir.'"}';
							$endMessage .= '<li>'.$file_dst_name.'.'.$file_dst_name_ext.'</li>';
						}
						else {
							$return = '{"error":"'.$handle->error.'"}';
						}
						if( $_GET['do'] != "upload" ){
							return $return;
							exit(0);
						}
	
					} else {
						// if we're here, the upload file failed for some reasons
						// i.e. the server didn't receive the file
						echo '<fieldset>';
						echo '  <legend>file not uploaded on the server</legend>';
						echo '  Error: ' . $handle->error . '';
						echo '</fieldset>';
					}
					unset($handle);
				}  //  end : else (!isset($file) || !is_uploaded_file($file["tmp_name"]) || $file["error"] != 0)
			} // end : foreach( $files as $file )

			if( $_GET['do'] == "upload" ){
				echo '<div class="wrap"><p>';
				_e('The following files have been uploaded with out issue:');
				echo '</p><ul>'.$endMessage . '</ul></div>';
			}
		}

	}  //  end : px
}  //  end : if(!class_exists("px"))
?>