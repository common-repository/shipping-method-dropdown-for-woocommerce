<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://piwebsolution.com/shipping-method-display-style-woocommerce
 * @since      1.0.0
 *
 * @package    Shipping_Method_Display_Style_Woocommerce
 * @subpackage Shipping_Method_Display_Style_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Shipping_Method_Display_Style_Woocommerce
 * @subpackage Shipping_Method_Display_Style_Woocommerce/admin
 * @author     PI Websolution <sales@piwebsolution.com>
 */
class Pisol_Smdsw_Shipping_Method_Display_Style_Woocommerce_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_filter('woocommerce_settings_tabs_array', array($this, 'add_setting_tab'), 70);

		add_action('woocommerce_settings_tabs_shipping_display_style', array($this, 'tab_content'));

		add_action('woocommerce_update_options_shipping_display_style', array($this, 'save_options'));

	}

	public function add_setting_tab($tabs) {

        $tabs['shipping_display_style'] = __('Shipping display style', 'shipping-method-dropdown-for-woocommerce');

        return $tabs;
    }

	public function tab_content() {
        if (!defined('ABSPATH')) {
            exit;
        }
        include_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/options-form.php';
    }

	public function save_options(){
		$smdsw_nonce  = sanitize_text_field($_POST['smdsw_nonce'] ?? '');

		if (!isset($smdsw_nonce) || !wp_verify_nonce($smdsw_nonce, 'pisol_smdsw')) {
			die('Failed security check');
		}

		$shipping_method_style  = sanitize_text_field($_POST['pisol_smdsw_shipping_method_style'] ?? '');

		$override_custom_theme_template  = sanitize_text_field($_POST['pisol_smdsw_override_custom_theme_template'] ?? '');

		$show_zero  = sanitize_text_field($_POST['pisol_smdsw_show_zero_for_free_shipping'] ?? '');

		$order = sanitize_text_field($_POST['pisol_smdsw_shipping_method_order'] ?? '');

		$single_shipping_option = sanitize_text_field($_POST['pisol_smdsw_single_shipping_option'] ?? '');

		$exclude_local_pickup = sanitize_text_field($_POST['pisol_smdsw_exclude_local_pickup_removal'] ?? '');

		if (!empty($shipping_method_style)) {
			update_option('pisol_smdsw_shipping_method_style', $shipping_method_style);
		}

		if (!empty($override_custom_theme_template)) {
			update_option('pisol_smdsw_override_custom_theme_template', 'yes');
		}else{
			update_option('pisol_smdsw_override_custom_theme_template', '');
		}

		if (!empty($show_zero)) {
			update_option('pisol_smdsw_show_zero_for_free_shipping', 'yes');
		}else{
			update_option('pisol_smdsw_show_zero_for_free_shipping', '');
		}

		if (!empty($order)) {
			update_option('pisol_smdsw_shipping_method_order', $order);
		}else{
			update_option('pisol_smdsw_shipping_method_order', '');
		}

		if (!empty($single_shipping_option)) {
			update_option('pisol_smdsw_single_shipping_option', $single_shipping_option);
		}else{
			update_option('pisol_smdsw_single_shipping_option', '');
		}

		if (!empty($exclude_local_pickup)) {
			update_option('pisol_smdsw_exclude_local_pickup_removal', 'yes');
		}else{
			update_option('pisol_smdsw_exclude_local_pickup_removal', '');
		}

		$disable_auto_selection = sanitize_text_field($_POST['pisol_smdsw_disable_auto_selection'] ?? '');
		if(!empty($disable_auto_selection)){
			update_option('pisol_smdsw_disable_auto_selection', 'yes');
		}else{
			update_option('pisol_smdsw_disable_auto_selection', '');
		}
	}
	/**
	 * Register the stylesheets for the admin area.
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

		if(isset($_GET['page']) && $_GET['page'] == 'wc-settings' && isset($_GET['tab']) && $_GET['tab'] == 'shipping_display_style'){
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/shipping-method-display-style-woocommerce-admin.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
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

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/shipping-method-display-style-woocommerce-admin.js', array( 'jquery' ), $this->version, false );

	}

}
