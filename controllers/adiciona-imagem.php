<?php
require_once('../util/dao-loader.php');

$imagemDao = new ImagemDao($conexao);

$cont = $_POST['contImg'];
$imagens = [];

for($i = 0; $i < $cont; $i++) {
    $imagens[] = array('urlImg' => $_FILES['imagensAdd'.$i], 
                        'nomeImagem' => $_POST['nomeImagem'.$i], 
                        'statusImg' => $_POST["statusImg".$i], 
                        "idusuario" => $_POST["idusuario".$i], 
                        'descImg' => $_POST["descricaoImagem".$i]);
}

try {
    
    mysqli_begin_transaction($conexao, MYSQLI_TRANS_START_READ_WRITE);

    foreach($imagens as $key => $img) {
        $ext = explode('/',$img['urlImg']['type']);

        $imgName = sha1(microtime().$key).'.'.$ext[1];

        $resposta = $imagemDao->insereImagem($img, $imgName);

        copy($img['urlImg']['tmp_name'], '../web/imagens/'.$imgName);
    }

    ?>
    <script type="text/javascript">
        localStorage.setItem('alerta', 'Imagem(ns) adicionada(s) com sucesso!')
        location = '../imagens/'
    </script>
    <?php

    mysqli_commit($conexao);
} catch(Exception $e) {
    $msg = mysqli_error($conexao);
    ?>
    <script type="text/javascript">
        localStorage.setItem('alerta', 'Houve um erro ao adicionar as imagens!')
        location = '../imagens/'
    </script>
    <?php
    mysqli_rollback($conexao);
}