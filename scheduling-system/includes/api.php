<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingAPI {
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    public function register_routes() {
        register_rest_route('scheduling/v1', '/appointments', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_appointments'),
            'permission_callback' => array($this, 'check_permission')
        ));

        register_rest_route('scheduling/v1', '/appointments', array(
            'methods' => 'POST',
            'callback' => array($this, 'create_appointment'),
            'permission_callback' => array($this, 'check_permission')
        ));
    }

    public function check_permission() {
        return is_user_logged_in();
    }

    public function get_appointments($request) {
        global $wpdb;
        $user_id = get_current_user_id();

        $appointments = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}scheduling_appointments 
            WHERE client_id = %d OR provider_id IN 
                (SELECT id FROM {$wpdb->prefix}scheduling_providers WHERE user_id = %d)",
            $user_id,
            $user_id
        ));

        return new WP_REST_Response($appointments, 200);
    }

    public function create_appointment($request) {
        global $wpdb;
        $params = $request->get_params();
        
        // Validação dos dados
        if (!isset($params['service_id'], $params['provider_id'], $params['start_time'])) {
            return new WP_Error('missing_fields', 'Campos obrigatórios faltando', array('status' => 400));
        }

        $result = $wpdb->insert(
            "{$wpdb->prefix}scheduling_appointments",
            array(
                'service_id' => $params['service_id'],
                'provider_id' => $params['provider_id'],
                'client_id' => get_current_user_id(),
                'start_time' => $params['start_time'],
                'end_time' => $params['end_time'],
                'notes' => isset($params['notes']) ? $params['notes'] : '',
                'status' => 'pending'
            ),
            array('%d', '%d', '%d', '%s', '%s', '%s', '%s')
        );

        if ($result === false) {
            return new WP_Error('db_error', 'Erro ao criar agendamento', array('status' => 500));
        }

        return new WP_REST_Response(array(
            'id' => $wpdb->insert_id,
            'message' => 'Agendamento criado com sucesso'
        ), 201);
    }
}