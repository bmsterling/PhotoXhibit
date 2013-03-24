<?php

class PXSettings {
    var $base;
    var $path;
    
    function __construct ($base) {
        $this->base = $base;
        $this->path = plugin_dir_path($base);
        
        $this->handlePost();
        
        $options = get_option('photoxhibit');
        $data = array();
        
        $v = new PXView( $this->path . '/assets/views/settings/basics.php');
        $basics = $v->fetch( $options );
        
        $v = new PXView( $this->path . '/assets/views/settings/services.php');
        $services = $v->fetch( $options );
        
        $v = new PXView( $this->path . '/assets/views/settings/flickr.php');
        $flickr = $v->fetch( $options );
        
        $v = new PXView( $this->path . '/assets/views/settings/smugmug.php');
        $smugmug = $v->fetch( $options );
        
        $v = new PXView( $this->path . '/assets/views/settings/smugmug.php');
        $smugmug = $v->fetch( $options );
        
        $v = new PXView( $this->path . '/assets/views/settings/album.php');
        $album = $v->fetch( $options );
        
        $data = array(
            'basics'   => $basics,
            'services' => $services,
            'flickr'   => $flickr,
            'smugmug'  => $smugmug,
            'album'    => $album
        );
        
        $v = new PXView( $this->path . '/assets/views/settings/base.php');
        $fetch = $v->fetch( $data );
        
        print($fetch);
    }
    
    private function handlePost () {
        if (!empty($_POST)) {

            $flickr_user_id = $_POST['flickr_user_id'];
            $flickr_api_key = $_POST['flickr_api_key'];
            $flickr_photoset_id = $_POST['flickr_photoset_id'];
            $picasa_user_id = $_POST['picasa_user_id'];
            $smugmug_api_key = $_POST['smugmug_api_key'];
            $smugmug_user_id = $_POST['smugmug_user_id'];
            
            
            $options = get_option('photoxhibit');
            $options['flickr_user_id'] = $flickr_user_id;
            $options['flickr_api_key'] = $flickr_api_key;
            $options['flickr_photoset_id'] = $flickr_photoset_id;
            $options['picasa_user_id'] = $picasa_user_id;
            $options['smugmug_api_key'] = $smugmug_api_key;
            $options['smugmug_user_id'] = $smugmug_user_id;
            $options["use_picasa"] = $_POST['use_picasa'];
            $options["use_flickr"] = $_POST['use_flickr'];
            $options["use_smugmug"] = $_POST['use_smugmug'];
            $options["use_album"] = $_POST['use_album'];
            $options["use_local"] = $_POST['use_local'];
            $options["use_browse"] = $_POST['use_browse'];
            
            $options["options_path"] = $_POST['options_path'];
            $options["options_delete"] = $_POST['options_delete'];
            
            $options["options_dropall"] = $_POST['options_dropall'];
            
            $options["options_MaxWidth"] = $_POST['options_MaxWidth'];
            $options["options_MaxHeight"] = $_POST['options_MaxHeight'];
            $options["options_imageQuality"] = $_POST['options_imageQuality'];
            
            $options["options_thumbailSet"] = $_POST['options_thumbailSet'];
            
            $options["options_thumbailW"] = $_POST['options_thumbailW'];
            $options["options_thumbailH"] = $_POST['options_thumbailH'];
            $options["options_thumbailW2"] = $_POST['options_thumbailW2'];
            $options["options_thumbailH2"] = $_POST['options_thumbailH2'];
            
            $options["options_tnimageQuality"] = $_POST['options_tnimageQuality'];
            $options["options_original"] = $_POST['options_original'];

            $options["use_effectSlide"] = $_POST['use_effectSlide'];
            $options["use_manager"] = $_POST['use_manager'];
            $options["flash_version_multi_upload"] = $_POST['flash_version_multi_upload'];
            $options["none_ajax_styles"] = $_POST['none_ajax_styles'];
            
            update_option('photoxhibit', $options);
        }
    }
}