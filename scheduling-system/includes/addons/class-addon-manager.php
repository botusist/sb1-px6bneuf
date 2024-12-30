<?php
defined('ABSPATH') or die('Acesso direto não permitido');

class SchedulingAddonManager {
    private $active_addons = array();

    public function __construct() {
        add_action('init', array($this, 'load_active_addons'));
    }

    public function load_active_addons() {
        $this->active_addons = array(
            'mercadopago' => new SchedulingMercadoPagoAddon(),
            'custom_fields' => new SchedulingCustomFieldsAddon(),
            'resources' => new SchedulingResourcesAddon(),
            'recurring' => new SchedulingRecurringAddon(),
            'reminders' => new SchedulingRemindersAddon(),
            'packages' => new SchedulingPackagesAddon(),
            'coupons' => new SchedulingCouponsAddon(),
            'locations' => new SchedulingLocationsAddon(),
            'groups' => new SchedulingGroupBookingsAddon()
        );
    }
}