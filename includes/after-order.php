<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'woocommerce_thankyou', 'cvup_record_checkout' );
function cvup_record_checkout( $order_id ){
	// Get cookie data
	$cookie_products = cvup_get_cookie_data();
	// If the cookie is set and has data
	if( $cookie_products ){
		// Convert CSV string from cookie to array
		$cookie_products 	= explode( ',', $cookie_products );
		// Get WooCommerce order data
		$order				= wc_get_order( $order_id );
		// Get the line items from the order
		$line_items			= $order->get_items();
		// Loop through each line item
		foreach( $line_items as $item ){
			// Get the product id for the line item. We don't need variations or any other info for the product.
			$product_id			= $item->get_product_id();
			// Get the related products from the product meta data
			$related_products	= (array) get_post_meta( $product_id, '_cvup_related_products' );
			// Loop through each product from the cookie
			foreach( $cookie_products as $cookie ){
				if( array_key_exists( $cookie, $related_products ) ){
					// If the product from the cookie is already in the related products increase the count by 1
					$related_products[$cookie] = $related_products[$cookie] + 1;
				} else {
					// If not just set that product in the related products with a value of 1
					$related_products[$cookie] = 1;
				}
			}
			// Save the related products for the product
			update_post_meta( $product_id, '_cvup_related_products', $related_products );
		}
		// Unset cookie after purchase.
		cvup_set_customer_cookies( false );
	}
}