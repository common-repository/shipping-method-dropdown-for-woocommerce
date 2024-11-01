<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://piwebsolution.com/shipping-method-display-style-woocommerce
 * @since      1.0.0
 *
 * @package    Shipping_Method_Display_Style_Woocommerce
 * @subpackage Shipping_Method_Display_Style_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Shipping_Method_Display_Style_Woocommerce
 * @subpackage Shipping_Method_Display_Style_Woocommerce/public
 * @author     PI Websolution <sales@piwebsolution.com>
 */
class Pisol_Smdsw_Shipping_Method_Display_Style_Woocommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_filter( 'woocommerce_locate_template', [$this,'load_template'], 5, 3 );

		add_filter( 'woocommerce_cart_shipping_method_full_label', [$this, 'change_label'], 10, 2 );

		add_filter('woocommerce_package_rates', [$this, 'order'], PHP_INT_MAX, 2);

		$disable_auto_selection = get_option('pisol_smdsw_disable_auto_selection', '');

		if($disable_auto_selection === 'yes'){
			add_filter('woocommerce_shipping_chosen_method', '__return_false', 99);
		}
	}

	public function load_template( $template, $template_name, $template_path ) {

		if( $template_name !== 'cart/cart-shipping.php' ) {
			return $template;
		}

		global $woocommerce;

		$_template = $template;

		if ( ! $template_path ) {
			$template_path = $woocommerce->template_url;
		}

		$plugin_path = untrailingslashit(PISOL_SPDSW_PATH) . '/woocommerce/';

		$template = locate_template(
			array(

				$template_path . $template_name,
				$template_name,
			)
		);

		// Modification: Get the template from this plugin, if it exists
		if ( get_option( 'pisol_smdsw_override_custom_theme_template', 'yes' ) === 'yes' ) {
			if ( file_exists( $plugin_path . $template_name ) ) {
				$template = $plugin_path . $template_name;
			}
		} else {
			if ( ! $template && file_exists( $plugin_path . $template_name ) ) {
				$template = $plugin_path . $template_name;
			}
		}

		// Use default template.
		if ( ! $template ) {
			$template = $_template;
		}
		// Return what we found
		return $template;
	}

	function change_label($label, $method){
		if( get_option( 'pisol_smdsw_show_zero_for_free_shipping', '' ) !== 'yes' ){
			return $label;
		}

		$label     = $method->get_label();

		if ( WC()->cart->display_prices_including_tax() ) {
			$label .= ': ' . wc_price( $method->cost + $method->get_shipping_tax() );
			if ( $method->get_shipping_tax() > 0 && ! wc_prices_include_tax() ) {
				$label .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
			}
		} else {
			$label .= ': ' . wc_price( $method->cost );
			if ( $method->get_shipping_tax() > 0 && wc_prices_include_tax() ) {
				$label .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
			}
		}

		return $label;
	}

	function order($rates, $package){

		
		$single_shipping_option = get_option('pisol_smdsw_single_shipping_option', '');

		$local_pickup = [];
		foreach($rates as $key => $rate){
			if(strpos($rate->method_id, 'local_pickup') !== false){
				$local_pickup[$key] = $rate;
			}
		}

		if (is_array($rates) && count($rates) > 1 && $single_shipping_option === 'cheapest-only') {
			// Find the cheapest shipping method
			$cheapest_rate = null;
			$cheapest_rate_id = null;
	
			foreach ($rates as $rate_id => $rate) {
				if ($cheapest_rate === null || $rate->cost < $cheapest_rate->cost) {
					$cheapest_rate = $rate;
					$cheapest_rate_id = $rate_id;
				}
			}
	
			// Keep only the cheapest shipping method in the array
			$rates = [$cheapest_rate_id => $cheapest_rate];

			if(!empty($local_pickup) && get_option('pisol_smdsw_exclude_local_pickup_removal', '') == 'yes'){
				$rates = array_merge($rates, $local_pickup);
			}
		}

		
		// Check if there are shipping rates
		if (is_array($rates) && count($rates) > 1  && $single_shipping_option === 'expensive-only') {
			// Find the most expensive shipping method
			$most_expensive_rate = null;
			$most_expensive_rate_id = null;
	
			foreach ($rates as $rate_id => $rate) {
				if ($most_expensive_rate === null || $rate->cost > $most_expensive_rate->cost) {
					$most_expensive_rate = $rate;
					$most_expensive_rate_id = $rate_id;
				}
			}
	
			// Keep only the most expensive shipping method in the array
			$rates = [$most_expensive_rate_id => $most_expensive_rate];

			if(!empty($local_pickup) && get_option('pisol_smdsw_exclude_local_pickup_removal', '') == 'yes'){
				$rates = array_merge($rates, $local_pickup);
			}
			
		}

		return $this->arrange_in_order($rates);
	}

	function arrange_in_order($rates){
		$order = get_option('pisol_smdsw_shipping_method_order', '');

		if (is_array($rates) && $order === 'asc') {
			// Sort shipping rates in ascending order based on cost
			uasort($rates, function ($a, $b) {
				return $a->cost - $b->cost;
			});
		}

		if (is_array($rates) && $order === 'desc') {	
			// Sort shipping rates in descending order based on cost
			uasort($rates, function ($a, $b) {
				return $b->cost - $a->cost;
			});
		}

		return $rates;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Shipping_Method_Display_Style_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Shipping_Method_Display_Style_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/shipping-method-display-style-woocommerce-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Shipping_Method_Display_Style_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Shipping_Method_Display_Style_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/shipping-method-display-style-woocommerce-public.js', array( 'jquery' ), $this->version, false );

	}

}
