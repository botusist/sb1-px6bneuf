<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingPaymentGateway {
    private $gateways = [];

    public function __construct() {
        add_action('init', array($this, 'register_gateways'));
    }

    public function register_gateways() {
        // Registra gateways de pagamento
        $this->gateways = apply_filters('scheduling_payment_gateways', array(
            'stripe' => new SchedulingStripeGateway(),
            'mercadopago' => new SchedulingMercadoPagoGateway(),
        ));
    }

    public function process_payment($appointment_id, $gateway_id, $payment_data) {
        if (!isset($this->gateways[$gateway_id])) {
            return new WP_Error('invalid_gateway', 'Gateway de pagamento inválido');
        }

        return $this->gateways[$gateway_id]->process_payment($appointment_id, $payment_data);
    }
}