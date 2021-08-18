<?php
require_once("../util/dao-loader.php");

verificaUsuarioAdmin();

$usuarioDao = new UsuarioDao($conexao);

$infoUsuario = $_SESSION['lista_usuarios'.$_POST['id_session']][$_POST['cont']];

try {
    mysqli_begin_transaction($conexao, MYSQLI_TRANS_START_READ_WRITE);


    $resposta = $usuarioDao->alteraUsuario($infoUsuario, $_POST);
    
    $resposta = json_encode(array('resposta' => 'Usuario alterado com sucesso!', 'resultado' => $resultado));

    mysqli_commit($conexao);
} catch (Exception $e) {
    $msg = mysqli_error($conexao);

    $resposta = json_encode(array('resposta' => 'Houve um erro ao alterar o usuario!', 'resultado' => $resultado));

    mysqli_rollback($conexao);

}

echo $resposta;