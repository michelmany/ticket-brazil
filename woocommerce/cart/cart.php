<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-remove">&nbsp;</th>
				<!-- <th class="product-thumbnail">&nbsp;</th> -->
				<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="product-subtotal"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-remove">
							<?php
								// @codingStandardsIgnoreLine
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									__( 'Remove this item', 'woocommerce' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key );
							?>
						</td>


						<!-- COMMENTING TO HIDE PRODUCT THUMBNAIL

						<td class="product-thumbnail">
						<?php /*
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo wp_kses_post( $thumbnail );
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) );
						} */
						?>
						</td>
						-->

						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">

						<?php // REMOVING THE PRODUCT PERMALINK

						// if ( ! $product_permalink ) {
						// 	echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
						// } else {
						// 	echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						// }

						echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );		

						$prod_acf = get_fields($product_id);
						?>
						<div><small><?php echo $prod_acf['seat_type']->name; ?></small></div>
						<div><small><?php echo $prod_acf['parade']->name; ?></small></div>
						<div><small><?php echo $prod_acf['date']->name; ?></small></div>
						<?php

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>' ) );
						}
						?>

						
						</td>

						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
						<?php
						if ( $_product->is_sold_individually() ) {
							$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
						} else {
							$product_quantity = woocommerce_quantity_input( array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $_product->get_max_purchase_quantity(),
								'min_value'    => '0',
								'product_name' => $_product->get_name(),
							), $_product, false );
						}

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>
					</tr>
					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr>
				<td colspan="6" class="actions" style="display:none;">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>

					<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
					
					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>


<div class="cart__delivery">
	<input type="radio" id="deliveryYes" class="is-checkradio" v-model="modalDelivery.delivery" v-on:click="openDeliveryModal()" value="yes">
	<label for="deliveryYes" class="radio"><?php _e('Delivery', 'base-camp'); ?></label>
	
	<input type="radio" id="deliveryNo" class="is-checkradio" v-model="modalDelivery.delivery" v-on:click="closeDeliveryModal()" value="no">
	<label for="deliveryNo" class="radio"><?php _e('Pickup', 'base-camp'); ?></label>
</div>	


<div class="woocommerce">
	<div class="cart-collaterals">
		<?php
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10
			 */
			do_action( 'woocommerce_cart_collaterals' );
		?>
	</div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>

