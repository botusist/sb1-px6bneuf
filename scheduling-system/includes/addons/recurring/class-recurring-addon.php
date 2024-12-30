<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingRecurringAddon {
    public function __construct() {
        add_action('scheduling_after_appointment_save', array($this, 'create_recurring_appointments'));
        add_filter('scheduling_appointment_form', array($this, 'add_recurring_options'));
    }

    public function create_recurring_appointments($appointment_id) {
        $recurring_data = $_POST['recurring'] ?? null;
        if (!$recurring_data) return;

        // Cria agendamentos recorrentes baseado nas regras definidas
        $this->generate_recurring_appointments($appointment_id, $recurring_data);
    }
}