<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';
?>
<tr class="woocommerce-shipping-totals shipping <?php if ( 1 < count( $available_methods ) ) : ?>shipping__table--multiple<?php endif; ?>">
	<th><?php echo wp_kses_post( $package_name ); ?></th>
	<td data-title="<?php echo esc_attr( $package_name ); ?>">
		<?php if ( $available_methods ) : ?>

        <?php
        if ( 1 === count( $available_methods ) ) :

            $method = current( $available_methods );

            echo wp_kses_post( wc_cart_totals_shipping_method_label( $method ) );
            ?>
            <input type="hidden" name="shipping_method[<?php echo esc_attr( $index ); ?>]"
                   data-index="<?php echo esc_attr( $index ); ?>"
                   id="shipping_method_<?php echo esc_attr( $index ); ?>"
                   value="<?php echo esc_attr( $method->id ); ?>" class="shipping_method"/>

        <?php elseif ( get_option( 'pisol_smdsw_shipping_method_style', 'select' ) === 'select' ) : ?>

            <select name="shipping_method[<?php echo esc_attr( $index ); ?>]"
                    data-index="<?php echo esc_attr( $index ); ?>"
                    id="shipping_method_<?php echo esc_attr( $index ); ?>" class="shipping_method smdsw-shipping">
					<option value disabled selected><?php esc_html_e( 'Select an shipping option', 'woo-shipping-display-mode' ); ?></option>
                <?php foreach ( $available_methods as $method ) : ?>
                    <option value="<?php echo esc_attr( $method->id ); ?>" <?php selected( $method->id, $chosen_method ); ?>><?php echo wp_kses_post( wc_cart_totals_shipping_method_label( $method ) ); ?></option>
                <?php endforeach; ?>
            </select>

        <?php else : ?>
			<ul id="shipping_method" class="woocommerce-shipping-methods">
				<?php foreach ( $available_methods as $method ) : ?>
					<li class="shipping__list_item">
						<?php
						if ( 1 < count( $available_methods ) ) {
							printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />', esc_attr($index), esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						} else {
							printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', esc_attr($index), esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}
						printf( '<label for="shipping_method_%1$s_%2$s" class="shipping__list_label">%3$s</label>', esc_attr($index), esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						do_action( 'woocommerce_after_shipping_rate', $method, $index );
						?>
					</li>
				<?php endforeach; ?>
			</ul>
        <?php endif; ?>

            <?php if ( is_cart() ) : ?>
				<p class="woocommerce-shipping-destination">
					<?php
					if ( $formatted_destination ) {
						// Translators: $s shipping destination.
						printf( esc_html__( 'Shipping to %s.', 'woo-shipping-display-mode' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' );
						$calculator_text = esc_html__( 'Change address', 'woo-shipping-display-mode' );
					} else {
						echo wp_kses_post( apply_filters( 'woocommerce_shipping_estimate_html', __( 'Shipping options will be updated during checkout.', 'woo-shipping-display-mode' ) ) );
					}
					?>
				</p>
			<?php endif; ?>
			<?php
		elseif ( ! $has_calculated_shipping || ! $formatted_destination ) :
			echo wp_kses_post( apply_filters( 'woocommerce_shipping_may_be_available_html', __( 'Enter your address to view shipping options.', 'woo-shipping-display-mode' ) ) );
		elseif ( ! is_cart() ) :
			echo wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woo-shipping-display-mode' ) ) );
		else :
			// Translators: $s shipping destination.
			echo wp_kses_post( apply_filters( 'woocommerce_cart_no_shipping_available_html', sprintf( esc_html__( 'No shipping options were found for %s.', 'woo-shipping-display-mode' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ) ) );
			$calculator_text = esc_html__( 'Enter a different address', 'woo-shipping-display-mode' );
		endif;
		?>

		<?php if ( $show_package_details ) : ?>
			<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
		<?php endif; ?>

		<?php if ( $show_shipping_calculator ) : ?>
			<?php woocommerce_shipping_calculator( $calculator_text ); ?>
		<?php endif; ?>
	</td>
</tr>
