<?php

function usuarioEstaLogado() {
    return isset($_SESSION["idusuario"]);
}

function verificaUsuario() {
    if (!usuarioEstaLogado()) {
        ?>
        <script type="text/javascript">
            location.href = " ../"
        </script>
        <?php

        die();
    } else {
        return TRUE;
    }
}

function usuarioLogado() {
    return $_SESSION["idusuario"];
}

function verificaUsuarioAdmin() {
    if (usuarioEstaLogado() && $_SESSION['tipoUsuario'] == 2) {
        
        return TRUE;
    } else {

        ?>
        <script type="text/javascript">
            location.href = " ../"
        </script>
        <?php

        session_destroy();
        die();
    }
}

function logout() {
    session_start();
    session_destroy();
}

session_start();

if(isset($_SESSION['idusuario']) && !isset($_SESSION['emailUsuarioClicks'])) {
    session_destroy();
    ?>
    <script type="text/javascript">
        localStorage.setItem('alerta', 'Houve um erro! Tente fazer login novamente! (10001)')
        location.href = " ../"
    </script>
    <?php
}