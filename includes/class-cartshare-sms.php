<?php
class CartShare_SMS {
    public static function init() {
        add_action( 'woocommerce_order_status_processing', array( __CLASS__, 'send_sms_notification' ) );
    }

    public static function send_sms_notification( $order_id ) {
        $order = wc_get_order( $order_id );
        $customer_phone = $order->get_billing_phone();
        $sms_content = get_option( 'sms_content' );
        $cart_link = wc_get_cart_url();
        $message = str_replace( '{cart_link}', $cart_link, $sms_content );

        $username = get_option( 'clicksend_username' );
        $api_key = get_option( 'clicksend_api_key' );

        // Send SMS using ClickSend API
        $url = 'https://rest.clicksend.com/v3/sms/send';
        $data = array(
            'messages' => array(
                array(
                    'source' => 'php',
                    'from' => 'Ansons',
                    'body' => $message,
                    'to' => $customer_phone
                )
            )
        );

        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json
Authorization: Basic " . base64_encode("$username:$api_key"),
                'method'  => 'POST',
                'content' => json_encode( $data ),
            ),
        );

        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        if ( $result === FALSE ) {
            // Handle error
        }
    }
}
