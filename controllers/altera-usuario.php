<?php
require_once("../util/dao-loader.php");

verificaUsuarioAdmin();

$usuarioDao = new UsuarioDao($conexao);

$infoUsuario = $_SESSION['lista_usuarios'.$_POST['id_session']][$_POST['cont']];

try {
    
} catch (Exception $e) {

}
$resposta = $usuarioDao->alteraUsuario($infoUsuario, $_POST);