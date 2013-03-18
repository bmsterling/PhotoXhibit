<?php
/*
    Plugin Name: PhotoXhibit
    Plugin URI: http://benjaminsterling.com/photoxhibit/
    Description: Set up gallery widgets using Picasa / Flickr / Wordpress and jQuery
    Author: Benjamin Sterling
    Version: 2.1.8
    Author URI: http://www.benjaminsterling.com

    Copyright (C)  2013 by Benjamin Sterling & PhotoXhibit Development Team

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/



header('Content-Type: text/html; charset=utf-8');
//error_reporting(E_USER_ERROR);
error_reporting(E_ERROR | E_USER_ERROR);


/**
 *	Set up an error handler
 */
set_error_handler ('PhotoXhibit_error_handler',E_ERROR | E_USER_ERROR);


/**
 *	Load WP-Config File If This File Is Called Directly
 */
if (!function_exists('add_action')) {
	require_once('../../../wp-config.php');
} //  end : if (!function_exists('add_action'))


/**
 *	Set up out WP Globals
 */
global $wp_version, $wpdb;

/**
 *	Check to make sure we are using a supported version of WP
 */
if ( version_compare($wp_version, '2.1', '<') ) {
    trigger_error(__('<b>PhotoXhibit only supports version 2.1 and up of WP</b>', 'photoxhibit'), E_USER_ERROR);
}  //  end : if ( version_compare($wp_version, '2.1', '<') )

/**
 *	Get the files we need
 */
require_once('common/inc/encode.php');
require_once('common/inc/px.php');
require_once('common/inc/px_photograbber.php');

$is_greater_than_2_5 = false;

$tmp = explode('.',$wp_version);

if( $tmp[0] == 2 && $tmp[1] >= 5 ){
	$is_greater_than_2_5 = true;
} 

// initiate px
if(class_exists("px")){
	global $px;
	$px = new px(__FILE__);
	$px->is_2_5 = $is_greater_than_2_5;
}

// initiate px_photograbber
if(class_exists("px_photograbber")){
	global $px_photograbber;
	$px_photograbber = new px_photograbber(__FILE__);
	$px_photograbber->is_2_5 = $is_greater_than_2_5;
}

/**
 * load language file
 */
function px_init(){
	load_plugin_textdomain('photoxhibit','wp-content/plugins/' . $px->dirName.'/lang');
}

add_action('init', 'px_init');

add_filter('the_content',	'put_photoxhibit');
add_filter('the_content_rss',	'put_photoxhibit');

add_filter('the_excerpt', 	'put_photoxhibit');
add_filter('the_excerpt_rss', 'put_photoxhibit');


if(!function_exists('photoxhibit')) {
	function photoxhibit($gallery_id=0, $r = false, $js = true){

		global $px;
		$px = new px(__FILE__);
		if($gallery_id == 0){
			return;
		}
		
		return $px->build_image_set($gallery_id, $r, $js);
	}
}
if(!function_exists('put_photoxhibit')) {
	function put_photoxhibit($content = NULL){
		$return = '';
		/*if(is_category() || is_archive()){
			return preg_replace("/\[photoxhibit=(\d+)\]/ise", "", $content);
		}*/

		if(is_feed()){
			$return = preg_replace("/\[photoxhibit=(\d+)\]/ise", "photoxhibit('\\1',false, false)", $content);
		}
		else{
			$return = preg_replace("/\[photoxhibit=(\d+)\]/ise", "photoxhibit('\\1',true)", $content);
		}
		return $return;
	}
}
/*

				$r = $wpdb->get_results(" SELECT * FROM ".$wpdb->prefix."posts WHERE post_type = 'attachment' AND (post_mime_type = 'image/jpeg' OR post_mime_type = 'image/gif' OR post_mime_type = 'image/png')");
				
		$max_width = intval(get_option('thumbnail_size_w'));
		$max_height = intval(get_option('thumbnail_size_h'));
				$a = array();
				//guid post_content post_content post_title

ini_set ("display_errors", "1");
error_reporting(E_ALL);  
echo '<pre>';
foreach($r as $x => $y){
	$img =  array_pop(explode('/',$y->guid) ) . "\n";
	$tmp = wp_upload_dir($y->post_date);
	//echo $tmp['path'] . '/' . $img;
	$t = (string) str_replace("\\",'/',$tmp['path']) . '/' . $img;
	echo $t;
	//$t = "H:/Inetpub/wwwroot/kenzomedia/benjaminsterling/www/wp-content/uploads/2008/02/zip.png";
	if( file_exists("$t") ){
		echo "yes\n\n";
	}
}
echo '</pre>';

echo '-------';
*/

