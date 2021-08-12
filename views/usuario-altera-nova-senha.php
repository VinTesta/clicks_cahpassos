<?php
require_once('../layout/cabecalho.php');

// var_dump($_POST);

$usuarioDao = new UsuarioDao($conexao);

$emailUser['emailUsuario'] = $_POST['emailUser'];

$resultado = $usuarioDao->verificaValidadeEmail($emailUser);

session_start();

$_SESSION['idusuario'] = '';

$_SESSION['emailUsuarioClicks'] = $resultado['emailUsuario'];

if(isset($_POST['btnFormAlteraSenha']) && $_POST['idUsuario'] != '' && $_POST['idUsuario'] == $resultado['idusuario']) {
?>
<div class="container-fluid d-flex justify-content-center">
        <div class="col-md-5 col-9 mt-4" id="boxLogin">
            <div class="row">
                <div class="col-12 mt-3 mb-2">
                    <p class='d-flex h3 justify-content-center mb-5' id='loginTitle'>Alterar senha</p>
                    <p class='d-flex justify-content-center fst-italic fw-lighter'>Adicione a nova senha para continuar</p>
                    <form action="../controllers/altera-senha-usuario.php" id="formLoginUsuario" method='post' class='mb-4 d-flex justify-content-center'>
                        <div class="col-8">
                            <div class="row justify-content-center mb-4">
                                <label id="passwordInput" class="p-1 label-input">
                                    <i class="fas fa-key"></i>
                                    <input type="password" name="passwordInput" id="senha" class="col-10 force-check input-form-login" placeholder="Senha">
                                </label>
                            </div>
                            <div class="row justify-content-center mb-4">
                                <label id="confirmPassword" class="p-1 label-input">
                                    <i class="fas fa-key"></i>
                                    <input type="password" name="confirmPassword" id="confirmarSenha" class="force-check input-form-login" placeholder="Confirmar Senha">
                                </label>
                            </div>
                            <div class="row justify-content-center mt-5">
                                <button name="btnConfirmarSenha" id="btnConfirmarSenha" class="button-form p-2">Alterar Senha</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    ?>

    <script type="text/javascript">
        localStorage.setItem('alerta', 'Houve um erro ao fazer a alteração de senha! (10008)')
        location = '../login/'
    </script>
    <?php
}
require_once('../layout/rodape.php');