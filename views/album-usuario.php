<?php
require_once('../layout/cabecalho.php');

verificaUsuario();

if(!isset($_POST['cont'])) {
    $idusuario = $_SESSION['idusuario'];
} else {
    $idusuario = $_SESSION['lista_usuarios'.$_POST['idSessionModal']][$_POST['cont']]['idusuario'];
    verificaUsuarioAdmin();
}


$imagemDao = new ImagemDao($conexao);

if($_SESSION['tipoUsuario'] != 2) {
    $campos_busca['statusImagem'] = 1;
}

$campos_busca['idusuario'] = $idusuario;

$imagens_grid = $imagemDao->buscaImagem($campos_busca);

$cont = 0;

?>
<div class="container-fluid" id="gridContainer">
    <div class="col-md-12">
        <div class="row justify-content-evenly">
            <div class="row mt-5 mb-4">
                <div class="col-12">
                    <h1 id="titleBiografia" class="text-center">Meu Album</h1>
                </div>
            </div>
            <div class="row justify-content-evenly">

                <?php
                $line = 0;
                foreach($imagens_grid as $img) {
                    $cont++;

                    $url = 'style="background-image: url('."'". '../web/imagens/' . $img['urlImage'] . "'".')"';

                ?>

                        <div class="col-md-4 mb-4">
                            <div class="image-grid-item d-flex" <?= $url ?> id="gridItem<?php echo $line.'.'. $cont ?>">
                                <div class="col-md-12" id="divInfoImage">
                                    <div class="row justify-content-center">
                                        <div class="col-9 mb-4 info-image-grid d-block">
                                            <p class="text-white text-center align-bottom text-truncate" id="imageDescription"><?= $img['descricao'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                <?php
                    if($cont == 3) {
                        $cont = 0;
                    ?>

                        </div>
                        <div class="row justify-content-evenly">
                    
                    <?php
                        $line++;
                    }
                }

                if($cont < 3 && $cont > 0) {
                    while($cont < 3) {
                        $cont++;
                        ?>

                        <div class="col-md-4 mb-3"></div>

                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

    <div id="divFocusImgExpand">
        <div class="col-md-5 col-12">
            <div id="divImgExpand"></div>
        </div>
    </div>

<?php
require_once('../layout/rodape.php');