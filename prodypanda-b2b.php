<?php
/**
 * Plugin Name: Prodypanda B2B Wholesale Manager
 * Description: A robust WooCommerce extension for B2B role registration and dynamic wholesale pricing.
 * Version: 1.0.0
 * Author: Naserdine
 * Text Domain: prodypanda-b2b
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Prodypanda_B2B_Manager {

    private static $instance = null;

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
    }

    private function define_constants() {
        define( 'PRODYPANDA_B2B_VERSION', '1.0.0' );
        define( 'PRODYPANDA_B2B_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        define( 'PRODYPANDA_B2B_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    }

    private function includes() {
        require_once PRODYPANDA_B2B_PLUGIN_DIR . 'includes/class-prodypanda-b2b-roles.php';
        require_once PRODYPANDA_B2B_PLUGIN_DIR . 'includes/class-prodypanda-b2b-product.php';
        require_once PRODYPANDA_B2B_PLUGIN_DIR . 'includes/class-prodypanda-b2b-frontend.php';
    }

    private function init_hooks() {
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
    }

    public function load_textdomain() {
        load_plugin_textdomain( 'prodypanda-b2b', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    public function enqueue_admin_assets( $hook ) {
        global $post;
        if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
            if ( 'product' === $post->post_type ) {
                wp_enqueue_style( 
                    'prodypanda-b2b-admin-css', 
                    PRODYPANDA_B2B_PLUGIN_URL . 'assets/css/prodypanda-b2b-admin.css', 
                    array(), 
                    PRODYPANDA_B2B_VERSION 
                );
            }
        }
    }
}

function prodypanda_b2b() {
    return Prodypanda_B2B_Manager::get_instance();
}

// Initialize the plugin only if WooCommerce is active
add_action( 'plugins_loaded', function() {
    if ( class_exists( 'WooCommerce' ) ) {
        prodypanda_b2b();
    }
} );
