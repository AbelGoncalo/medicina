/**  ---------------------Esconder Formularios------------------------ */
const formHereditaria = document.querySelector('.formHereditaria');
const formAlergia = document.querySelector('.formAlergia');

formHereditaria.style.display = "none";
formAlergia.style.display = "none";
/**--------------------------------------------------------------- */

/**Funcao para esconder formulario  ou mostrar formulario*/
function forms(form, btn, action, btnHide) {

    let formHereditaria = document.querySelector(form);
    let showfirstForm = document.querySelector(btn);


    formHereditaria.style.display = action;
    showfirstForm.style.display = btnHide;
}
/**------------------------------------------------------- */
let showfirstForm = document.querySelector('.showfirstForm');
showfirstForm.addEventListener('click', () => {
    //chamar a funcao para mostrar / esconder formulario
    forms('.formHereditaria', '.showfirstForm', 'block', 'none');
})
let cancelFirstOperation = document.querySelector('.cancelFirstOperation');
cancelFirstOperation.addEventListener('click', () => {

    //chamar a funcao para mostrar / esconder formulario
    forms('.formHereditaria', '.showfirstForm', 'none', 'block');



});
let showSecondForm = document.querySelector('.showSecondForm');
showSecondForm.addEventListener('click', () => {
    forms('.formAlergia', '.showSecondForm', 'block', 'none');
})

let cancelSecondOperation = document.querySelector('.SecondOperation');
cancelSecondOperation.addEventListener('click', () => {

    //chamar a funcao para mostrar / esconder formulario
    forms('.formAlergia', '.showSecondForm', 'none', 'block');


});
/** funcao para adicionar checkbox na pagina */
function addCheckbox(container, input, nameCheck) {
    let checkbox = document.createElement('input');
    let label = document.createElement('label');
    let br = document.createElement('br');
    let Input = document.querySelector(input);
    let Container = document.querySelector(container);

    checkbox.setAttribute('type', 'checkbox');
    checkbox.setAttribute('checked', 'true');
    checkbox.setAttribute('name', nameCheck);
    checkbox.setAttribute('class', 'fild');
    checkbox.style.marginRight = '1.5rem'
    label.innerHTML = Input.value;


    if (Input.value != "") {
        /** adicionar os objectos na pagina */
        checkbox.value = document.querySelector(input).value;
        Container.appendChild(checkbox);
        Container.appendChild(label);
        Container.appendChild(br);





    }


}

let firstAdd = document.querySelector('.firstAdd');
firstAdd.addEventListener('click', () => {
    addCheckbox('.firstContainer', '#firstInput', 'historico_saude[]');
    document.querySelector('#firstInput').value = '';

})

let secondAdd = document.querySelector('.secondAdd');
secondAdd.addEventListener('click', () => {
    addCheckbox('.secondContainer', '#secondInput', 'alergias[]');
    document.querySelector('#secondInput').value = '';
})

/*** Adicionar doenca hereditaria */
$('#formHereditaria').submit(function(e) {

    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/doenca",
        dataType: "json",
        data: $('#formHereditaria').serialize(),
        success: function(response) {
            allHistorico();
        },
        error: function() {
            console.log('error')
        }
    })

})


/*** Listar doencas hereditaris */
function allHistorico() {
    let id = $('#id').val();
    $.ajax({
        type: "GET",
        url: "/utente/historico/" + id,
        dataType: "json",
        success: function(response) {
            console.log();
            let data = "";
            if (response.historico_saude === null) {
                data += "<p>Nenhuma adicionada</p>";
                $('.opcoes').html(data)
                $('.lista-alergia').html(data)

            }
            $.each(response.historico_saude, function(key, value) {

                data += "<li class='fa fa-check fa h5'>   " + value + "</li>";
                data += "<br>";

            });
            $('.opcoes').html(data)
        },
        error: function() {
            console.log("error");
        }
    })
}
allHistorico();
allAlergias();
/**Listar alergias   e grupo sanguinio*/
function allAlergias() {
    let id = $('#id').val();
    $.ajax({
        type: "GET",
        url: "/utente/alergias/" + id,
        dataType: "json",
        success: function(response) {
            console.log();
            let data = "";
            if (response.alergias === null) {

                data += "<p>Nenhuma adicionada</p>";
                $('.lista-alergia').html(data)
            }
            $.each(response.alergias, function(key, value) {

                data += "<li class='fa fa-check fa h5'>   " + value + "</li>";
                data += "<br>";

            });
            $('.lista-alergia').html(data)
            $('.grupo-sanguinio').text(response.grupo_sanguinio);
        },
        error: function() {
            console.log("error");
        }
    })
}



/**Adicionar alergias */
$('#formAlergia').submit(function(e) {

    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/alergia",
        dataType: "json",
        data: $('#formAlergia').serialize(),
        success: function(response) {
            console.log(response);
            allAlergias();
        },
        error: function() {
            console.log('error')
        }
    })

})