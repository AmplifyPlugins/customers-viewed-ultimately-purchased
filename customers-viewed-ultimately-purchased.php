<?php
	/*
	Plugin Name: Customers Viewed Ultimately Purchased
	Plugin URI: https://amplifyplugins.com
	Description: Display related products based on actual customer's purchasing behavior.
	Requires at least: 4.9.6
	Tested up to: 5.3.2
	Version: 1.0.0
	WC requires at least: 3.9.0
	WC tested up to: 3.9.0
	Author: Scott DeLuzio
	Author URI: https://amplifyplugins.com
	Text Domain: customers-viewed-ultimately-purchased
	*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'CVUP_PLUGIN_DIR', dirname( __FILE__ ) );

include( CVUP_PLUGIN_DIR . '/includes/settings.php' );

require_once( CVUP_PLUGIN_DIR . '/includes/privacy-information.php' );
require_once( CVUP_PLUGIN_DIR . '/includes/cookie-functions.php' );
require_once( CVUP_PLUGIN_DIR . '/includes/after-order.php' );
require_once( CVUP_PLUGIN_DIR . '/includes/single-product-display.php' );