<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingDatabaseManager {
    public function __construct() {
        add_action('plugins_loaded', array($this, 'check_version'));
    }

    public function check_version() {
        if (get_site_option('scheduling_db_version') != SCHEDULING_VERSION) {
            $this->update_database();
        }
    }

    private function update_database() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        // Adiciona tabela de avaliações
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}scheduling_reviews (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            appointment_id bigint(20) unsigned NOT NULL,
            rating int NOT NULL,
            comment text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (appointment_id) REFERENCES {$wpdb->prefix}scheduling_appointments(id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        update_site_option('scheduling_db_version', SCHEDULING_VERSION);
    }
}