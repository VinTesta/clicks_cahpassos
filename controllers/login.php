<?php
if(!isset($_SESSION['idusuario'])) {
    require_once('../util/dao-loader.php');
    if(isset($_POST['emailUsuario'])) {
        try{

            mysqli_begin_transaction($conexao, MYSQLI_TRANS_START_READ_WRITE);

            $usuarioDao = new UsuarioDao($conexao);
        
            $resultado = $usuarioDao->verificaValidadeEmail($_POST);
        
            if($resultado != '') {
                if(password_verify($_POST['senhaUsuario'], $resultado['senhaUsuario'])) {
        
                    session_start();
                    $_SESSION = array('idusuario' => $resultado['idusuario'], 'nomeUsuario' => $resultado['nomeUsuario'], 'emailUsuarioClicks' => $resultado['emailUsuario'], 'dataCriacao' => $resultado['dataCriacao'], 'tipoUsuario' => $resultado['tipoUsuario']);
        
                    ?>
                    <script type="text/javascript">
                        localStorage.setItem('alerta', 'Logado com sucesso!');
                        location = '../welcome/'
                    </script>
                    <?php
        
                    $usuarioDao->logarUsuario($resultado);
                } else {
                    ?>
                    <script type="text/javascript">
                        localStorage.setItem('alerta', 'O e-mail ou senha estão incorretos!');
                        location = '../login/'
                    </script>
                    <?php
                }
            } else {
                ?>
                <script type="text/javascript">
                    localStorage.setItem('alerta', 'Este usuario não existe! Caso ache que isso é um erro entre em contato com nosso suporte');
                    location = '../login/'
                </script>
                <?php
            }

            mysqli_commit($conexao);

        } catch(Exception $e) {

            $msg = mysqli_error($conexao);

            mysqli_rollback($conexao);

            ?>
            <script type="text/javascript">
                localStorage.setItem('alerta', 'Houve um erro ao realizar login! Tente novamente!')
                location = '../login/'
            </script>
            <?php
        }
    }
} else {
    ?>
    <script type="text/javascript">
        location = '../'
    </script>
    <?php
}