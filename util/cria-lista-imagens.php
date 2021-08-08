<?php
require_once('./dao-loader.php');

$imagemDao = new ImagemDao($conexao);

$campos_busca = [];

$resultado = $imagemDao->buscaImagem($campos_busca);

$options = '<option value=""></option>';

foreach($resultado as $imagem) {
    $options .= '<option value="'.$imagem['idimagem'].'">'.$imagem['nomeImagem'].'</option>';
}

echo $options;