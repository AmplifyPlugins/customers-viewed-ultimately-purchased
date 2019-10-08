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
			add_action( 'admin_init', array( $this, 'activate_license' ) );
			add_action( 'admin_init', array( $this, 'deactivate_license' ) );
			add_action( 'admin_init', array( $this, 'plugin_updater' ) );
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
					'license'		=> array(
						'name'		=> __( 'License key', 'customers-viewed-ultimately-purchased' ),
						'type'		=> 'text',
						'desc'		=> 'valid' == get_option( 'cvup_license_key_active' ) ? __( 'Your license is active.', 'customers-viewed-ultimately-purchased' ) : __( 'Enter your license key', 'customers-viewed-ultimately-purchased' ),
						'id'		=> 'wc_customers_viewed_ultimately_purchased_license'
					),
					'section_end'	=> array(
						'type'		=> 'sectionend',
						'id'		=> 'wc_customers_viewed_ultimately_purchased_section_end'
					)
				);
				/**
				 * Add in deactivate license option.
				 */
				$license = get_option( 'cvup_license_key_active' );
				if ( 'valid' == $license ){
					$license_field['deactivate_license'] = array(
						'name'	=> __( 'Deactivate license', 'customers-viewed-ultimately-purchased' ),
						'type'	=> 'checkbox',
						'desc'	=> __( 'Check this box, then click save changes to deactivate your license key. You may also want to delete your license key above.', 'customers-viewed-ultimately-purchased' ),
						'id'	=> 'wc_customers_viewed_ultimately_purchased_deactivate_license'
					);
					array_splice( $settings, 3, 0, $license_field );
				}
			}
			return apply_filters( 'wc_customers_viewed_ultimately_purchased_settings', $settings );
		}


		public static function activate_license() {

			if ( ! isset( $_POST['wc_customers_viewed_ultimately_purchased_license'] ) )
				return;

			if ( get_option( 'cvup_license_key_active' ) == 'valid' )
				return;

			$license = sanitize_text_field( $_POST['wc_customers_viewed_ultimately_purchased_license'] );

			// data to send in our API request
			$api_params = array(
				'edd_action'=> 'activate_license',
				'license'   => $license,
				'item_name' => urlencode( CVUP_PRODUCT_NAME ), // the name of our product in EDD
				'url'       => home_url()
			);

			// Call the custom API.

			$response = wp_remote_get( add_query_arg( $api_params, CVUP_BASE_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

			// make sure the response came back okay
			if ( is_wp_error( $response ) )
				return false;

			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			update_option( 'cvup_license_key_active', $license_data->license );

		}

		public static function deactivate_license() {
			// listen for our activate button to be clicked
			if( isset( $_POST['wc_customers_viewed_ultimately_purchased_deactivate_license'] ) ) {

				// retrieve the license from the database
				$key = get_option( 'wc_customers_viewed_ultimately_purchased_license' );
				$license = isset( $key ) ? trim( $key ) : '';


				// data to send in our API request
				$api_params = array(
					'edd_action'=> 'deactivate_license',
					'license'   => $license,
					'item_name' => urlencode( CVUP_PRODUCT_NAME ), // the name of our product in EDD
					'url'       => home_url()
				);

				// Call the custom API.
				$response = wp_remote_get( add_query_arg( $api_params, CVUP_BASE_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

				// make sure the response came back okay
				if ( is_wp_error( $response ) )
					return false;

				// decode the license data
				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				// $license_data->license will be either "deactivated" or "failed"
				if( $license_data->license == 'deactivated' ){
					delete_option( 'cvup_license_key_active' );
					delete_option( 'wc_customers_viewed_ultimately_purchased_deactivate_license' );
				}

			}
		}


		public static function plugin_updater() {

			if ( !class_exists( 'CVUP_Plugin_Updater' ) ) {
				// load our custom updater
				include dirname( CVUP_PLUGIN ) . '/EDD_SL_Plugin_Updater.php';
			}
			// retrieve our license key from the DB
			$key = get_option( 'wc_customers_viewed_ultimately_purchased_license' );
			$license_key = isset( $key ) ? trim( $key ) : '';

			if( empty( $cwus_license_key ))
				return;

			// setup the updater
			$updater = new CVUP_Plugin_Updater( CVUP_BASE_STORE_URL, CVUP_PLUGIN, array(
					'version'   => CVUP_PLUGIN_VERSION,   // current version number
					'license'   => $license_key, // license key (used get_option above to retrieve from DB)
					'item_name' => CVUP_PRODUCT_NAME, // name of this plugin
					'author'    => 'Scott DeLuzio',  // author of this plugin
				)
			);

		}

	}
	$GLOBAL['wc_customers_viewed_ultimately_purchased'] = new WC_Settings_Customer_Viewed_Purchased();
}