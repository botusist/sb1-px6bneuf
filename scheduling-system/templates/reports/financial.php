<?php defined('ABSPATH') or die('Acesso direto não permitido'); ?>

<div class="wrap">
    <h1>Relatório Financeiro</h1>

    <form method="get">
        <input type="hidden" name="page" value="scheduling-reports">
        <div class="tablenav top">
            <div class="alignleft actions">
                <input type="date" name="start_date" value="<?php echo esc_attr($start_date); ?>">
                <input type="date" name="end_date" value="<?php echo esc_attr($end_date); ?>">
                <input type="submit" class="button" value="Filtrar">
            </div>
        </div>
    </form>

    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>Serviço</th>
                <th>Total de Agendamentos</th>
                <th>Receita Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report_data as $row) : ?>
                <tr>
                    <td><?php echo esc_html($row->service_name); ?></td>
                    <td><?php echo esc_html($row->total_appointments); ?></td>
                    <td>R$ <?php echo number_format($row->total_revenue, 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>