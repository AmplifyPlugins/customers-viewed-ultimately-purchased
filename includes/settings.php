<?php
/**
 * Customer Viewed Ultimately Purchased Admin Menu
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WC_Settings_Customer_Viewed_Purchased' ) ){
	class WC_Settings_Customer_Viewed_Purchased{
		public function __construct(){
			add_filter( 'woocommerce_get_sections_advanced', array( $this, 'add_advanced_settings_section_tab' ) );
			add_action( 'woocommerce_get_settings_advanced', array( $this, 'get_settings' ), 10, 2 );
		}

		public function add_advanced_settings_section_tab( $section ){
			$section['customers_viewed_ultimately_purchased'] = __( 'Customers viewed ultimately purchased', 'customers-viewed-ultimately-purchased' );

			return $section;
		}
		/**
		 * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
		 *
		 * @return array Array of settings for @see woocommerce_admin_fields() function.
		 */
		public static function get_settings( $settings, $current_section ) {
			if( 'customers_viewed_ultimately_purchased' == $current_section ){

				$settings = array(
					'section_title'	=> array(
						'name'	=> __( 'Customers Viewed Ultimately Purchased', 'customers-viewed-ultimately-purchased' ),
						'type'	=> 'title',
						'desc'	=> __( 'These settings will control the tracking cookie used in order to aggregate the required customer data.', 'customers-viewed-ultimately-purchased' ),
						'id'	=> 'wc_customers_viewed_ultimately_purchased_section_title'
					),
					'delay'			=> array(
						'name'		=> __( 'Expire cookie after', 'customers-viewed-ultimately-purchased' ),
						'type'		=> 'select',
						'desc'		=> __( 'Select how long after the tracking cookie has been set or updated that it should expire. Default is 1 week.', 'customers-viewed-ultimately-purchased' ),
						'default'	=> WEEK_IN_SECONDS,
						'options'	=> array(
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
							2*YEAR_IN_SECONDS	=> __( '2 Years', 'customers-viewed-ultimately-purchased' ),
						),
						'id'		=> 'wc_customers_viewed_ultimately_purchased_expire_cookie'
					),
					'section_end'	=> array(
						'type'		=> 'sectionend',
						'id'		=> 'wc_customers_viewed_ultimately_purchased_section_end'
					)
				);
			}
			return apply_filters( 'wc_customers_viewed_ultimately_purchased_settings', $settings );
		}
	}
	$GLOBAL['wc_customers_viewed_ultimately_purchased'] = new WC_Settings_Customer_Viewed_Purchased();
}