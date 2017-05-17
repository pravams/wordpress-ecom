<?php

class Admin{
    private static $initiated = false;
    
    public static function init(){
        if(!self::$initiated){
            self::init_hooks();
        }
    }
    
    /*
     * Initialize Wordpress Hooks
     */
    private static function init_hooks(){
        self::$initiated = true;
        
        add_action('admin_menu', array('Admin', 'pravams_plugin_settings'));
    }
    
    public static function pravams_plugin_settings(){
        add_menu_page('Ecommerce Settings', 'Ecommerce Settings', 'administrator', 'ecommerce_settings', array('Admin', 'ecommerce_plugin_settings'));
    }
    
    public static function ecommerce_plugin_settings(){
        $html = Ecom::view('admin_settings', array() );;
        
        echo $html;
    }
}
