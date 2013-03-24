<?php

class PhotoXhibit {
    var $base;

    /**
     * Initializes the plugin by setting localization, filters, and administration functions.
     */
    function __construct ($base) {
        $this->base = $base;

        // Load plugin text domain
        add_action( 'init', array( $this, 'plugin_textdomain' ) );

        // Register admin styles and scripts
        add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

        // Register site styles and scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );
        
        add_action( 'init', array( $this, 'wp_ajax_' ) );

        // Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
        register_activation_hook( $this->base, array( $this, 'activate' ) );
        register_deactivation_hook( $this->base, array( $this, 'deactivate' ) );
        register_uninstall_hook( $this->base, array( 'PhotoXhibit', 'uninstall' ) );

        $this->add_actions();
        $this->add_filters();

    } // end constructor
    
    public function wp_ajax_() {
        $pxgallery = new PXGallery($this->base);
        add_action( 'wp_ajax_px_gallery', array($pxgallery, 'routeAjax') );
    }

    /**
     * Fired when the plugin is activated.
     *
     * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
     */
    public function activate( $network_wide ) {
        // TODO:	Define activation functionality here
    } // end activate

    /**
     * Fired when the plugin is deactivated.
     *
     * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
     */
    public function deactivate( $network_wide ) {
        // TODO:	Define deactivation functionality here		
    } // end deactivate

    /**
     * Fired when the plugin is uninstalled.
     *
     * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
     */
    public function uninstall( $network_wide ) {
        // TODO:	Define uninstall functionality here		
    } // end uninstall

    /**
     * Loads the plugin text domain for translation
     */
    public function plugin_textdomain() {

        // TODO: replace "plugin-name-locale" with a unique value for your plugin
        $domain = 'photoxhibit';
        $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
        load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
        load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

    } // end plugin_textdomain

    /**
     * Registers and enqueues admin-specific styles.
     */
    public function register_admin_styles($p) {
        // var_dump($p);
        // if (ereg('photoxhibit', $p)) {
        // TODO:	Change 'plugin-name' to the name of your plugin
        // wp_enqueue_style( 'plugin-name-admin-styles', plugins_url( 'plugin-name/css/admin.css' ) );

            // if (ereg('settings', $p)) {
                wp_enqueue_style( 'px-settings-base', plugins_url( 'photoxhibit/assets/css/base.css' ) );
                wp_enqueue_style( 'px-settings-ui-all', plugins_url( 'photoxhibit/assets/css/jquery.ui.all.css' ) );
            // }
        // }
    } // end register_admin_styles

    /**
     * Registers and enqueues admin-specific JavaScript.
     */	
    public function register_admin_scripts($p) {
        if (ereg('photoxhibit', $p)) {
            wp_enqueue_script( 'px-core-admin-script', plugins_url( 'photoxhibit/assets/js/core.js' ) );

            if (ereg('settings', $p)) {
                wp_enqueue_script( 'px-settings-admin-script', plugins_url( 'photoxhibit/assets/js/settings.js' ), array('jquery','jquery-ui-tabs') );
            }
        }
    } // end register_admin_scripts

    /**
     * Registers and enqueues plugin-specific styles.
     */
    public function register_plugin_styles() {

        // TODO:	Change 'plugin-name' to the name of your plugin
        // wp_enqueue_style( 'plugin-name-plugin-styles', plugins_url( 'plugin-name/css/display.css' ) );

    } // end register_plugin_styles

    /**
     * Registers and enqueues plugin-specific scripts.
     */
    public function register_plugin_scripts() {

        // TODO:	Change 'plugin-name' to the name of your plugin
        // wp_enqueue_script( 'plugin-name-plugin-script', plugins_url( 'plugin-name/js/display.js' ) );

    } // end register_plugin_scripts
    
    public function add_actions () {
        $this->menu = new PXMenu($this->base);
    }
    public function add_filters () {
    }
}