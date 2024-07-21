/**alterar data e hora de atendimento */
$(document).ready(function() {
    $('.btn-id-consulta').click(function() {
        let id = $(this).attr('data-id');
        $('#id_consulta').attr('value', id);
        $('#consulta').modal('show');

    })
})

//Pesq 

/*Pesquisar consulta*/

$("#buscar").keyup(function() {
        let valor = $(this).val().toLowerCase();

        $('.table-consultas tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1)
        })
    })
    /*fim*/



/*Pesquisar historico*/

$(".buscar_historico").keyup(function() {
        let valor = $(this).val().toLowerCase();

        $('.table-historico tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1)
        })
    })
    /*fim*/
    //esconder celula