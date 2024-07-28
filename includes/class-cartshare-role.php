<?php
class CartShare_Role {
    public static function init() {
        add_action( 'init', array( __CLASS__, 'add_salesperson_role' ) );
        add_action( 'init', array( __CLASS__, 'add_salesperson_capabilities' ) );
    }

    public static function add_salesperson_role() {
        add_role( 'salesperson', 'Salesperson', array( 'read' => true, 'create_cart' => true ) );
    }

    public static function add_salesperson_capabilities() {
        $role = get_role( get_option('salesperson_role', 'salesperson') );
        if ( $role ) {
            $role->add_cap( 'create_cart' );
        }
    }

    public static function remove_salesperson_role() {
        remove_role( 'salesperson' );
    }
}
