<?php
// phpcs:ignoreFile

namespace AutomateWoo\Rules;

defined( 'ABSPATH' ) || exit;

/**
 * @class Order_Customer_Provided_Note
 */
class Order_Customer_Provided_Note extends Abstract_String {

	public $data_item = 'order';


	function init() {
		$this->title = __( 'Order - Customer Provided Note', 'automatewoo' );
	}


	/**
	 * @param $order \WC_Order
	 * @param $compare
	 * @param $value
	 * @return bool
	 */
	function validate( $order, $compare, $value ) {
		return $this->validate_string( $order->get_customer_note(), $compare, $value );
	}

}
