<?php defined('ABSPATH') or die('Acesso direto não permitido'); ?>

<div class="wrap">
    <h1>Configurações do Google Calendar</h1>
    
    <form method="post" action="options.php">
        <?php settings_fields('scheduling_google_calendar_settings'); ?>
        
        <table class="form-table">
            <tr>
                <th scope="row">Client ID</th>
                <td>
                    <input type="text" name="scheduling_google_calendar_settings[client_id]" 
                           value="<?php echo esc_attr($settings['client_id']); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">Client Secret</th>
                <td>
                    <input type="password" name="scheduling_google_calendar_settings[client_secret]" 
                           value="<?php echo esc_attr($settings['client_secret']); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">Calendar ID</th>
                <td>
                    <input type="text" name="scheduling_google_calendar_settings[calendar_id]" 
                           value="<?php echo esc_attr($settings['calendar_id']); ?>" class="regular-text">
                    <p class="description">Use "primary" para o calendário principal ou o ID do calendário específico</p>
                </td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    </form>
    
    <?php if (!$is_connected) : ?>
        <a href="<?php echo esc_url($auth_url); ?>" class="button button-primary">
            Conectar com Google Calendar
        </a>
    <?php else : ?>
        <p>✅ Conectado ao Google Calendar</p>
        <a href="<?php echo esc_url($disconnect_url); ?>" class="button">
            Desconectar
        </a>
    <?php endif; ?>
</div>