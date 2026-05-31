<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Prodypanda_B2B_Frontend {

    public function __construct() {
        add_filter( 'woocommerce_product_get_price', array( $this, 'apply_wholesale_price' ), 10, 2 );
        add_filter( 'woocommerce_product_get_regular_price', array( $this, 'apply_wholesale_price' ), 10, 2 );
        add_filter( 'woocommerce_product_variation_get_price', array( $this, 'apply_wholesale_price' ), 10, 2 );
        add_filter( 'woocommerce_product_variation_get_regular_price', array( $this, 'apply_wholesale_price' ), 10, 2 );
    }

    public function apply_wholesale_price( $price, $product ) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            return $price;
        }

        if ( ! is_user_logged_in() ) {
            return $price;
        }

        $user = wp_get_current_user();
        if ( ! in_array( 'prodypanda_b2b_buyer', (array) $user->roles, true ) ) {
            return $price;
        }

        $wholesale_price = $product->get_meta( '_prodypanda_wholesale_price', true );

        if ( ! empty( $wholesale_price ) && is_numeric( $wholesale_price ) ) {
            return $wholesale_price;
        }

        return $price;
    }
}

new Prodypanda_B2B_Frontend();
