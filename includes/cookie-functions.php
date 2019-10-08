<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'wp', 'cvup_maybe_set_cookies', 99 );
function cvup_maybe_set_cookies(){

	if ( ! headers_sent() && did_action( 'wp_loaded' ) ) {
		cvup_set_customer_cookies( true );
	}

}

function cvup_get_cookie_data( $name = 'customers_viewed_ultimately_purchased' ){
	$cookie = false;
	if( isset( $_COOKIE[$name] ) ){
		$cookie = $_COOKIE[$name];
	}
	return $cookie;
}

function cvup_set_customer_cookies( $set = true ){
	global $post;
	/**
	 * We don't want to run this on admin pages.
	 * We only want it to run on WooCommerce single product pages.
	 */
	if( is_admin() || !is_product() ){
		return;
	}

	if( $set ){
		/**
		 * Set or update the cookie with new product information.
		 */
		$name	= 'customers_viewed_ultimately_purchased';
		$data 	= cvup_get_cookie_data( $name );
		if( $data ){
			$cookie = explode( ',', $data );
			if( !in_array( $post->ID, $cookie ) ){
				$value = $data . ',' . (int)$post->ID;
			} else {
				$value = $data;
			}
		} else {
			$value = $post->ID;
		}
		$expire_length = get_option( 'wc_customers_viewed_ultimately_purchased_expire_cookie' ) ? get_option( 'wc_customers_viewed_ultimately_purchased_expire_cookie' ) : WEEK_IN_SECONDS;
		// Sets the time from right now that the cookie should expire.
		$expire	= apply_filters( 'cvup_set_cookie_expire', time() + $expire_length );
		wc_setcookie( $name, $value, $expire );
	} else {
		$name	= 'customers_viewed_ultimately_purchased';
		$value	= 0;
		$expire	= time() - YEAR_IN_SECONDS;
		wc_setcookie( $name, $value, $expire );
	}
}