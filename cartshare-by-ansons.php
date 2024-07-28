<?php
/*
Plugin Name: CartShare by Ansons
Version: 1.3.6
Author: KC Cheng
Description: This plugin enables specific user roles, such as salespersons, to create carts for customers and send SMS notifications via ClickSend.
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define constants
define( 'CARTSHARE_VERSION', '1.3.3' );
define( 'CARTSHARE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CARTSHARE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include required files
require_once CARTSHARE_PLUGIN_DIR . 'includes/class-cartshare-settings.php';
require_once CARTSHARE_PLUGIN_DIR . 'includes/class-cartshare-sms.php';
require_once CARTSHARE_PLUGIN_DIR . 'includes/class-cartshare-order.php';
require_once CARTSHARE_PLUGIN_DIR . 'includes/class-cartshare-role.php';
require_once CARTSHARE_PLUGIN_DIR . 'includes/class-cartshare-create-cart.php';

// Activation hook
register_activation_hook( __FILE__, 'cartshare_activate' );
function cartshare_activate() {
    CartShare_Role::add_salesperson_role();
}

// Deactivation hook
register_deactivation_hook( __FILE__, 'cartshare_deactivate' );
function cartshare_deactivate() {
    CartShare_Role::remove_salesperson_role();
}

// Initialize the plugin
add_action( 'plugins_loaded', 'cartshare_init' );
function cartshare_init() {
    CartShare_Settings::init();
    CartShare_SMS::init();
    CartShare_Order::init();
    CartShare_Role::init();
    CartShare_Create_Cart::init();
}
