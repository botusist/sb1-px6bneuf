<?php
/**
 * Plugin Name: Sistema de Agendamento
 * Description: Sistema completo de agendamento para WordPress
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL v2 or later
 */

defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingSystem {
    public function __construct() {
        register_activation_hook(__FILE__, array($this, 'activate'));
        add_action('init', array($this, 'init'));
        add_action('admin_menu', array($this, 'admin_menu'));
    }

    public function activate() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = array();

        // Tabela de Serviços
        $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}scheduling_services (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            description text NOT NULL,
            duration int NOT NULL,
            price decimal(10,2) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        // Tabela de Profissionais
        $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}scheduling_providers (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            user_id bigint(20) unsigned NOT NULL,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            phone varchar(50) NOT NULL,
            specialization varchar(255) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (user_id) REFERENCES {$wpdb->users}(ID)
        ) $charset_collate;";

        // Tabela de Agendamentos
        $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}scheduling_appointments (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            service_id bigint(20) unsigned NOT NULL,
            provider_id bigint(20) unsigned NOT NULL,
            client_id bigint(20) unsigned NOT NULL,
            start_time datetime NOT NULL,
            end_time datetime NOT NULL,
            status enum('pending','confirmed','cancelled') DEFAULT 'pending',
            notes text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (service_id) REFERENCES {$wpdb->prefix}scheduling_services(id),
            FOREIGN KEY (provider_id) REFERENCES {$wpdb->prefix}scheduling_providers(id),
            FOREIGN KEY (client_id) REFERENCES {$wpdb->users}(ID)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        foreach ($sql as $query) {
            dbDelta($query);
        }
    }

    public function init() {
        $this->register_post_types();
        $this->register_scripts();
    }

    public function admin_menu() {
        add_menu_page(
            'Agendamentos',
            'Agendamentos',
            'manage_options',
            'scheduling-system',
            array($this, 'admin_page'),
            'dashicons-calendar-alt'
        );
    }

    private function register_post_types() {
        // Registro de Custom Post Types se necessário
    }

    private function register_scripts() {
        wp_register_script(
            'scheduling-calendar',
            plugins_url('assets/js/calendar.js', __FILE__),
            array('jquery'),
            '1.0.0',
            true
        );

        wp_register_style(
            'scheduling-styles',
            plugins_url('assets/css/styles.css', __FILE__),
            array(),
            '1.0.0'
        );
    }

    public function admin_page() {
        include plugin_dir_path(__FILE__) . 'templates/admin.php';
    }
}

new SchedulingSystem();