<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * WooCommerce sets the related products in a transient to avoid duplicate database queries.
 * This filter will update the related products once the related products transient for a particular product expires.
 * By default, WooCommerce expires the transient once per day, so it may take a full day for the transient to update with the correct products.
 * To see the products that currently have a related product transient set:
 *  - Install the Transients Manager plugin https://wordpress.org/plugins/transients-manager/
 *  - Navigate to Tools > Transients
 *  - Search for wc_related_
 *  - The number after wc_related_ will indicate the product id that the transient is set for
 *  - You can easily delete individual transients or all transients in bulk with this plugin
 *  - To get this plugin's related products displaying right away, delete all wc_related_[product_id] transients
 */
add_filter( 'woocommerce_product_related_posts_query', 'cvup_related_products', 99, 3 );
function cvup_related_products( $query, $product_id, $args ){
	global $product, $wpdb;
	$related_products = get_post_meta( $product->get_id(), '_cvup_related_products' );
	if( $related_products ){
		$limit			= apply_filters( 'cvup_related_product_count', 10 );
		$related		= '';
		foreach( $related_products[0] as $id => $qty ){
			$related .= $id . ',';
		}
		// Remove the trailing comma
		$related = rtrim( $related, ',' );
		$query = array(
			'fields' => "
				SELECT DISTINCT ID FROM {$wpdb->posts} p
			",
			'join'   => '',
			'where'  => "
				WHERE 1=1
				AND p.post_status = 'publish'
				AND p.post_type = 'product'
				AND p.ID IN( " . $related . " )
			"
		);
	}
	return $query;
}

/**
 * Modifies the default "Related Products" heading on WooCommerce product pages.
 * Requires WooCommerce 3.9+ and a theme that does not override this filter with static text.
 */
add_filter( 'woocommerce_product_related_products_heading', 'cvup_relate_products_heading' );
function cvup_relate_products_heading(){
	return 'Customers who viewed this product ultimately purchased';
}