<?php

class PXLanding {
    var $base;
    var $path;
    
    function __construct ($base) {
        $this->base = $base;
        $this->path = plugin_dir_path($base);
        
        $pxmodel = new PXModel();
    
        $this->data = $pxmodel->get_galleries();
        
        $v = new PXView( $this->path . '/assets/views/galleries/landing.php');
        $fetch = $v->fetch(array( 'galleries' => $this->data ));
        
        print($fetch);
    }
}