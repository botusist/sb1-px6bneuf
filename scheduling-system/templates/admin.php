<?php defined('ABSPATH') or die('Acesso direto não permitido'); ?>

<div class="wrap">
    <h1>Sistema de Agendamento</h1>

    <div class="nav-tab-wrapper">
        <a href="#calendar" class="nav-tab nav-tab-active">Calendário</a>
        <a href="#services" class="nav-tab">Serviços</a>
        <a href="#providers" class="nav-tab">Profissionais</a>
        <a href="#settings" class="nav-tab">Configurações</a>
    </div>

    <div class="tab-content">
        <div id="calendar" class="tab-pane active">
            <div id="scheduling-calendar"></div>
        </div>

        <div id="services" class="tab-pane">
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Duração</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    global $wpdb;
                    $services = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}scheduling_services");
                    foreach ($services as $service) : ?>
                        <tr>
                            <td><?php echo esc_html($service->name); ?></td>
                            <td><?php echo esc_html($service->duration); ?> min</td>
                            <td>R$ <?php echo number_format($service->price, 2, ',', '.'); ?></td>
                            <td>
                                <a href="#" class="button">Editar</a>
                                <a href="#" class="button button-link-delete">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de Agendamento -->
<div id="appointment-modal" class="modal">
    <div class="modal-content">
        <form id="appointment-form">
            <input type="hidden" name="start_time">
            <input type="hidden" name="end_time">
            
            <div class="form-field">
                <label for="service">Serviço</label>
                <select name="service_id" required>
                    <?php foreach ($services as $service) : ?>
                        <option value="<?php echo esc_attr($service->id); ?>">
                            <?php echo esc_html($service->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-field">
                <label for="notes">Observações</label>
                <textarea name="notes"></textarea>
            </div>

            <button type="submit" class="button button-primary">Agendar</button>
        </form>
    </div>
</div>