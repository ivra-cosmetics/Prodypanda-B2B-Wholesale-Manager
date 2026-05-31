<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Prodypanda_B2B_Roles {

    public function __construct() {
        add_action( 'init', array( $this, 'register_b2b_role' ) );
    }

    public function register_b2b_role() {
        if ( ! get_role( 'prodypanda_b2b_buyer' ) ) {
            add_role(
                'prodypanda_b2b_buyer',
                esc_html__( 'B2B Buyer', 'prodypanda-b2b' ),
                array(
                    'read' => true,
                )
            );
        }
    }
}

new Prodypanda_B2B_Roles();
