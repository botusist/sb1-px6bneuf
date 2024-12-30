<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingReportGenerator {
    public function generate_financial_report($start_date, $end_date) {
        global $wpdb;
        
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT 
                s.name as service_name,
                COUNT(*) as total_appointments,
                SUM(s.price) as total_revenue
            FROM {$wpdb->prefix}scheduling_appointments a
            JOIN {$wpdb->prefix}scheduling_services s ON a.service_id = s.id
            WHERE a.status = 'confirmed'
            AND a.start_time BETWEEN %s AND %s
            GROUP BY s.id",
            $start_date,
            $end_date
        ));

        return $results;
    }

    public function generate_provider_report($provider_id, $start_date, $end_date) {
        global $wpdb;
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT 
                DATE(a.start_time) as date,
                COUNT(*) as appointments,
                SUM(s.price) as revenue
            FROM {$wpdb->prefix}scheduling_appointments a
            JOIN {$wpdb->prefix}scheduling_services s ON a.service_id = s.id
            WHERE a.provider_id = %d
            AND a.start_time BETWEEN %s AND %s
            GROUP BY DATE(a.start_time)",
            $provider_id,
            $start_date,
            $end_date
        ));
    }
}