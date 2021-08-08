<?php
require_once('../util/dao-loader.php');

$imagemDao = new ImagemDao($conexao);

$ordem = $_POST['data'];
$id_session = $_POST['id_session'];
$campos_busca['codOrdem'] = '';

try {
    mysqli_begin_transaction($conexao, MYSQLI_TRANS_START_READ_WRITE);

    $imagens = $imagemDao->buscaImagemGrid($campos_busca);

    $ordemImagens = array_slice($imagens, ($ordem));
    
    $infoImg = $_SESSION['lista_Main_Grid'.$id_session][$ordem];

    $resposta = $imagemDao->removeImagemGrid($infoImg);

    foreach($ordemImagens as $img) {
        $resposta = $imagemDao->corrigePosicaoImagem($img);

    }

    $resultado = json_encode(array('resultado' => 'Imagem removida com sucesso!', 'codRes' => 1));

    mysqli_commit($conexao);

} catch(Exception $e) {
    $msg = mysqli_error($conexao);

    $resultado = json_encode(array('resultado' => 'Houve um erro ao remover o item da lista! Tente novamente!', 'codRes' => 0));

    mysqli_rollback($conexao);
}

echo $resultado;
