<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingSettingsManager {
    private $options;

    public function __construct() {
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function register_settings() {
        register_setting('scheduling_options', 'scheduling_settings');

        add_settings_section(
            'scheduling_general',
            'Configurações Gerais',
            array($this, 'general_section_callback'),
            'scheduling_settings'
        );

        add_settings_field(
            'business_hours',
            'Horário de Funcionamento',
            array($this, 'business_hours_callback'),
            'scheduling_settings',
            'scheduling_general'
        );

        add_settings_field(
            'interval_between_appointments',
            'Intervalo entre Agendamentos',
            array($this, 'interval_callback'),
            'scheduling_settings',
            'scheduling_general'
        );
    }

    public function get_setting($key) {
        if (empty($this->options)) {
            $this->options = get_option('scheduling_settings');
        }
        return isset($this->options[$key]) ? $this->options[$key] : null;
    }
}