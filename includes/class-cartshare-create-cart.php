<?php
class CartShare_Create_Cart {
    public static function init() {
        add_action( 'woocommerce_after_cart', array( __CLASS__, 'display_share_cart_button' ) );
        add_action( 'wp_footer', array( __CLASS__, 'add_share_cart_modal' ) );
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
        add_action( 'wp_ajax_cartshare_share_cart', array( __CLASS__, 'handle_share_cart' ) );
        add_action( 'wp_ajax_nopriv_cartshare_share_cart', array( __CLASS__, 'handle_share_cart' ) );
    }

    public static function enqueue_scripts() {
        if ( is_cart() ) {
            wp_enqueue_script( 'cartshare-js', CARTSHARE_PLUGIN_URL . 'assets/js/cartshare.js', array( 'jquery' ), CARTSHARE_VERSION, true );
            wp_localize_script( 'cartshare-js', 'cartshare', array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'cartshare_nonce' )
            ));
            wp_enqueue_style( 'cartshare-css', CARTSHARE_PLUGIN_URL . 'assets/css/cartshare.css' );
        }
    }

    public static function display_share_cart_button() {
        if ( current_user_can( 'create_cart' ) ) {
            echo '<button id="cartshare-share-cart-button" class="button">Share Cart</button>';
        }
    }

    public static function add_share_cart_modal() {
        if ( current_user_can( 'create_cart' ) ) {
            ?>
            <div id="cartshare-share-cart-modal" style="display:none;">
                <div class="cartshare-modal-content">
                    <span class="cartshare-close">&times;</span>
                    <h2>Share Cart</h2>
                    <form id="cartshare-share-cart-form">
                        <p>
                            <label for="cartshare-customer-phone">Customer Phone:</label>
                            <input type="text" id="cartshare-customer-phone" name="customer_phone" required>
                        </p>
                        <p>
                            <label for="cartshare-branch">Branch:</label>
                            <input type="text" id="cartshare-branch" name="branch" required>
                        </p>
                        <p>
                            <button type="submit">Share Cart</button>
                        </p>
                    </form>
                    <div id="cartshare-share-cart-result"></div>
                </div>
            </div>
            <?php
        }
    }

    public static function handle_share_cart() {
        check_ajax_referer( 'cartshare_nonce', 'nonce' );

        if ( ! current_user_can( 'create_cart' ) ) {
            wp_send_json_error( 'Unauthorized action' );
        }

        $customer_phone = sanitize_text_field( $_POST['customer_phone'] );
        $branch = sanitize_text_field( $_POST['branch'] );

        // Create an order
        $order = wc_create_order();
        foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
            $order->add_product( wc_get_product( $values['product_id'] ), $values['quantity'] );
        }

        // Set customer details
        $order->set_address( array( 'phone' => $customer_phone ), 'billing' );
        update_post_meta( $order->get_id(), '_salesperson', get_current_user_id() );
        update_post_meta( $order->get_id(), '_branch', $branch );

        $order->calculate_totals();
        $order->save();

        // Send SMS to customer
        $cart_link = wc_get_checkout_url();
        $message = str_replace( '{cart_link}', $cart_link, get_option( 'sms_content' ) );
        CartShare_SMS::send_sms_notification( $customer_phone, $message );

        wp_send_json_success( 'Cart shared successfully and SMS sent to customer' );
    }
}
