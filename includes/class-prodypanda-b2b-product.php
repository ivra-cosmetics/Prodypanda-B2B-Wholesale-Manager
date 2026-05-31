<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Prodypanda_B2B_Product {

    public function __construct() {
        add_action( 'woocommerce_product_options_pricing', array( $this, 'add_wholesale_price_field' ) );
        add_action( 'woocommerce_process_product_meta', array( $this, 'save_wholesale_price_field' ) );
    }

    public function add_wholesale_price_field() {
        global $product_object;

        echo '<div class="options_group prodypanda-b2b-field-wrapper">';

        woocommerce_wp_text_input(
            array(
                'id'          => '_prodypanda_wholesale_price',
                'label'       => esc_html__( 'Wholesale Price (B2B)', 'prodypanda-b2b' ) . ' (' . get_woocommerce_currency_symbol() . ')',
                'placeholder' => '',
                'data_type'   => 'price',
                'desc_tip'    => true,
                'description' => esc_html__( 'Set the specific price for authenticated B2B Buyers.', 'prodypanda-b2b' ),
                'value'       => $product_object->get_meta( '_prodypanda_wholesale_price', true )
            )
        );

        echo '</div>';
    }

    public function save_wholesale_price_field( $post_id ) {
        if ( isset( $_POST['_prodypanda_wholesale_price'] ) ) {
            $wholesale_price = wc_format_decimal( sanitize_text_field( wp_unslash( $_POST['_prodypanda_wholesale_price'] ) ) );
            $product         = wc_get_product( $post_id );
            
            if ( ! empty( $wholesale_price ) ) {
                $product->update_meta_data( '_prodypanda_wholesale_price', $wholesale_price );
            } else {
                $product->delete_meta_data( '_prodypanda_wholesale_price' );
            }
            
            $product->save_meta_data();
        }
    }
}

new Prodypanda_B2B_Product();
