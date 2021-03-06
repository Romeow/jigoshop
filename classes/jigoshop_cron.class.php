<?php
/**
 * WordPress Cron Tasks
 *
 * DISCLAIMER
 *
 * Do not edit or add directly to this file if you wish to upgrade Jigoshop to newer
 * versions in the future. If you wish to customise Jigoshop core for your needs,
 * please use our GitHub repository to publish essential changes for consideration.
 *
 * @package             Jigoshop
 * @category            Core
 * @author              Jigoshop
 * @copyright           Copyright © 2011-2013 Jigoshop.
 * @license             http://jigoshop.com/license/commercial-edition
 */


class jigoshop_cron extends Jigoshop_Base {
	
	
	function __construct () {

		$this->jigoshop_schedule_events();

		add_action( 'jigoshop_cron_pending_orders', array( $this, 'jigoshop_update_pending_orders' ) );

	}
	
	
	function jigoshop_schedule_events() {

		if ( ! wp_next_scheduled( 'jigoshop_cron_pending_orders' ) ) {
			
			wp_schedule_event( time(), 'daily', 'jigoshop_cron_pending_orders' );
			
		}

	}
	
	
	function jigoshop_update_pending_orders() {
		
		if ( self::get_options()->get_option( 'jigoshop_reset_pending_orders' ) == 'yes' ) {
		
			add_filter( 'posts_where', array( $this, 'orders_filter_when' ));
			
			$orders = get_posts( array(
		
				'post_status'       => 'publish',
				'post_type'         => 'shop_order',
				'shop_order_status' => 'pending',
				'suppress_filters'  => false,
				'fields'            => 'ids',
			
			));
			
			remove_filter( 'posts_where', array( $this, 'orders_filter_when' ));
			
			remove_action( 'order_status_pending_to_on-hold', 'jigoshop_processing_order_customer_notification' );
			
			foreach ( $orders as $index => $order_id ) {
				$order = new jigoshop_order( $order_id );
				$order->update_status( 'on-hold', __('Archived due to order being in pending state for a month or longer.', 'jigoshop') );
			}
			
			add_action( 'order_status_pending_to_on-hold', 'jigoshop_processing_order_customer_notification' );
			
		}

	}
	
	
	function orders_filter_when( $when = '' ) {
	
		$when .= " AND post_date < '" . date('Y-m-d', strtotime('-30 days')) . "'";
		return $when;
		
	}

}
