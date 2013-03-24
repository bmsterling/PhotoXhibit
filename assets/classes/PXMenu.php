<?php

class PXMenu {
    var $base;
    
    function __construct ($base) {
        $this->base = $base;
        
        add_action('admin_menu', array(&$this, 'add_menu_page'));
    }
    
    public function add_menu_page () {
        if (function_exists('add_menu_page')) {
            add_menu_page('PhotoXhibit','PhotoXhibit', 7, "photoxhibit", array(&$this, 'landing'));
        }
        if (function_exists('add_submenu_page')) {
            // add_submenu_page($this->base, __('OverView', 'photoxhibit'), __('OverView', 'photoxhibit'), 7, $this->baseFile, array(&$this, 'adminOverView'));
            add_submenu_page("photoxhibit", __('All Galleries', 'photoxhibit'),   __('All Galleries', 'photoxhibit'), 7, "photoxhibit",      array(&$this, 'landing'));
            add_submenu_page("photoxhibit", __('Add New', 'photoxhibit'),         __('Add New', 'photoxhibit'),       7, 'photoxhibit-edit',     array(&$this, 'build'));
        
            // add_submenu_page($this->baseFile, __('Manage Album', 'photoxhibit'), __('Manage Album', 'photoxhibit'), 7, 'px_manageAlbum', array(&$this, 'adminManageAlbum'));

            add_submenu_page("photoxhibit", __('Settings', 'photoxhibit'),        __('Settings', 'photoxhibit'),      7, 'photoxhibit-settings', array(&$this, 'settings'));
            add_submenu_page("photoxhibit", __('About', 'photoxhibit'),           __('About', 'photoxhibit'),         7, 'photoxhibit-about',    array(&$this, 'about'));
        }
    }
    
    public function landing () {
        new PXLanding($this->base);
    }
    
    public function build () {
        $pxgallery = new PXGallery($this->base);
        
        $pxgallery->index();
    }
    
    public function settings () {
        new PXSettings($this->base);
    }
    
    public function about () {
        echo 'about';
    }
    
    
}