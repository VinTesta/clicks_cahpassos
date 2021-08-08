<?php
require_once('../util/dao-loader.php');

try{

    logout();

    ?>
    <script type="text/javascript">
        localStorage.setItem('alerta', 'Deslogado com sucesso!');
        location = '../welcome/'
    </script>
    <?php

} catch(Exception $e) {
    ?>
    <script type="text/javascript">
        localStorage.setItem('alerta', 'Houve um erro ao deslogar!');
        location = '../welcome/'
    </script>
    <?php
}
