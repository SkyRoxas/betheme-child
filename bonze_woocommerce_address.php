<?php
//functions.php
function mxp_remove_default_useless_fields($fields) {
	unset($fields['country']);
	unset($fields['last_name']);
	unset($fields['address_2']);
	unset($fields['city']);
	unset($fields['state']);
	return $fields;
}
add_filter('woocommerce_default_address_fields', 'mxp_remove_default_useless_fields', 999, 1);

function mxp_custom_override_my_account_billing_fields($fields) {
	$fields['billing']['billing_company_tax_id'] = array(
		'label' => __('公司統編', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('公司統編', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => false,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$billing_display_fields_order = array(
		"billing_first_name" => "",
		"billing_address_1" => "",
		"billing_postcode" => "",
		"billing_email" => "",
		"billing_phone" => "",
		"billing_company" => "",
		"billing_company_tax_id" => "",
	);
	foreach ($billing_display_fields_order as $field) {

		if (!empty($field)) {
			$billing_display_fields_order[$field] = $fields[$field];
		}
	}

	return $billing_display_fields_order;
}
add_filter('woocommerce_billing_fields', 'mxp_custom_override_my_account_billing_fields', 999, 1);

function mxp_custom_override_my_account_shipping_fields($fields) {
	$fields['shipping']['shipping_phone'] = array(
		'label' => __('收件人電話', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('收件人手機格式：0912345678', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => true,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$fields['shipping']['shipping_email'] = array(
		'label' => __('收貨人信箱', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('請輸入收貨人信箱', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => false,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$shipping_display_fields_order = array(
		"shipping_first_name" => "",
		"shipping_address_1" => "",
		"shipping_postcode" => "",
		"shipping_email" => "",
		"shipping_phone" => "",
		"shipping_company" => "",
	);
	foreach ($shipping_display_fields_order as $field) {
		if (!empty($field)) {
			$shipping_display_fields_order[$field] = $fields[$field];
		}
	}
	return $shipping_display_fields_order;
}
add_filter('woocommerce_shipping_fields', 'mxp_custom_override_my_account_shipping_fields', 999, 1);

function mxp_custom_override_checkout_fields($fields) {
	$fields['billing']['billing_first_name'] = array(
		'label' => __('姓名', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('姓名', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => true,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$fields['shipping']['shipping_first_name'] = array(
		'label' => __('姓名', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('姓名', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => true,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$fields['billing']['billing_company'] = array(
		'label' => __('公司名稱', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('公司名稱', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => false,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$fields['billing']['billing_company_tax_id'] = array(
		'label' => __('公司統編', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('公司統編', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => false,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$fields['shipping']['shipping_company'] = array(
		'label' => __('公司名稱', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('公司名稱', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => false,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$fields['billing']['billing_phone'] = array(
		'label' => __('電話', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('手機格式：0912345678', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => true,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$fields['billing']['billing_postcode'] = array(
		'label' => __('郵遞區號', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('郵遞區號', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => false,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$fields['billing']['billing_address_1'] = array(
		'label' => __('地址', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('地址', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => true,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$fields['shipping']['shipping_address_1'] = array(
		'label' => __('地址', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('地址', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => true,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$fields['shipping']['shipping_phone'] = array(
		'label' => __('收件人電話', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('收件人手機格式：0912345678', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => true,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$fields['billing']['billing_email'] = array(
		'label' => __('結帳信箱', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('請輸入信箱', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => true,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	$fields['shipping']['shipping_email'] = array(
		'label' => __('收貨人信箱', 'mxp-wc-checkout-fields-custom'),
		'placeholder' => _x('請輸入收貨人信箱', 'placeholder', 'mxp-wc-checkout-fields-custom'),
		'required' => false,
		'class' => array('form-row-wide'),
		'clear' => true,
	);
	//reorder fields
	$billing_fields = array();
	$shipping_fields = array();
	$billing_display_fields_order = array(
		"billing_first_name",
		"billing_address_1",
		"billing_postcode",
		"billing_email",
		"billing_phone",
		"billing_company",
		"billing_company_tax_id",
	);
	foreach ($billing_display_fields_order as $field) {
		$billing_fields[$field] = $fields["billing"][$field];
	}
	$shipping_display_fields_order = array(
		"shipping_first_name",
		"shipping_address_1",
		"shipping_postcode",
		"shipping_email",
		"shipping_phone",
		"shipping_company",
	);
	foreach ($shipping_display_fields_order as $field) {
		$shipping_fields[$field] = $fields["shipping"][$field];
	}
	$fields["billing"] = $billing_fields;
	$fields["shipping"] = $shipping_fields;
	return $fields;
}
add_filter('woocommerce_checkout_fields', 'mxp_custom_override_checkout_fields', 999, 1);

function mxp_custom_checkout_field_display_admin_order_billing_meta($order) {
	echo '<p><strong>' . __('公司統編', 'mxp-wc-checkout-fields-custom') . ':</strong> ' . get_post_meta($order->id, '_billing_company_tax_id', true) . '</p>';
}
add_action('woocommerce_admin_order_data_after_billing_address', 'mxp_custom_checkout_field_display_admin_order_billing_meta', 10, 1);

function mxp_custom_checkout_field_display_admin_order_shipping_meta($order) {
	echo '<p><strong>' . __('收貨人手機', 'mxp-wc-checkout-fields-custom') . ':</strong> ' . get_post_meta($order->id, '_shipping_phone', true) . '</p>';
	echo '<p><strong>' . __('收貨人信箱', 'mxp-wc-checkout-fields-custom') . ':</strong> ' . get_post_meta($order->id, '_shipping_email', true) . '</p>';
}
add_action('woocommerce_admin_order_data_after_shipping_address', 'mxp_custom_checkout_field_display_admin_order_shipping_meta', 10, 1);

//加入免運權重，避免多運費選項出現
function hide_shipping_when_free_is_available($rates) {
	$free = array();
	foreach ($rates as $rate_id => $rate) {
		if ('free_shipping' === $rate->method_id) {
			$free = array();
			$free[$rate_id] = $rate;
			break;
		}
		if ('flat_rate' === $rate->method_id) {
			if ($rate->cost == 0) {
				$free = array();
				$rate->label = __('免運費', 'mxp-wc-checkout-fields-custom');
				$free[$rate_id] = $rate;
				break;
			}
		}
	}
	return !empty($free) ? $free : $rates;
}
add_filter('woocommerce_package_rates', 'hide_shipping_when_free_is_available', 100, 1);

//購物車自動更新數量
function mxp_auto_cart_update_qty_script() {
   ?>
    <script>
        jQuery('div.woocommerce').on('change', '.qty', function(){
           jQuery("[name='update_cart']").removeAttr('disabled');
           jQuery("[name='update_cart']").trigger("click");
        });
   </script>
<?php
}
add_action( 'woocommerce_after_cart', 'mxp_auto_cart_update_qty_script' );

//更改運送方式1
function filter_woocommerce_shipping_package_name( $sprintf, $i, $package ) {
 // make filter magic happen here...
 return '運送方式';
};
add_filter( 'woocommerce_shipping_package_name', 'filter_woocommerce_shipping_package_name', 10, 3 );
