<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';
use Jarouche\ViaCEP\HelperViaCep;

$acao = $_POST['acao'];

switch ($acao) {
    case 'insert':
        insert( $_POST );
        break;
    case 'update':
        update( $_POST );
        break;
    case 'remover':
        
        remover( $_POST['id'] );
        break;
        case  'cep':    
    case  'cep':
        buscarCEP($_POST['cep']);
        break;
    case  'listagem':
        listagem();
        break;    
    case  'porid':
        getById($_POST['id']);
         break;    
        
    default:
        # code...
        break;
}

function insert($dados)
{
    require_once('./dao/class.local.php');
    $localDAO = new LocaisDAO();
    $retorno = $localDAO->insert( $dados );
    echo json_encode( $retorno );

}

function update($dados)
{
    require_once('./dao/class.local.php');
    $localDAO = new LocaisDAO();
    $retorno = $localDAO->update( $dados );
    echo json_encode( $retorno );
}

function remover($dados)
{
    require_once('./dao/class.local.php');
    $localDAO = new LocaisDAO();
    $retorno = $localDAO->delete( $dados );
    echo json_encode( $retorno );
}

function buscarCEP($cep)
{
    $class = new Jarouche\ViaCEP\BuscaViaCEPJSONP();
    
    $result = $class->retornaCEP( $cep );
    echo json_encode( $result );
}

function listagem()
{
    require_once('./dao/class.local.php');
    $localDAO = new LocaisDAO();
    $retorno = $localDAO->listaDeLocais(  );
    echo json_encode( $retorno );
}

function getById( $id )
{
    require_once('./dao/class.local.php');
    $localDAO = new LocaisDAO();
    $retorno = $localDAO->getById( $id );
    echo json_encode( $retorno );
}

?>