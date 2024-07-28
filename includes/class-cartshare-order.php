<?php
class CartShare_Order {
    public static function init() {
        add_action( 'woocommerce_checkout_update_order_meta', array( __CLASS__, 'add_order_meta' ) );
        add_action( 'woocommerce_admin_order_data_after_billing_address', array( __CLASS__, 'display_order_meta' ), 10, 1 );
    }

    public static function add_order_meta( $order_id ) {
        if ( isset( $_POST['salesperson'] ) && isset( $_POST['branch'] ) ) {
            update_post_meta( $order_id, '_salesperson', sanitize_text_field( $_POST['salesperson'] ) );
            update_post_meta( $order_id, '_branch', sanitize_text_field( $_POST['branch'] ) );
        }
    }

    public static function display_order_meta( $order ) {
        $salesperson = get_post_meta( $order->get_id(), '_salesperson', true );
        $branch = get_post_meta( $order->get_id(), '_branch', true );

        if ( $salesperson ) {
            echo '<p><strong>' . __( 'Salesperson' ) . ':</strong> ' . esc_html( $salesperson ) . '</p>';
        }

        if ( $branch ) {
            echo '<p><strong>' . __( 'Branch' ) . ':</strong> ' . esc_html( $branch ) . '</p>';
        }
    }
}
