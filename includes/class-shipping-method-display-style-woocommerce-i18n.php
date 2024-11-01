<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://piwebsolution.com/shipping-method-display-style-woocommerce
 * @since      1.0.0
 *
 * @package    Shipping_Method_Display_Style_Woocommerce
 * @subpackage Shipping_Method_Display_Style_Woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Shipping_Method_Display_Style_Woocommerce
 * @subpackage Shipping_Method_Display_Style_Woocommerce/includes
 * @author     PI Websolution <sales@piwebsolution.com>
 */
class Pisol_Smdsw_Shipping_Method_Display_Style_Woocommerce_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'shipping-method-dropdown-for-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
