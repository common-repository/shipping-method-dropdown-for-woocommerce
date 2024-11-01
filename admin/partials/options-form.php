<?php

if ( ! defined( 'ABSPATH' ) ) exit;

$shipping_method_style = get_option('pisol_smdsw_shipping_method_style', 'select');
$override_custom_theme_template = get_option('pisol_smdsw_override_custom_theme_template', 'yes');
$show_zero = get_option('pisol_smdsw_show_zero_for_free_shipping', 'yes');
$order = get_option('pisol_smdsw_shipping_method_order', '');
$single_shipping_option = get_option('pisol_smdsw_single_shipping_option', '');
$exclude_local_pickup = get_option('pisol_smdsw_exclude_local_pickup_removal', 'yes');
$disable_auto_selection = get_option('pisol_smdsw_disable_auto_selection', '');

?>
<h3><?php esc_html_e('Shipping Method Style', 'shipping-method-dropdown-for-woocommerce'); ?></h3>
<div class="pi-container">
<div class="pi-col1">
<table class="form-table">
    <?php wp_nonce_field('pisol_smdsw', 'smdsw_nonce'); ?>
    <tr>
        <th scope="row" class="titledesc">
            <label for="pisol_smdsw_shipping_method_style"><?php esc_html_e('Select Display Style', 'shipping-method-dropdown-for-woocommerce'); ?><span class="woocommerce-help-tip" data-tip="<?php esc_attr_e('Display shipping methods as Radio buttons or Dropdowns', 'shipping-method-dropdown-for-woocommerce'); ?>"></span></label>
        </th>
        <td class="forminp forminp-radio">
            <fieldset>
                <ul>
                    <li>
                        <label><input name="pisol_smdsw_shipping_method_style" value="radio" type="radio" <?php checked('radio', $shipping_method_style); ?>>
                            <span><?php esc_html_e('Display shipping methods with "radio" buttons', 'shipping-method-dropdown-for-woocommerce'); ?></span>
                        </label>
                    </li>
                    <li>
                        <label><input name="pisol_smdsw_shipping_method_style" value="select" type="radio" <?php checked('select', $shipping_method_style); ?>>
                            <span><?php esc_html_e('Display shipping methods in a dropdown', 'shipping-method-dropdown-for-woocommerce'); ?></span>
                        </label>
                    </li>
                </ul>
            </fieldset>
        </td>
    </tr>

    <tr>
        <th scope="row" class="titledesc">
            <label for="pisol_smdsw_shipping_method_style"><?php esc_html_e('Force user to select a shipping method of his chose', 'shipping-method-dropdown-for-woocommerce'); ?><span class="woocommerce-help-tip" data-tip="<?php esc_attr_e('No shipping method will be selected by default, so user has to select a shipping method of his choice by himself', 'shipping-method-dropdown-for-woocommerce'); ?>"></span></label>
        </th>
        <td class="forminp forminp-radio">
            <fieldset>
                <label><input name="pisol_smdsw_disable_auto_selection" value="yes" type="checkbox" <?php checked('yes', $disable_auto_selection); ?>>
                        <span><?php esc_html_e('Do not auto select shipping method', 'shipping-method-dropdown-for-woocommerce'); ?></span>
                </label>
            </fieldset>
        </td>
    </tr>

    <tr>
        <th scope="row" class="titledesc">
            <label for="pisol_smdsw_override_custom_theme_template"><?php esc_html_e('Over write theme cart template', 'shipping-method-dropdown-for-woocommerce'); ?><span class="woocommerce-help-tip" data-tip="<?php esc_attr_e('If you are not seeing dropdown in that case enable this option to overwrite theme cart template', 'shipping-method-dropdown-for-woocommerce'); ?>"></span></label>
        </th>
        <td class="forminp forminp-radio">
            <fieldset>
                <label><input name="pisol_smdsw_override_custom_theme_template" value="yes" type="checkbox" <?php checked('yes', $override_custom_theme_template); ?>>
                    <span><?php esc_html_e('If your theme overwrite cart template then enable this option', 'shipping-method-dropdown-for-woocommerce'); ?></span>
                </label>
            </fieldset>
        </td>
    </tr>
    <tr>
        <th scope="row" class="titledesc">
            <label for="pisol_smdsw_show_zero_for_free_shipping"><?php esc_html_e('Show zero behind free shipping method', 'shipping-method-dropdown-for-woocommerce'); ?><span class="woocommerce-help-tip" data-tip="<?php esc_attr_e('WooCommerce only show the shipping method name if it is free shipping, if you enable this option then it will show the "Free shipping: $0" after the free shipping name so user can understand it is free shipping ', 'shipping-method-display-style-woocommerce'); ?>"></span></label>
        </th>
        <td class="forminp forminp-radio">
            <fieldset>
                <label><input name="pisol_smdsw_show_zero_for_free_shipping" value="yes" type="checkbox" <?php checked('yes', $show_zero); ?>>
                    <span><?php esc_html_e('Show 0 cost behind the Free shipping method ', 'shipping-method-dropdown-for-woocommerce'); ?></span>
                </label>
            </fieldset>
        </td>
    </tr>
    <tr>
        <th scope="row" class="titledesc">
            <label for="pisol_smdsw_shipping_method_order"><?php esc_html_e('Arrange shipping method', 'shipping-method-dropdown-for-woocommerce'); ?><span class="woocommerce-help-tip" data-tip="<?php esc_attr_e('Show shipping method in ascending or descending order', 'shipping-method-dropdown-for-woocommerce'); ?>"></span></label>
        </th>
        <td class="forminp forminp-radio">
            <fieldset>
                <select name="pisol_smdsw_shipping_method_order" id="pisol_smdsw_shipping_method_order">
                    <option value="" <?php selected('', $order); ?>><?php esc_html_e('Original order', 'shipping-method-dropdown-for-woocommerce'); ?></option>
                    <option value="asc" <?php selected('asc', $order); ?>><?php esc_html_e('Ascending order (cheapest one selected by default)', 'shipping-method-dropdown-for-woocommerce'); ?></option>
                    <option value="desc" <?php selected('desc', $order); ?>><?php esc_html_e('Descending order (expensive one selected by default)', 'shipping-method-dropdown-for-woocommerce'); ?></option>
                </select>
            </fieldset>
        </td>
    </tr>

    <tr>
        <th scope="row" class="titledesc">
            <label for="pisol_smdsw_single_shipping_option"><?php esc_html_e('Show single shipping option', 'shipping-method-dropdown-for-woocommerce'); ?><span class="woocommerce-help-tip" data-tip="<?php esc_attr_e('Show only single shipping option cheapest or the the most expensive one', 'shipping-method-dropdown-for-woocommerce'); ?>"></span></label>
        </th>
        <td class="forminp forminp-radio">
            <fieldset>
                <select name="pisol_smdsw_single_shipping_option" id="pisol_smdsw_single_shipping_option">
                    <option value="" <?php selected('', $single_shipping_option); ?>><?php esc_html_e('All options', 'shipping-method-dropdown-for-woocommerce'); ?></option>
                    <option value="cheapest-only" <?php selected('cheapest-only', $single_shipping_option); ?>><?php esc_html_e('Show cheapest option only', 'shipping-method-dropdown-for-woocommerce'); ?></option>
                    <option value="expensive-only" <?php selected('expensive-only', $single_shipping_option); ?>><?php esc_html_e('Show most expensive option only', 'shipping-method-dropdown-for-woocommerce'); ?></option>
                </select>
            </fieldset>
        </td>
    </tr>

    <tr>
        <th scope="row" class="titledesc">
            <label for="pisol_smdsw_exclude_local_pickup_removal"><?php esc_html_e('Exclude local pickup from removal', 'shipping-method-dropdown-for-woocommerce'); ?><span class="woocommerce-help-tip" data-tip="<?php esc_attr_e('Don\'t exclude local pickup option when show single shipping method is selected', 'shipping-method-display-style-woocommerce'); ?>"></span></label>
        </th>
        <td class="forminp forminp-radio">
            <fieldset>
                <label><input name="pisol_smdsw_exclude_local_pickup_removal" value="yes" type="checkbox" <?php checked('yes', $exclude_local_pickup); ?>>
                </label>
            </fieldset>
        </td>
    </tr>
</table>
</div>
<div class="pi-col2">
<h2>Install our shipping plugin</h2>
<?php Pisol_Smdsw_Plugin::get_instance(); ?>
</div>
</div>