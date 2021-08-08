<?php

require_once('../util/dao-loader.php');

verificaUsuarioAdmin();

$imagemDao = new ImagemDao($conexao);

if(isset($_POST['cont'])) {
    $cont = $_POST['cont'] + 1;
    $id_session = $_POST['id_session'];
    $novaImagem = $_POST['novaImagem'];

    $listaImagens = $_SESSION['lista_Main_Grid'.$id_session];
    try{
        mysqli_begin_transaction($conexao, MYSQLI_TRANS_START_READ_WRITE);

        $resposta = $imagemDao->alteraImagemGrid($novaImagem, $cont);

        if($resposta > 0) {
            $res = json_encode(array('resposta' => 'Imagem alterada com sucesso!', 'resultado' => $resposta));

        } else {
            $res = json_encode(array('resposta' => 'Houve um problema ao alterar a imagem! Tente novamente', 'resultado' => $resposta));
        }

        mysqli_commit($conexao);
        
    } catch(Exception $e) {
        $msg = mysqli_error($conexao);
        
        $res = json_encode(array('resposta' => 'Houve um problema ao alterar a imagem! Tente novamente', 'resultado' => 0));

        mysqli_rollback($conexao);
    }

    echo $res;
}