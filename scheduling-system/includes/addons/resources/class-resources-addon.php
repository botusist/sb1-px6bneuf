<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingResourcesAddon {
    public function __construct() {
        add_action('init', array($this, 'register_resources'));
        add_filter('scheduling_available_slots', array($this, 'check_resource_availability'));
    }

    public function register_resources() {
        global $wpdb;
        
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}scheduling_resources (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            capacity int NOT NULL DEFAULT 1,
            status varchar(20) DEFAULT 'active',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        )");
    }
}