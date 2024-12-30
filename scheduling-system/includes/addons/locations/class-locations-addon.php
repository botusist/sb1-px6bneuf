<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingLocationsAddon {
    public function __construct() {
        add_action('init', array($this, 'register_locations'));
        add_filter('scheduling_appointment_options', array($this, 'add_location_field'));
    }

    public function register_locations() {
        global $wpdb;
        
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}scheduling_locations (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            address text NOT NULL,
            city varchar(100) NOT NULL,
            state varchar(50) NOT NULL,
            postal_code varchar(20) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        )");
    }
}