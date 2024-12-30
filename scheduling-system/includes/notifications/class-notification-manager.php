<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingNotificationManager {
    public function __construct() {
        add_action('scheduling_appointment_created', array($this, 'send_new_appointment_notifications'));
        add_action('scheduling_appointment_updated', array($this, 'send_update_notifications'));
    }

    public function send_new_appointment_notifications($appointment_id) {
        $appointment = $this->get_appointment($appointment_id);
        
        // Email para o cliente
        $this->send_email_notification(
            $appointment->client_email,
            'Confirmação de Agendamento',
            $this->get_client_email_template($appointment)
        );

        // SMS para o cliente
        $this->send_sms_notification(
            $appointment->client_phone,
            $this->get_client_sms_template($appointment)
        );

        // WhatsApp para o profissional
        $this->send_whatsapp_notification(
            $appointment->provider_phone,
            $this->get_provider_whatsapp_template($appointment)
        );
    }

    private function send_email_notification($to, $subject, $message) {
        wp_mail($to, $subject, $message, array('Content-Type: text/html; charset=UTF-8'));
    }

    private function send_sms_notification($to, $message) {
        // Integração com API de SMS (ex: Twilio)
    }

    private function send_whatsapp_notification($to, $message) {
        // Integração com WhatsApp Business API
    }
}