switch($_GET['option']){
	case 'getphpinfo':
		phpinfo();
		exit(0);
		break;
	case 'js':
		$px->print_js($_GET['js']);
		break;
	case 'css':
		$px->print_css($_GET['gid']);
		break;
	case 'doAlbum':
		$px->get_set_album($_GET);
		break;
	case 'optionsSet':
		$flickr_user_id = $_GET['flickr_user_id'];
		$flickr_api_key = $_GET['flickr_api_key'];
		$flickr_photoset_id = $_GET['flickr_photoset_id'];
		$picasa_user_id = $_GET['picasa_user_id'];
		$smugmug_api_key = $_GET['smugmug_api_key'];
		$smugmug_user_id = $_GET['smugmug_user_id'];
		
		
		$options = get_option('photoxhibit');
		$options['flickr_user_id'] = $flickr_user_id;
		$options['flickr_api_key'] = $flickr_api_key;
		$options['flickr_photoset_id'] = $flickr_photoset_id;
		$options['picasa_user_id'] = $picasa_user_id;
		$options['smugmug_api_key'] = $smugmug_api_key;
		$options['smugmug_user_id'] = $smugmug_user_id;
		$options["use_picasa"] = $_GET['use_picasa'];
		$options["use_flickr"] = $_GET['use_flickr'];
		$options["use_smugmug"] = $_GET['use_smugmug'];
		$options["use_album"] = $_GET['use_album'];
		$options["use_local"] = $_GET['use_local'];
		$options["use_browse"] = $_GET['use_browse'];
		
		$options["options_path"] = $_GET['options_path'];
		$options["options_delete"] = $_GET['options_delete'];
		
		$options["options_dropall"] = $_GET['options_dropall'];
		
		$options["options_MaxWidth"] = $_GET['options_MaxWidth'];
		$options["options_MaxHeight"] = $_GET['options_MaxHeight'];
		$options["options_imageQuality"] = $_GET['options_imageQuality'];
		
		$options["options_thumbailSet"] = $_GET['options_thumbailSet'];
		
		$options["options_thumbailW"] = $_GET['options_thumbailW'];
		$options["options_thumbailH"] = $_GET['options_thumbailH'];
		$options["options_thumbailW2"] = $_GET['options_thumbailW2'];
		$options["options_thumbailH2"] = $_GET['options_thumbailH2'];
		
		$options["options_tnimageQuality"] = $_GET['options_tnimageQuality'];
		$options["options_original"] = $_GET['options_original'];

		$options["use_effectSlide"] = $_GET['use_effectSlide'];
		$options["use_manager"] = $_GET['use_manager'];
		$options["flash_version_multi_upload"] = $_GET['flash_version_multi_upload'];
		$options["none_ajax_styles"] = $_GET['none_ajax_styles'];
		
		

		update_option('photoxhibit', $options);
		break;
	case 'getAlbum':
		echo $px->get_album_json($_GET['url']);
		break;
	case 'getAlbumListSmugMug':
		echo $px->get_albumListSmugMug_json($_GET['api'],$_GET['un']);
		break;
	case 'getPhotos':
		switch($_GET['service']){
			case 'picasa':
			case 'flickr':
			case 'smugmugA':
				echo $px->get_album_json($_GET['url']);
				break;
			case 'smugmug':
				echo $px->get_album_json_special($_GET['url']);
				break;
			case 'locally':
				$r = $wpdb->get_results(" SELECT * FROM ".$wpdb->prefix."posts WHERE post_type = 'attachment' AND (post_mime_type = 'image/jpeg' OR post_mime_type = 'image/gif' OR post_mime_type = 'image/png')");
				/*
		$max_width = intval(get_option('thumbnail_size_w'));
		$max_height = intval(get_option('thumbnail_size_h'));
				$a = array();
				//guid post_content post_content post_title
				foreach($r as $x => $y){
					echo $y;//wp_upload_dir($y['post_date']);
				}
				*/
				
				if (!extension_loaded('json')){
					include('common/inc/JSON.php');
					$json = new JSON;
					echo $_GET['callback'].'('.$json->serialize($r).');';
				}
				else{
					echo $_GET['callback'].'('.json_encode($r).');';
				}
				break;
			case 'browse':
				$r = $px->getImagesFromDir($_GET['url'],true);
				if (!extension_loaded('json')){
					include('common/inc/JSON.php');
					$json = new JSON;
					echo $json->serialize($r);
				}
				else{
					echo json_encode($r);
				}
				break;
			case 'album':
				$r = $px->get_photos_from_album($_GET['url']);
				header('Content-type: application/javascript');
				if(0!=count($r)){
					if (!extension_loaded('json')){
						include('common/inc/JSON.php');
						$json = new JSON;
						echo $_GET['callback'].'('.$json->serialize($r).');';
					}
					else{
						echo $_GET['callback'].'('.json_encode($r).');';
					}
				}
				else{
					echo $_GET['callback'].'({"result":"noimage","msg":"No Images in this album"})';
				}
				break;
				
			default:
				echo '{"result":"error","msg":"No Service Provided"}';
		}
		break;
	case 'edit_styles':
		$px->print_js('edit_styles');
		break;
	case 'upload':
		echo $px->imageUpload();
		break;
	case 'edit_image_form':
		$px->edit_image_form();
		break;
	case 'edit_image_single':
		$px->edit_image_single();
		break;
	case 'delete_image':
		$px->delete_image();
		break;
	case 'update_photos':
		echo $px->update_photos();
		break;
	case 'update':
		$px_core = new px_core();
		$px_core->update();
		break;
}
switch($_POST['option']){
	case 'processGallery':
		echo $px->processGallery($_POST);//'{"answer":"done"}';
		exit(0);
		break;
	case 'update_styles':
		echo $px->update_styles();
		break;
}

/**
 *	@name PhotoXhibit_error_handler
 *	@desc Handles users_errors that are triggered
 */
function PhotoXhibit_error_handler ($errno, $errstr, $errfile, $errline) {
	if($errno == E_USER_ERROR){
		header('FirePHP-Data: [');
		header('FirePHP-Data-1: {"Error":"'.$errno.'"},');
		header('FirePHP-Data-2: {"Line":"'.$errline.'"},');
		header('FirePHP-Data-3: {"File":"'.$errfile.'"},');
		header('FirePHP-Data-4: {"String":"'.$errstr.'"}');
		header('FirePHP-Data-5: ]');
		echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
		echo "  Fatal error on line $errline in file $errfile";
		echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
		echo "Aborting...<br />\n";
		exit(0);
	}
	else{
		echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
		echo "  Fatal error on line $errline in file $errfile";
		echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
		echo "Aborting...<br />\n";
		exit(1);
	}
	//print "I am the user error message"; // Shown on  screen
}
?>
