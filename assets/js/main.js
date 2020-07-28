const BACKEND = './backend/index.php'
$(()=>{
    preencherTabela()
})
const preencherTabela = ( ) => {
    $.ajax({
        url: BACKEND,
        type: 'post',
        data: {
            acao: 'listagem'
        },
        dataType: 'json'
    }).then( response => {
        const lines = rows( response )
        $('.tbody').find('tr').remove()
        $('.tbody').append( lines )
    })
}

const rows = dados => {
    const line = dados.map( d => {
        const updateButton = createButton('Atualizar', 'warning')
        updateButton.click(() => loadPlace(d))
        const removeButton = createButton('Excluir', 'danger')
        removeButton.click(() => removePlace(d))
        const lineColor = d.uf == 'MG' ? 'mg' : ''
        return $('<tr>')
                .attr('data-id', d.id)
                .addClass(lineColor)
                .append( $('<td>').append( d.nome ) )
                .append( $('<td>').append( d.data ) )
                .append($('<td>').append(updateButton).append(removeButton))

    })
    return line
}

const loadPlace = place => {
    location.href= `./local.html?id=${place.id}`
}


const createButton = (label, type) => {
    return $('<button>').addClass(`btn btn-xs`).html(label)
}

const removePlace = place => {
    const confirmar = confirm('Deseja realmente remover esse lugar?')
    console.log('ALERT', confirmar);
    
    if( confirmar == true ){

        $.ajax({
            type: 'post',
            url: BACKEND,
            type: 'post',
            data: {
                acao: 'remover',
                id: place.id
            },
            dataType: 'json'
        }).then(response => {
            alert(response.msg)
            preencherTabela()
        })
    }
}

