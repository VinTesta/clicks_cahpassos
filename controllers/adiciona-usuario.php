<?php
require_once('../util/dao-loader.php');

if(isset($_POST['emailUsuario'])) {
    $usuarioDao = new UsuarioDao($conexao);

    try {
        mysqli_begin_transaction($conexao, MYSQLI_TRANS_START_READ_WRITE);

        $resposta = $usuarioDao->verificaValidadeEmail($_POST);

        if(empty($resposta)) {
            $id_usuario = $usuarioDao->insereUsuario($_POST);

            if($id_usuario != '') {
                ?>
                <script type="text/javascript">
                    localStorage.setItem('alerta', 'Conta criada com sucesso faça login para continuar')
                    location = '../login/'
                </script>
                <?php
            }
        } else {
            ?>
            <script type="text/javascript">
                localStorage.setItem('alerta', 'Este e-mail já está vinculado a uma conta existente!')
                location = '../cadastro/'
            </script>
            <?php
        }

        mysqli_commit($conexao);

    } catch(Exception $e) {
        $msg = mysqli_error($conexao);

        mysqli_rollback($conexao);

        ?>
        <script type="text/javascript">
            localStorage.setItem('alerta', 'Houve um erro ao realizar o cadastro! Tente novamente!')
            location = '../cadastro/'
        </script>
        <?php
    }
}
