<?php
	/*
	Plugin Name: Customers Viewed Ultimately Purchased
	Plugin URI: https://amplifyplugins.com
	Description: Display related products based on actual customer's purchasing behavior.
	Requires at least: 3.3.0 // ***************************************************CHECK THIS
	Tested up to: 5.2.3
	Version: 1.0.0
	WC requires at least: 3.0.0 // ***************************************************CHECK THIS
	WC tested up to: 3.7.0 // ***************************************************CHECK THIS
	Author: Scott DeLuzio
	Author URI: https://amplifyplugins.com
	Text Domain: customers-viewed-ultimately-purchased
	*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'CVUP_PLUGIN', __FILE__ );
define( 'CVUP_PLUGIN_VERSION', '1.0.0' );
define( 'CVUP_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'CVUP_BASE_STORE_URL', 'http://amplifyplugins.com' );
// the name of your product. This should match the download name in EDD exactly
define( 'CVUP_PRODUCT_NAME', 'Customers Viewed Ultimately Purchased' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file
include( CVUP_PLUGIN_DIR . '/includes/settings.php' );

require_once( CVUP_PLUGIN_DIR . '/includes/cookie-functions.php' );
require_once( CVUP_PLUGIN_DIR . '/includes/after-order.php' );
require_once( CVUP_PLUGIN_DIR . '/includes/single-product-display.php' );