<?php
require_once('../util/dao-loader.php');

$imagemDao = new ImagemDao($conexao);

$id_session = $_POST['id_session'];
$cont = $_POST['cont'];

$imagem = $_SESSION['lista_images'.$id_session][$cont];

$nomeImagem = $_POST['nomeImagem'];
$descricao = $_POST['descricao'];
$statusImagem = $_POST['statusImagem'];

try {

    mysqli_begin_transaction($conexao, MYSQLI_TRANS_START_READ_WRITE);

    $resultado = $imagemDao->alteraImagem($imagem, $nomeImagem, $descricao, $statusImagem);

    $resposta = json_encode(array('resposta' => 'Imagem alterada com sucesso!', 'resultado' => $resultado));

    mysqli_commit($conexao);
    
} catch(Exception $e) {
    $msg = mysqli_error($conexao);

    $resposta = json_encode(array('resposta' => 'Houve um erro ao alterar a imagem!', 'resultado' => $resultado));

    mysqli_rollback($conexao);
}

echo $resposta;
