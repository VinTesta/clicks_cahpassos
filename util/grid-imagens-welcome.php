<?php
require_once('./dao-loader.php');

$imagemDao = new ImagemDao($conexao);

$campos_busca = ['codOrdem' => $_POST['order']];

$info_usuario = array('tipoUsuario' => $_SESSION['tipoUsuario']);

$imagens_grid = $imagemDao->buscaImagemGrid($campos_busca, $info_usuario);

$cont = 0;
?>

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

        <div class="col-md-4 mb-4">
            <div class="image-grid-item d-flex" style="background-color: #f2f2f2">
            </div>
        </div>

        <?php
    }
}
?>
    </div>