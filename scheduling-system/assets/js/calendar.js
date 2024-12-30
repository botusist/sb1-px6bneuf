jQuery(document).ready(function($) {
    // Inicialização do calendário
    function initCalendar() {
        $('#scheduling-calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'agendaWeek',
            slotDuration: '00:30:00',
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
                showAppointmentForm(start, end);
            },
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: wpApiSettings.root + 'scheduling/v1/appointments',
                    method: 'GET',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
                    },
                    success: function(response) {
                        callback(response);
                    }
                });
            }
        });
    }

    // Formulário de agendamento
    function showAppointmentForm(start, end) {
        var $modal = $('#appointment-modal');
        $modal.find('input[name="start_time"]').val(start.format());
        $modal.find('input[name="end_time"]').val(end.format());
        $modal.modal('show');
    }

    // Submissão do formulário
    $('#appointment-form').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: wpApiSettings.root + 'scheduling/v1/appointments',
            method: 'POST',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
            },
            data: $(this).serialize(),
            success: function(response) {
                $('#appointment-modal').modal('hide');
                $('#scheduling-calendar').fullCalendar('refetchEvents');
                alert('Agendamento realizado com sucesso!');
            },
            error: function(xhr) {
                alert('Erro ao realizar agendamento. Tente novamente.');
            }
        });
    });

    initCalendar();
});