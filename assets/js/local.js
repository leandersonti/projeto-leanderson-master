const BACKEND = './backend/index.php'
$(()=>{
    $('.cep').mask('00.000-000');

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const placeId = urlParams.get('id')
    if( placeId != null ){
        getPlaceById( placeId )
    }else{
        $('span.title').text('Inserir')
    }
})

 getPlaceById = id =>{

    $.ajax({
        url: BACKEND,
        type: 'post',
        data: {
            acao: 'porid',
            id
        },
        dataType: 'json'
    }).then(response => {
        $('span.title').text('Editar')
        $('#id').val( id )
        $('#nome').val( response.nome )
        $('#cep').val( response.cep )
        $('#logradouro').val( response.logradouro )
        $('#numero').val( response.numero )
        $('#complemento').val( response.complemento )
        $('#bairro').val( response.bairro )
        $('#cidade').val( response.cidade )
        $('#uf').val( response.uf )
        $('#data').val( response.data )

    })

}

$('.cep').on('blur', function(){
    buscarCEP( $(this).val().replace('.','').replace('-','') )
})

const buscarCEP = cep =>{
    $.ajax({
        url: BACKEND,
        type: 'post',
        data: {
            acao: 'cep',
            cep
        },
        dataType: 'json'
    }).then( response => {
        $('.logradouro').val( response.logradouro )
        $('.cidade').val( response.localidade )
        $('.uf').val( response.uf )
        $('.bairro').val( response.bairro )
    })
}

$('.btn-save').on('click', function(e) {
    e.preventDefault(); 
    salvar()
})

const salvar = () => {
    
    const acao = $('#id').val() == 0 ? 'insert' : 'update'
    
    const dados = {
        id: $('#id').val(),
        nome: $('#nome').val(),
        cep: $('#cep').val().replace('.','').replace('-',''),
        logradouro: $('#logradouro').val(),
        numero: $('#numero').val(),
        complemento: $('#complemento').val(),
        bairro: $('#bairro').val(),
        uf: $('#uf').val(),
        cidade: $('#cidade').val(),
        data: $('#data').val(),
        acao
    }

    $.ajax({
        url: BACKEND,
        type: 'post',
        data: dados,
        dataType: 'json'
    }).then(response => {
        alert( response.msg )
        window.location.href = "http://localhost/projeto-leanderson-master/index.html"


        
    })
    
}
$('.nome').on('blur', function(){
    verificarForm()
})

$('.cep').on('blur', function(){
    verificarForm()
})
$('.logradouro').on('blur', function(){
    verificarForm()
})

$('.numero').on('blur', function(){
    verificarForm()
})

$('.bairro').on('blur', function(){
    verificarForm()
})
$('.complemento').on('blur', function(){
    verificarForm()
})
$('.cidade').on('blur', function(){
    verificarForm()
})
$('.uf').on('blur', function(){
    verificarForm()
})

$('#data').on('change', function(){
    verificarForm()
})

const verificarForm = () => {
    const button = verificarFormulario()
    console.log('button', button);
    
    if(  verificarFormulario() ) {
        $('.btn-save').removeAttr('disabled')
    }
    else{
        $('.btn-save').attr('disabled')
    }
}

const verificarFormulario = () => {
    
    if( ($('#nome').val() == '') || ($('#cep').val() == '') || ($('#logradouro').val() == '') 
        || ($('#numero').val() == '') || ($('#complemento').val() == '') || ($('#bairro').val() == '')
        || ($('#cidade').val() == '') || ($('#uf').val() == '') || ($('#data').val() == '')
    )
    return false
    
    else return true
}

