<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingGoogleCalendar {
    private $client;

    public function __construct() {
        // Inicializa cliente Google Calendar API
        require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
        $this->client = new Google_Client();
        $this->client->setAuthConfig(plugin_dir_path(__FILE__) . 'credentials.json');
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
    }

    public function sync_appointment($appointment_id) {
        $appointment = $this->get_appointment($appointment_id);
        
        $event = new Google_Service_Calendar_Event(array(
            'summary' => $appointment->service_name,
            'description' => $appointment->notes,
            'start' => array(
                'dateTime' => $appointment->start_time,
                'timeZone' => wp_timezone_string(),
            ),
            'end' => array(
                'dateTime' => $appointment->end_time,
                'timeZone' => wp_timezone_string(),
            ),
        ));

        $calendar = new Google_Service_Calendar($this->client);
        $calendar->events->insert('primary', $event);
    }
}