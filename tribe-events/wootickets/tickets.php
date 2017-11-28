<?php
/**
 * Renders the WooCommerce tickets table/form
 *
 * Override this template in your own theme by creating a file at:
 *
 *     [your-theme]/tribe-events/wootickets/tickets.php
 *
 * @version 4.6
 *
 * @var bool $global_stock_enabled
 * @var bool $must_login
 */
global $woocommerce;

$is_there_any_product         = false;
$is_there_any_product_to_sell = false;
$unavailability_messaging     = is_callable( array( $this, 'do_not_show_tickets_unavailable_message' ) );

if ( ! empty( $tickets ) ) {
	$tickets = tribe( 'tickets.handler' )->sort_tickets_by_menu_order( $tickets );
}

ob_start();

/**
 * Filter classes on the Cart Form
 *
 * @since  4.3.2
 *
 * @param array $cart_classes
 */
$cart_classes = (array) apply_filters( 'tribe_events_tickets_woo_cart_class', array( 'cart' ) );
?>
<form
	id="buy-tickets"
	action="<?php echo esc_url( wc_get_cart_url() ) ?>"
	class="<?php echo esc_attr( implode( ' ', $cart_classes ) ); ?>"
	method="post"
	enctype='multipart/form-data'
>

	<h2 class="tribe-events-tickets-title tribe--tickets">
		<?php esc_html_e( 'Tickets', 'event-tickets-plus' ) ?>
	</h2>

	<div id="css_table" class="tribe-events-tickets">
		<?php
		/**
		 * Reorder the tickets per the admin interface order
		 *
		 * @since 4.6
		 */
		foreach ( $tickets as $ticket ) :
			/**
			 * Changing any HTML to the `$ticket` Arguments you will need apply filters
			 * on the `wootickets_get_ticket` hook.
			 */

			/**
			 * @var Tribe__Tickets__Ticket_Object $ticket
			 * @var WC_Product $product
			 */
			global $product;

			if ( class_exists( 'WC_Product_Simple' ) ) {
				$product = new WC_Product_Simple( $ticket->ID );
			} else {
				$product = new WC_Product( $ticket->ID );
			}

			$is_there_any_product = true;
			$data_product_id      = '';

			if ( $ticket->date_in_range( current_time( 'timestamp' ) ) ) {

				$is_there_any_product = true;

				echo sprintf( '<input type="hidden" name="product_id[]" value="%d">', esc_attr( $ticket->ID ) );

				/**
				 * Filter classes on the Price column
				 *
				 * @since  4.3.2
				 *
				 * @param array $column_classes
				 * @param int $ticket->ID
				 */
				$column_classes = (array) apply_filters( 'tribe_events_tickets_woo_quantity_column_class', array( 'woocommerce' ), $ticket->ID );

				// Max quantity will be left open if backorders allowed, restricted to 1 if the product is
				// constrained to be sold individually or else set to the available stock quantity
				$max_quantity = $product->backorders_allowed() ? '' : $product->get_stock_quantity();
				$max_quantity = $product->is_sold_individually() ? 1 : $max_quantity;
				$available    = $ticket->available();
				echo '<div class="css_tr">';
				echo '<div class="css_th">入場資訊</div>';
				echo '<div class="css_th">價錢</div>';
				echo '<div class="css_th">描述</div>';
				echo '<div class="css_th">人數</div>';
				echo '</div>';
				/**
				 * Filter classes on the row
				 *
				 * @since  4.5.5
				 *
				 * @param array $row_classes
				 * @param int $ticket->ID
				 */
				$row_classes = (array) apply_filters( 'tribe_events_tickets_row_class', array( 'woocommerce', 'tribe-tickets-form-row' ), $ticket->ID );
				echo '<div class="css_tr ' . esc_attr( implode( ' ', $row_classes ) ) . '" data-product-id="' . esc_attr( $ticket->ID ) . '">';

				echo '<div class="css_td tickets_name">' . $ticket->name . '</div>';

				echo '<div class="css_td tickets_price">';

				if ( method_exists( $product, 'get_price' ) && $product->get_price() ) {
					echo $this->get_price_html( $product );
				} else {
					esc_html_e( 'Free', 'event-tickets-plus' );
				}

				echo '</div>';

				echo '<div class="css_td tickets_description">' . ( $ticket->show_description() ? $ticket->description : '' ) . '</div>';
				/**
				 * Filter classes on the Price column
				 *
				 * @since  4.3.2
				 *
				 * @param array $column_classes
				 */
				$column_classes = (array) apply_filters( 'tribe_events_tickets_woo_quantity_column_class', array( 'woocommerce' ) );
				echo '<div class="css_td ' . esc_attr( implode( ' ', $column_classes ) ) . '" data-product-id="' . esc_attr( $ticket->ID ) . '">';

				if ( 0 !== $available ) {
					// Max quantity will be left open if backorders allowed, restricted to 1 if the product is
					// constrained to be sold individually or else set to the available stock quantity
					$stock        = $ticket->stock();
					$max_quantity = $product->backorders_allowed() ? '' : $stock;
					$max_quantity = $product->is_sold_individually() ? 1 : $max_quantity;
					$available    = $ticket->available();

					woocommerce_quantity_input( array(
						'input_name'  => 'quantity_' . $ticket->ID,
						'input_value' => 0,
						'min_value'   => 0,
						'max_value'   => $must_login ? 0 : $max_quantity, // Currently WC does not support a 'disable' attribute
					) );

					$is_there_any_product_to_sell = true;

					if ( $available ) {
						?>
						<span class="tribe-tickets-remaining">
						<?php
						echo sprintf( esc_html__( '%1$s available', 'event-tickets-plus' ),
							'<span class="available-stock" data-product-id="' . esc_attr( $ticket->ID ) . '">' . tribe_tickets_get_readable_amount( $stock, null, false ) . '</span>'
						);
						?>
						</span>
						<?php
					}

					do_action( 'wootickets_tickets_after_quantity_input', $ticket, $product );
				} else {
					echo '<span class="tickets_nostock">' . esc_html__( 'Out of stock!', 'event-tickets-plus' ) . '</span>';
				}

				echo '</div>';
				echo '</div>';

				if ( $product->is_in_stock() ) {
					/**
					 * Use this filter to hide the Attendees List Optout
					 *
					 * @since 4.5.2
					 *
					 * @param bool
					 */
					$hide_attendee_list_optout = apply_filters( 'tribe_tickets_plus_hide_attendees_list_optout', false );
					if ( ! $hide_attendee_list_optout
						 && class_exists( 'Tribe__Tickets_Plus__Attendees_List' )
						 && ! Tribe__Tickets_Plus__Attendees_List::is_hidden_on( get_the_ID() )
					) { ?>
						<div class="css_tr tribe-tickets-attendees-list-optout">
							<div class="css_td" colspan="4">
								<input
									type="checkbox"
									name="optout_<?php echo esc_attr( $ticket->ID ); ?>"
									id="tribe-tickets-attendees-list-optout-edd"
								>
								<label for="tribe-tickets-attendees-list-optout-edd"><?php esc_html_e( "Don't list me on the public attendee list", 'event-tickets-plus' ); ?></label>
							</div>
						</div>
						<?php
					}

					include Tribe__Tickets_Plus__Main::instance()->get_template_hierarchy( 'meta.php' );
				}
			}

		endforeach; ?>

		<?php if ( $is_there_any_product_to_sell ) : ?>
			<div class="css_tr">
				<div colspan="4" class="css_td woocommerce add-to-cart">
					<?php if ( $must_login ) : ?>
						<?php include Tribe__Tickets_Plus__Main::instance()->get_template_hierarchy( 'login-to-purchase' ); ?>
					<?php else: ?>
						<button
							type="submit"
							name="wootickets_process"
							value="1"
							class="tribe-button"
						>
							<?php esc_html_e( 'Add to cart', 'event-tickets-plus' );?>
						</button>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<noscript>
			<div class="css_tr">
				<div class="css_td tribe-link-tickets-message">
					<div class="no-javascript-msg"><?php esc_html_e( 'You must have JavaScript activated to purchase tickets. Please enable JavaScript in your browser.', 'event-tickets-plus' ); ?></div>
				</div>
			</div>
		</noscript>
	</div>
</form>
<?php
$content = ob_get_clean();
if ( $is_there_any_product ) {
	echo $content;

	// @todo remove safeguard in 4.3 or later
	if ( $unavailability_messaging ) {
		// If we have rendered tickets there is generally no need to display a 'tickets unavailable' message
		// for this post
		$this->do_not_show_tickets_unavailable_message();
	}
} else {
	// @todo remove safeguard in 4.3 or later
	if ( $unavailability_messaging ) {
		$unavailability_message = $this->get_tickets_unavailable_message( $tickets );

		// if there isn't an unavailability message, bail
		if ( ! $unavailability_message ) {
			return;
		}
	}
}
