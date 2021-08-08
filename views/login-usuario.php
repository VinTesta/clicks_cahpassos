<?php
require_once('../layout/cabecalho.php');

if(!isset($_SESSION['idusuario'])) {
    

 ?>
    <div class="container-fluid d-flex justify-content-center">
        <div class="col-md-7 col-9 mt-4" id="boxLogin">
            <div class="row">
                <div class="col-md-5 col-12 mt-3 mb-2">
                    <p class='d-flex h1 justify-content-center mb-5' id='loginTitle'>Login</p>
                    <form action="../controllers/login.php" id="formLoginUsuario" method='post' class='mb-4 mt-5 d-flex justify-content-center'>
                        <div class="col-10">
                            <div class="row justify-content-center mb-4">
                                <label id="userInput" class="p-1 label-input">
                                    <i class="fas fa-user"></i>
                                    <input type="email" name="emailUsuario" class="force-check input-form-login" placeholder="E-mail">
                                </label>
                            </div>
                            <div class="row justify-content-center mb-4">
                                <label id="passwordInput" class="p-1 label-input">
                                    <i class="fas fa-key"></i>
                                    <input type="password" name="senhaUsuario" class="force-check input-form-login" placeholder="Senha">
                                </label>
                            </div>
                            <div class="row justify-content-center mt-5">
                                <button name="btnLogin" id="btnLogin" class="button-form p-2">Sing in</button>
                                <a href="../cadastro/" id="link-cadastro">Não tem uma conta? Cadastre-se já</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-7" id="imagem-login">

                </div>
            </div>
        </div>
    </div>
    <div class="p-5 col-md-12 mb-5"></div>
       

<?php
    
} else {
    ?>
    <script type="text/javascript">
        location.href = " ../"
    </script>
    <?php
}
require_once('../layout/rodape.php');
?>