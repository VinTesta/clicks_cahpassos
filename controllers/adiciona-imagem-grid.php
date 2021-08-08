<?php

require_once('../util/dao-loader.php');

$imagens = $_POST['imagens'];

$imagemDao = new ImagemDao($conexao);

$campos_busca = ['codOrdem' => ''];

try {
    mysqli_begin_transaction($conexao, MYSQLI_TRANS_START_READ_WRITE);

    $resultado = $imagemDao->buscaImagemGrid($campos_busca);

    $lastImg = end($resultado);

    $cont = $lastImg['codOrdemGrid'];

    foreach($imagens as $img) {
        if($img != '') {
            $cont++;

            $resposta[] = $imagemDao->insereImagemGrid($cont, $img);
        }
    }

    $resultado = json_encode(array('resultado' => 'Imagens adicionadas ao grid principal!', 'codRes' => 1));

    mysqli_commit($conexao);
} catch(Exception $e) {
    
    $msg = mysqli_error($conexao);
    
    $resultado = json_encode(array('resultado' => 'Houve um erro ao adicionar as imagens ao grid! Tente novamente', 'codRes' => 0));

    mysqli_rollback($conexao);
}

echo $resultado;