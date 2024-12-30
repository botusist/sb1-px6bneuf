<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingPackagesAddon {
    public function __construct() {
        add_action('init', array($this, 'register_packages'));
        add_filter('scheduling_service_options', array($this, 'add_package_options'));
    }

    public function register_packages() {
        global $wpdb;
        
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}scheduling_packages (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            services text NOT NULL,
            price decimal(10,2) NOT NULL,
            validity_days int,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        )");
    }
}