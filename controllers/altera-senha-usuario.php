<?php
require_once('../util/dao-loader.php');

$novaSenha = $_POST['passwordInput'];
$confirmaNovaSenha = $_POST['confirmPassword'];

session_start();

$emailUsuario['emailUsuario'] = $_SESSION['emailUsuarioClicks'];

session_destroy();
if($emailUsuario['emailUsuario'] != '' && $novaSenha == $confirmaNovaSenha) {
    try {
        mysqli_begin_transaction($conexao, MYSQLI_TRANS_START_READ_WRITE);

        $usuarioDao = new UsuarioDao($conexao);
        
        $infoUsuario = $usuarioDao->verificaValidadeEmail($emailUsuario);

        $resposta = $usuarioDao->alteraSenhaUsuario($infoUsuario, $novaSenha);
        // var_dump($resposta);

        if($resposta > 0) {
            ?>
            <script type="text/javascript">
                localStorage.setItem('alerta', 'Senha alterada com sucesso! Faça login para utilizar sua conta!')
                location = '../login/'
            </script>
            <?php
        } else {
            ?>
            <script type="text/javascript">
                localStorage.setItem('alerta', 'Houve um erro ao alterar a senha!')
                location = '../login/'
            </script>
            <?php
        }

        mysqli_commit($conexao);
    } catch(Exception $e) {
        $msg = mysqli_error($conexao);

        ?>
        <script type="text/javascript">
            localStorage.setItem('alerta', 'Houve um erro ao alterar a senha!')
            location = '../login/'
        </script>
        <?php

        mysqli_rollback($conexao);
    }
    
} else {
    ?>
    <script type="text/javascript">
        localStorage.setItem('alerta', 'Houve um erro ao alterar a senha!')
        location = '../login/'
    </script>
    <?php
}
