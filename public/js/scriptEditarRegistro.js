/** Editar Especialidade */

$(document).ready(function() {
    var table = $('#tabelaEspecialidade').DataTable({
        searching: false,
        ordering: false,
        paging: false,
        pageLength: false
    });

    /*Pegar os dados da tabela*/
    table.on('click', '.edit', function() {
        $tr = $(this).closest('tr');
        if ($($tr).hasClass('child')) {
            $tr = $tr.prev('.parent');
        }

        var data = table.row($tr).data();
        console.log(data);
        $('#EditEspecialidade').val(data[1]);
        $('#EditImagem').attr('src', 'storage/especialidade/' + data[2]);
        $('#id').attr('value', data[0]);
        $('#editModal').modal('show');
    });
    $('.img').hide();
});

/**----------------------- */
/**editar Medico */
$(document).ready(function() {

    var table = $('#tabelaMedico').DataTable({
        searching: false,
        ordering: false,
        paging: false,
        pageLength: false
    });
    table.on('click', '.editMedico', function() {
        var $tr = $(this).closest('tr');
        if ($($tr).hasClass('child')) {
            $tr = $tr.prev('.parent');
        }

        let data = table.row($tr).data();
        console.log(data);
        $('#nome').val(data[1]);
        $('#sexo').val(data[2]);
        $('#nascimento').val(data[3]);
        $('#bi').val(data[4]);
        $('#especialidade').val(data[5]);
        $('#telefone').val(data[6]);
        $('#email').val(data[7]);
        $('#morada').val(data[8]);
        $('#localidade').val(data[9]);
        $('#codigo_postal').val(data[10]);
        $('#id_medico').attr('value', data[0]);


        $('#EditMedicoModal').modal('show');

        $('.hide').hide();





    });
});




/** */

/** Editar Exame */

$(document).ready(function() {
    var table = $('#tabelaExame').DataTable({
        searching: false,
        ordering: false,
        paging: false,
        pageLength: false,
        showing: false
    });

    /*Pegar os dados da tabela*/
    table.on('click', '.editExame', function() {
        $tr = $(this).closest('tr');
        if ($($tr).hasClass('child')) {
            $tr = $tr.prev('.parent');
        }

        var data = table.row($tr).data();
        console.log(data);
        $('#nomeExame').val(data[1]);
        $('#id_especialidadeExame').val(data[2]);
        $('#id_Exame').attr('value', data[0]);
        $('#exameModal').modal('show');
    });
    $('.img').hide();
});
/**--------------------------------------------------------------------- */



/** Pegar dados da tabela para enviar email para utente*/

$(document).ready(function() {
    var table = $('.table-utente  ').DataTable({
        searching: false,
        ordering: false,
        paging: false,
        pageLength: false,
        showing: false
    });

    /*Pegar os dados da tabela*/
    table.on('click', '#btn-email', function() {
        $tr = $(this).closest('tr');
        if ($($tr).hasClass('child')) {
            $tr = $tr.prev('.parent');
        }

        var data = table.row($tr).data();
        console.log(data);
        $('#titleModal').text(data[6])
        $('#email').attr('value', data[6]);
        $('#enviarEmailModal').modal('show');
    });

});



/**------------------------------ */
$(document).ready(function() {
    $('.btn-consultas').click(function() {
        let id = $(this).attr('data-id');
        $('#id_consulta').attr('value', id);
        $('#consulta').modal('show');

    })
})


/**definir data e hora de atendimento */

/*-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- */