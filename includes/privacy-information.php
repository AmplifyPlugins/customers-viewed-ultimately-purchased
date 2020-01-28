<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
function cvup_add_privacy_policy_content() {
	if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
		return;
	}

	$expires = get_option( 'wc_customers_viewed_ultimately_purchased_expire_cookie', WEEK_IN_SECONDS );

	$conversion = array(
		HOUR_IN_SECONDS		=> __( '1 Hour', 'customers-viewed-ultimately-purchased' ),
		12*HOUR_IN_SECONDS	=> __( '12 Hours', 'customers-viewed-ultimately-purchased' ),
		DAY_IN_SECONDS		=> __( '1 Day', 'customers-viewed-ultimately-purchased' ),
		3*DAY_IN_SECONDS	=> __( '3 Days', 'customers-viewed-ultimately-purchased' ),
		WEEK_IN_SECONDS		=> __( '1 Week', 'customers-viewed-ultimately-purchased' ),
		2*WEEK_IN_SECONDS	=> __( '2 Weeks', 'customers-viewed-ultimately-purchased' ),
		MONTH_IN_SECONDS	=> __( '1 Month', 'customers-viewed-ultimately-purchased' ),
		3*MONTH_IN_SECONDS	=> __( '3 Months', 'customers-viewed-ultimately-purchased' ),
		6*MONTH_IN_SECONDS	=> __( '6 Months', 'customers-viewed-ultimately-purchased' ),
		9*MONTH_IN_SECONDS	=> __( '9 Months', 'customers-viewed-ultimately-purchased' ),
		YEAR_IN_SECONDS		=> __( '1 Year', 'customers-viewed-ultimately-purchased' ),
		2*YEAR_IN_SECONDS	=> __( '2 Years', 'customers-viewed-ultimately-purchased' )
	);

	$content =sprintf(
		__( 'When customers visit WooCommerce single product pages on this site, a cookie will be set.
		That cookie is named `customers_viewed_ultimately_purchased`. That cookie collects a comma separated
		list of product ID numbers that the customer has viewed.

		After a purchase has been made, the plugin will retrieve the product ID numbers from the cookie. It then
		loops through each product in the customer\'s cart and adds a running tally of products that the customer
		has viewed to the product meta.

		The information that is stored in the product meta is an anonymous aggregate total of products that were
		viewed by customers before purchasing the product.

		The cookie will expire %s after it was set or updated unless a purchase was made. The cookie is automatically
		deleted from the customer\'s browser after a purchase is made.',
		'customers-viewed-ultimately-purchased' ),
		$conversion[$expires]
	);

	wp_add_privacy_policy_content(
		'Customers Viewed Ultimately Purchased',
		wp_kses_post( wpautop( $content, false ) )
	);
}
add_action( 'admin_init', 'cvup_add_privacy_policy_content' );


sprintf(
        __( 'When you leave a comment on this site, we send your name, email
        address, IP address and comment text to example.com. Example.com does
        not retain your personal data.

        The example.com privacy policy is <a href="%s" target="_blank">here</a>.',
        'my_plugin_textdomain' ),
        'https://example.com/privacy-policy'
    );