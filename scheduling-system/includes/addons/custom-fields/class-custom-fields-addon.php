<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingCustomFieldsAddon {
    public function __construct() {
        add_action('init', array($this, 'register_custom_fields'));
        add_filter('scheduling_appointment_form_fields', array($this, 'add_custom_fields'));
    }

    public function register_custom_fields() {
        global $wpdb;
        
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}scheduling_custom_fields (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            type varchar(50) NOT NULL,
            required tinyint(1) DEFAULT 0,
            options text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        )");
    }
}