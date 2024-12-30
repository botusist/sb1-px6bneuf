<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingGoogleCalendarAddon {
    private $client;
    private $settings;

    public function __construct() {
        add_action('init', array($this, 'init_google_client'));
        add_action('scheduling_after_appointment_save', array($this, 'sync_appointment'));
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function init_google_client() {
        require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
        
        $this->settings = get_option('scheduling_google_calendar_settings');
        
        $this->client = new Google_Client();
        $this->client->setClientId($this->settings['client_id']);
        $this->client->setClientSecret($this->settings['client_secret']);
        $this->client->setRedirectUri(admin_url('admin.php?page=scheduling-google-calendar'));
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
        
        if (isset($this->settings['access_token'])) {
            $this->client->setAccessToken($this->settings['access_token']);
        }
    }

    public function sync_appointment($appointment_id) {
        if (!$this->client->isAccessTokenExpired()) {
            $service = new Google_Service_Calendar($this->client);
            
            $appointment = $this->get_appointment_details($appointment_id);
            
            $event = new Google_Service_Calendar_Event(array(
                'summary' => $appointment->service_name,
                'location' => $appointment->location,
                'description' => $appointment->notes,
                'start' => array(
                    'dateTime' => $appointment->start_time,
                    'timeZone' => wp_timezone_string(),
                ),
                'end' => array(
                    'dateTime' => $appointment->end_time,
                    'timeZone' => wp_timezone_string(),
                ),
                'attendees' => array(
                    array('email' => $appointment->client_email),
                    array('email' => $appointment->provider_email)
                ),
                'reminders' => array(
                    'useDefault' => true
                ),
            ));

            try {
                $service->events->insert($this->settings['calendar_id'], $event);
            } catch (Exception $e) {
                error_log('Erro ao sincronizar com Google Calendar: ' . $e->getMessage());
            }
        }
    }

    private function get_appointment_details($appointment_id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare(
            "SELECT 
                a.*,
                s.name as service_name,
                c.user_email as client_email,
                p.email as provider_email
            FROM {$wpdb->prefix}scheduling_appointments a
            JOIN {$wpdb->prefix}scheduling_services s ON a.service_id = s.id
            JOIN {$wpdb->users} c ON a.client_id = c.ID
            JOIN {$wpdb->prefix}scheduling_providers p ON a.provider_id = p.id
            WHERE a.id = %d",
            $appointment_id
        ));
    }
}