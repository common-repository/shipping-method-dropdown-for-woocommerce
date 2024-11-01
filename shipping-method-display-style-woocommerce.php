<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://piwebsolution.com/shop
 * @since             1.0.30
 * @package           Shipping_Method_Display_Style_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Shipping method dropdown for WooCommerce
 * Plugin URI:        https://piwebsolution.com
 * Description:       This plugin allows you to change the display style of the woocommerce shipping method on the cart and checkout page and various form
 * Version:           1.0.30
 * Author:            PI Websolution
 * Author URI:        https://www.piwebsolution.com/shop/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shipping-method-dropdown-for-woocommerce 
 * Domain Path:       /languages
 * WC tested up to: 9.3.3
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if(!is_plugin_active( 'woocommerce/woocommerce.php')){
    function pisol_smdsw_error_notice() {
        ?>
        <div class="error notice">
            <p><?php esc_html_e( 'Please Install and Activate WooCommerce plugin, without that this plugin can\'t work', 'shipping-method-dropdown-for-woocommerce' ); ?></p>
        </div>
        <?php
    }
    add_action( 'admin_notices', 'pisol_smdsw_error_notice' );
    return;
}

/**
 * Currently plugin version.
 * Start at version 1.0.30 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PISOL_SPDSW_SHIPPING_METHOD_DISPLAY_STYLE_WOOCOMMERCE_VERSION', '1.0.30' );
define( 'PISOL_SPDSW_PATH', plugin_dir_path( __FILE__ ) );


require_once plugin_dir_path( __FILE__ ) . 'autoloader.php';

/**
 * Declare compatible with HPOS new order table 
 */
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-shipping-method-display-style-woocommerce-activator.php
 */
function pisol_smdsw_activate_shipping_method_display_style_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shipping-method-display-style-woocommerce-activator.php';
	Pisol_Smdsw_Shipping_Method_Display_Style_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-shipping-method-display-style-woocommerce-deactivator.php
 */
function pisol_smdsw_deactivate_shipping_method_display_style_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shipping-method-display-style-woocommerce-deactivator.php';
	Pisol_Smdsw_Shipping_Method_Display_Style_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'pisol_smdsw_activate_shipping_method_display_style_woocommerce' );
register_deactivation_hook( __FILE__, 'pisol_smdsw_deactivate_shipping_method_display_style_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-shipping-method-display-style-woocommerce.php';

add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ),  function ( $links ) {
    $links = array_merge( array(
        '<a href="' . esc_url( admin_url( '/admin.php?page=wc-settings&tab=shipping_display_style' ) ) . '">' . __( 'Settings', 'shipping-method-dropdown-for-woocommerce ' ) . '</a>',
        '<a style="color:#0a9a3e; font-weight:bold;" target="_blank" href="https://wordpress.org/support/plugin/shipping-method-dropdown-for-woocommerce/reviews/#bbp_topic_content">' . __( 'GIVE YOUR SUGGESTION','shipping-method-dropdown-for-woocommerce ' ) . '</a>'
    ), $links );
    return $links;
} );



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.30
 */
function pisol_smdsw_run_shipping_method_display_style_woocommerce() {

	$plugin = new Pisol_Smdsw_Shipping_Method_Display_Style_Woocommerce();
	$plugin->run();

}
pisol_smdsw_run_shipping_method_display_style_woocommerce();
