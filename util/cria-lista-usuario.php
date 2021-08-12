<?php

require_once('./dao-loader.php');

verificaUsuarioAdmin();

$campos_busca = [];

$usuarioDao = new UsuarioDao($conexao);

$usuarios = $usuarioDao->buscaUsuario($campos_busca);


$optAdmin = '<optgroup label="Usuario Admin">';
$optUser = '<optgroup label="Usuario Comuns">';

foreach($usuarios as $u) {
    switch($u['tipoUsuario']) {
        case '1':
            $optUser .= "<option value=".$u['idusuario'].">".$u['nomeUsuario']."</option>";
            break;
        case '2':
            $optAdmin .= "<option value=".$u['idusuario'].">".$u['nomeUsuario']."</option>";
            break;
    }
}

$options = "<option value=''></option>".$optAdmin. '</optgroup>'.$optUser.'</optgroup>';

echo $options;
