<?php

class PXModel {
    var $base;
    var $options;
    

    var $api_smugmug = '8vjhYpC7wz53UTdspu33yRaYXEPgrU5D';
    var $api_flickr = '99c12772538849fb2890645771d923f9';
        
    function __construct () {
        global $wpdb;

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
            'plugins_version' => "1.2"
        );
        $this->options = $options;
        unset($options);
    }
    
    public function get_galleries () {
        global $wpdb;
        
        $galleries = $this->options['galleries'];
        $plugins = $this->options['plugins'];
        
        $sql = "SELECT * FROM ".$galleries ."," . $plugins . " where " . $galleries .".plugin_id = " . $plugins . ".plugin_id";

        return $wpdb->get_results($sql);
    }
}