<div class="modal modal-delivery" v-bind:class="{ 'is-active': openModal == true }">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title"><?php _e('Delivery', 'base-camp'); ?></p>
			<button class="delete" aria-label="close" v-on:click="closeDeliveryModal()"></button>
		</header>

		<section class="modal-card-body">
			<h2 class="title is-5 modal-delivery__title"><?php _e('Place of stay', 'base-camp'); ?></h2>

			<div class="field">
				<label class="label"><?php _e('Location type', 'base-camp'); ?></label>
				<div class="control">
					<div class="select">
						<select v-model="modalDelivery.type">
							<option><?php _e('Select', 'base-camp'); ?></option>
							<option value="hotel"><?php _e('Hotel', 'base-camp'); ?></option>
							<option value="ship"><?php _e('Ship', 'base-camp'); ?></option>
							<option value="residence"><?php _e('Residence', 'base-camp'); ?></option>
						</select>
					</div>
				</div>
			</div>

			<br>

			<h2 class="title is-5 modal-delivery__title"><?php _e('Staying period', 'base-camp'); ?></h2>

			<div class="columns">
				<div class="column">
					<div class="field">
						<label class="label"><?php _e('Arrival Date', 'base-camp'); ?></label>
						<div class="control">
							<datepicker :language="lang.br" input-class="input" v-model="modalDelivery.arrival_date"></datepicker>
						</div>
					</div>
				</div>
				<div class="column">
					<div class="field">
						<label class="label"><?php _e('Departure Date', 'base-camp'); ?></label>
						<div class="control">
							<datepicker :language="lang.br" input-class="input" v-model="modalDelivery.departure_date"></datepicker>
						</div>
					</div>
				</div>
			</div>

			<br>

			<!-- Hotel -->
			<div v-if="modalDelivery.type == 'hotel'">
				<h2 class="title is-5 modal-delivery__title"><?php _e('Hotel', 'base-camp'); ?></h2>

				<div class="field">
					<div class="control">
						<div class="field">
							<label class="label"><?php _e('Hotel Name', 'base-camp'); ?></label>
							<div class="select">
								<select v-model="modalDelivery.hotel.hotel_name">
									<option>Select</option>
									<option value="1">SOFITEL IPANEMA HOTEL Av. Vieira Souto, 460</option><option value="2">IPANEMA PLAZA HOTEL R. Farme de Amoedo, 34</option><option value="3">COPACABANA RIO HOTEL Av. Nossa Sra. de Copacabana, 1256</option><option value="4">MAR PALACE HOTEL Av. Nossa Sra. de Copacabana, 552</option><option value="5">EVEREST PARK HOTEL R. Maria Quitéria, 25</option><option value="6">EVEREST RIO HOTEL R. Prudente de Morais, 1117</option><option value="7">RIO DESIGN PORTINARI HOTEL R. Francisco Sá, 17</option><option value="8">SOFITEL RIO HOTEL, Av. Atlantica, 02</option><option value="9">WINDSOR EXCELSIOR HOTEL Av. Atlântica, 1800</option><option value="10">WINDSOR BARRA HOTEL Av. Lúcio Costa, 2630</option><option value="11">WINDSOR MIRAMAR HOTEL Av. Atlântica, 3668</option><option value="12">WINDSOR PLAZA COPACABANA HOTEL Av. Princesa Isabel</option><option value="13">WINDSOR PALACE HOTEL Rua Domingos Ferreira, 6</option><option value="14">WINDSOR MARTINIQUE HOTEL R. Sá Ferreira, 30</option><option value="15">WINDSOR FLORIDA HOTEL R. Ferreira Viana, 81</option><option value="17">WINDSOR ASTURIAS HOTEL R. Sen. Dantas, 14</option><option value="18">BELMOND COPACABANA PALACE HOTEL Av. Atlântica, 1702 </option><option value="19">PORTO BAY RIO INTERNACIONAL HOTEL Av. Atlântica, 1500</option><option value="20">RIO OTHON PALACE HOTEL Av. Atlântica, 3264</option><option value="21">ARENA LEME HOTEL Av. Atlântica, 324</option><option value="23">OLINDA RIO HOTEL Av. Atlântica, 2230</option><option value="25">LANCASTER OTHON TRAVEL HOTEL Av. Atlântica, 1470</option><option value="26">SAVOY OTHON TRAVEL HOTEL Av. Nossa Sra. de Copacabana, 995</option><option value="27">AEROPORTO OTHON TRAVEL HOTEL </option><option value="28">SHERATON RIO HOTEL &amp; RESORT Av. Niemeyer, 121</option><option value="29">ASTORIA PALACE HOTEL Av. Atlântica, 1866</option><option value="30">BANDEIRANTES HOTEL R. Barata Ribeiro, 548</option><option value="31">ATLANTICO COPACABANA HOTEL Rua Siqueira Campos, 90</option><option value="32">ASTORIA COPACABANA HOTEL R. República do Peru, 345</option><option value="33">HILTON HOTEL Meridien- Av Princesa Isabel, 10</option><option value="34">MAR IPANEMA HOTEL R. Visc. de Pirajá, 539</option><option value="37">ORLA COPACABANA HOTEL Av. Atlântica, 4122</option><option value="40">ROYALTY COPACABANA HOTEL Rua Tonelero, 154</option><option value="42">PREMIER COPACABANA HOTEL Rua Tonelero, 205</option><option value="44">MERLIN COPACABANA HOTEL Av. Princesa Isabel, 392</option><option value="46">ACAPULCO COPACABANA HOTEL - Rua Gustavo Sampaio</option><option value="48">COPACABANA MAR HOTEL R. Min. Viveiros de Castro, 155</option><option value="49">MIRASOL COPACABANA HOTEL R. Rodolfo Dantas, 86</option><option value="50">VERMONT HOTEL R. Visc. de Pirajá, 254</option><option value="51">OWN VISCONTI HOTEL R. Prudente de Morais, 1050</option><option value="52">AUGUSTO`S COPACABANA HOTEL R. Bolívar, 119</option><option value="54">GRAND MERCURE COPACABANA HOTEL Av. Atlântica, 3716</option><option value="55">IPANEMA INN HOTEL R. Maria Quitéria, 27</option><option value="56">NOVOTEL RIO DE JANEIRO HOTEL Av. Marechal Câmara, 300</option><option value="58">MERCURE COPACABANA HOTEL Av. Atlântica, 2554</option><option value="63">PULLMAN HOTEL Av. Aquarela do Brasil, 75</option><option value="71">MERCURE BOTAFOGO MOURISCO HOTEL Rua da Passagem, 39</option><option value="73">PESTANA RIO ATLANTICA HOTEL Av. Atlântica, 2964</option><option value="77">TRANSAMERICA BARRA HOTEL Av. Gastão Sengés, 395</option><option value="80">PRAIA IPANEMA HOTEL Av. Vieira Souto, 706</option><option value="82">NOVO MUNDO HOTEL Praia do Flamengo, 20</option><option value="85">ARPOADOR INN HOTEL R. Francisco Otaviano, 177</option><option value="87">SOUTH AMERICAN COPACABANA HOTEL R. Francisco Sá, 90</option><option value="91">NOVOTEL COPACABANA R. Gustavo Sampaio, 320</option><option value="92">FASANO HOTEL Av. Vieira Souto, 80</option><option value="93">J W MARRIOTT HOTEL Av. Atlântica, 2600</option><option value="94">SOL IPANEMA HOTEL Av. Vieira Souto, 320</option><option value="95">MARINA PALACE HOTEL Av. Delfim Moreira, 630</option><option value="96">BRISA BARRA HOTEL Av. Lúcio Costa, 5700</option><option value="97">TROPICAL BARRA HOTEL Av. do Pepê, 500</option><option value="99">IBIS SANTOS DUMONT HOTEL Av. Mal. Câmara, 280</option><option value="100">O.K. HOTEL R. Senador Dantas, 24</option><option value="101">ATLANTICO BUSINESS HOTEL R. Sen. Dantas, 25</option><option value="102">ROYALTY BARRA HOTEL Av. do Pepê, 675</option><option value="103">GRAN NOBILE BARRA HOTEL Av. Lúcio Costa, 3.150</option><option value="105">AUGUSTO`S COPACABANA HOTEL R. Bolívar, 119</option><option value="106">WINDSOR COPACABANA HOTEL Av. Nossa Sra. de Copacabana, 335</option><option value="107">AUGUSTO'S RIO COPACABANA HOTEL Av. Princesa Isabel, 370</option><option value="108">ATLANTICO PRAIA OURO VERDE HOTEL Av. Atlântica, 1456</option><option value="109">ARENA COPACABANA HOTEL Av. Atlântica, 2064</option><option value="110">OCEANO COPACABANA HOTEL Rua Hilário de Gouvêia, 17</option><option value="111">J W MARRIOTT HOTEL Av. Atlântica, 2600</option><option value="112">J W MARRIOTT HOTEL Av. Atlântica, 2600</option><option value="113">VILAMAR COPACABANA HOTEL R. Bolívar, 75</option><option value="114">DEBRET HOTEL R. Alm. Gonçalves, 5</option><option value="115">RIO DESIGN PORTINARI HOTEL R. Francisco Sá, 17</option><option value="116">COPA SUL HOTEL Av. Nossa Sra. de Copacabana, 1284</option><option value="117">COPACABANA PRAIA HOTEL R. Francisco Otaviano, 38</option><option value="118">MERCURE ARPOADOR HOTEL R. Francisco Otaviano, 61</option><option value="119">ATLANTIS COPACABANA HOTEL R. Bulhões de Carvalho, 61</option><option value="121">REAL PALACE HOTEL R. Duvivier, 70</option><option value="122">ROYAL RIO PALACE HOTEL R. Duvivier, 82</option><option value="123">IBIS COPACABANA HOTEL Rua Ministro Viveiros de Castro, 134</option><option value="124">COPACABANA HOTEL RESIDENCIA R. Barata Ribeiro, 222</option><option value="125">APA HOTEL R. República do Peru, 305</option><option value="126">MIRADOR HOTEL Rua Tonelero, 338</option><option value="127">BENIDORM PALACE HOTEL R. Barata Ribeiro, 547</option><option value="130">CANADA HOTEL Av. Nossa Sra. de Copacabana, 687</option><option value="131">SAN MARCO HOTEL R. Visc. de Pirajá, 524</option><option value="132">IPANEMA TOWER HOTEL R. Prudente de Morais, 1008</option><option value="133">VERMONT HOTEL R. Visc. de Pirajá, 254</option><option value="134">VERMONT HOTEL R. Visc. de Pirajá, 254</option><option value="136">MARINA ALL SUITES HOTEL Av. Delfim Moreira, 696</option><option value="137">PULLMAN HOTEL Av. Aquarela do Brasil, 75</option><option value="138">SOL DA BARRA HOTEL Av. Lúcio Costa, 880</option><option value="144">ARGENTINA HOTEL R. Cruz Lima, 30</option><option value="149">CAIS DO PORTO Ponto de Encontro</option><option value="150">MERCURE BARRA HOTEL Av. do Pepê, 56</option><option value="151">IBIS BARRA HOTEL Av. Gilberto Amado, 41</option><option value="152">WINDSOR LEME PALACE Av. Atlântica, 656</option>
								</select>
															
							</div>
						</div>
					</div>
				</div>

				<div class="columns">
					<div class="column field">
						<div class="control">
							<div class="field">
								<label class="label"><?php _e('Reservation #', 'base-camp'); ?></label>
								<input type="text" class="input" v-model="modalDelivery.hotel.hotel_reservation">
							</div>
						</div>
					</div>

					<div class="column field">
						<div class="control">
							<div class="field">
								<label class="label"><?php _e('Customer name', 'base-camp'); ?></label>
								<input type="text" class="input" v-model="modalDelivery.hotel.hotel_customer_name">
							</div>
						</div>
					</div>
				</div>

			</div>

			<!-- Ship -->
			<div v-if="modalDelivery.type == 'ship'">
				<h2 class="title is-5 modal-delivery__title"><?php _e('Ship', 'base-camp'); ?></h2>

				<div class="columns">
					<div class="column field">
						<div class="control">
							<div class="field">
								<label class="label"><?php _e('Ship name', 'base-camp'); ?></label>
								<input type="text" class="input" v-model="modalDelivery.ship.ship_name">
							</div>
						</div>
					</div>

					<div class="column field">
						<div class="control">
							<div class="field">
								<label class="label"><?php _e('Cabin number', 'base-camp'); ?></label>
								<input type="text" class="input" v-model="modalDelivery.ship.ship_cabin_number">
							</div>
						</div>
					</div>
				</div>

			</div>			

			<!-- Residence -->
			<div v-if="modalDelivery.type == 'residence'">
				<h2 class="title is-5 modal-delivery__title"><?php _e('Residence', 'base-camp'); ?></h2>

				<div class="columns">
					<div class="column is-one-third control">
						<div class="field">
							<label class="label"><?php _e('Zip code', 'base-camp'); ?></label>
							<input type="text" class="input" v-model="modalDelivery.residence.residence_cep">
						</div>
					</div>		

					<div class="column control">
						<div class="field">
							<label class="label"><?php _e('Address', 'base-camp'); ?></label>
							<input type="text" class="input" v-model="modalDelivery.residence.residence_logradouro">
						</div>
					</div>
				</div>

				<div class="columns">
					<div class="column is-one-fifth">
						<div class="control">
							<div class="field">
								<label class="label"><?php _e('Number', 'base-camp'); ?></label>
								<input type="text" class="input" v-model="modalDelivery.residence.residence_numero">
							</div>
						</div>
					</div>

					<div class="column">
						<div class="control">
							<div class="field">
								<label class="label"><?php _e('Neighborhood', 'base-camp'); ?></label>
								<input type="text" class="input" v-model="modalDelivery.residence.residence_bairro">
							</div>
						</div>
					</div>

					<div class="column">
						<div class="control">
							<div class="field">
								<label class="label"><?php _e('Other information', 'base-camp'); ?></label>
								<input type="text" class="input" v-model="modalDelivery.residence.residence_complemento">
							</div>
						</div>
					</div>
				</div>				

			</div>				

		</section>
		<footer class="modal-card-foot">
			<button class="button is-danger" v-on:click="closeDeliveryModal()"><?php _e('Remove Delivery', 'base-camp'); ?></button>
			<button class="button is-success" v-on:click="closeDeliveryModal('save')"><?php _e('Save Delivery', 'base-camp'); ?></button>
		</footer>
	</div>
</div>	