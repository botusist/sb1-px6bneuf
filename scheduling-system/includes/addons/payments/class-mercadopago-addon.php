<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingMercadoPagoAddon {
    public function __construct() {
        add_filter('scheduling_payment_gateways', array($this, 'register_gateway'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function register_gateway($gateways) {
        require_once plugin_dir_path(__FILE__) . 'gateways/class-mercadopago-gateway.php';
        $gateways['mercadopago'] = new SchedulingMercadoPagoGateway();
        return $gateways;
    }

    public function enqueue_scripts() {
        wp_enqueue_script('mercadopago-js', 'https://sdk.mercadopago.com/js/v2', array(), null, true);
    }
}