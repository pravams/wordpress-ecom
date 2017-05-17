<?php 
/* 
Plugin Name: Pravams Ecommerce Plugin 
Description: Ecommerce plugin for purchasing products using Wordpress Version: 1.0 
Author: Prashant Vaibhav Mishra
URI: https://pravams.com/ License: GPLv2 or later 
*/ 

define( 'PRAVAMS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PRAVAMS_PLUGIN_URL', 'ecommerce' );

register_activation_hook(__FILE__, array( 'Setup', 'pravams_ecom_activation' ));

register_deactivation_hook(__FILE__, array( 'Setup', 'pravams_ecom_deactivation' ));

require_once( PRAVAMS_PLUGIN_DIR . 'class.data.php' );
require_once( PRAVAMS_PLUGIN_DIR . 'class.setup.php' );
require_once( PRAVAMS_PLUGIN_DIR . 'class.ecom.php' );
require_once( PRAVAMS_PLUGIN_DIR . 'class.admin.php' );
require_once( PRAVAMS_PLUGIN_DIR . 'class.shippingmethod.php' );
require_once( PRAVAMS_PLUGIN_DIR . 'class.paymentmethod.php' );
require_once( PRAVAMS_PLUGIN_DIR . 'class.product.php' );
require_once( PRAVAMS_PLUGIN_DIR . 'class.checkout.php' );
require_once( PRAVAMS_PLUGIN_DIR . 'class.checkoutsession.php' );


add_action( 'init', array( 'Product', 'init' ) );
add_action( 'init', array( 'Checkout', 'init' ) );
add_action( 'init', array( 'Admin', 'init' ) );

?>