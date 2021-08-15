<?php
require_once('./dao-loader.php');

$tipo = $_POST['tipo'];

switch($tipo) {
    case '1':
        $cont = $_POST['data'];
        $id_session = $_POST['id_session'];

        $imagem = $_SESSION['lista_Main_Grid'.$id_session][$cont];
        // MODAL DE ALTERAÇÃO DE IMAGEM DO GRID PRINCIPAL
        ?>
            <div class="modal-header">
                <h5 class="modal-title">Alterar Imagem <?= $cont + 1?></h5>
                <button type="button" class="button-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="idSessionModal" value="<?= $id_session ?>">
                <input type="hidden" id="cont" value="<?= $cont ?>">

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="alterarImagemGrid">Selecione uma imagem para alterar:</label>
                        <label class="label-input col-12">
                            <select id="alterarImagemGrid" class="force-check input-form col-12">
                                <option value="" selected></option>
                            </select>
                        </label>
                    </div>
                </div>
                <!-- <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="molduraImagem">Selecione uma moldura:</label>
                        <label class="label-input col-12">
                            <select id="molduraImagem" class="force-check input-form col-12">
                                <option value="" selected></option>
                            </select>
                        </label>
                    </div>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="button-modal" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="button-modal" id="btnAlterarImagemGrid">Salvar Alteração</button>
            </div>
        <?php
        break;
    case '2':
        $cont = $_POST['data'];
        $id_session = $_POST['id_session'];

        $imagem = $_SESSION['lista_images'.$id_session][$cont];
        // MODAL DE ALTERAÇÃO DE IMAGEM
        ?>
            <div class="modal-header">
                <h5 class="modal-title">Informações da Imagem</h5>
                <button type="button" class="button-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="idSessionModal" value="<?= $id_session ?>">
                <input type="hidden" id="cont" value="<?= $cont ?>">

                <div class="row mb-4">
                    <div class="col-md-12">
                        <img src="../web/imagens/<?= $imagem['urlImage'] ?>" class="addImgPreSet" id="newImg`+cont+`">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="nomeAlteraImagem">Nome da Imagem:</label>
                        <label class="label-input col-12">
                            <input type="text" id="nomeAlteraImagem" value="<?= $imagem['nomeImagem'] ?>" class="input-form force-check">
                        </label>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <?php if($imagem['statusImagem'] == 1) {
                                $select['public'] = 'selected=""';
                            } else {
                                $select['private'] = 'selected=""';
                            }?>
                        <label for="statusImg">Status:</label>
                        <label class="label-input col-12">
                            <select id="statusImg" class="input-form force-check">
                                <option value=""></option>
                                <option value="1" <?= $select['public'] ?>>Publico</option>
                                <option value="2" <?= $select['private'] ?>>Privado</option>
                            </select>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label for="curtidasImagem">Curtidas:</label>
                        <label class="label-input col-12">
                            <input disabled="" value="<?= $imagem['curtidas']?>" type="text" id="curtidasImagem" class="input-form selectReadonly">
                        </label>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="descricaoImagem">Descrição:</label>
                        <label class="label-input col-12">
                            <textarea class="input-form" id="descricaoImagem" cols="30" rows="10"><?= $imagem['descricao'] ?></textarea>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="button-modal" id="btnCancelarAlt" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="button-modal" id="btnAlterarInfoImagem">Salvar Alterações</button>
            </div>
        <?php
        break;
    case '3':
        ?>
            
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Imagem</h5>
                <button type="button" class="button-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <button class="button-modal col-12" id="btnAddImgList"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <form action="../controllers/adiciona-imagem.php" enctype="multipart/form-data" id="formAddImagem" method="post">
                    <input type="hidden" id="contImg" name="contImg" value="0">
                    <div id="infoImg">

                    </div>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="button-modal" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="button-modal" id="btnAdicionarNovaImagem">Adicionar Imagem</button>
            </div>
        <?php
        break;
    case '4':
        $cont = $_POST['data'];
        $id_session = $_POST['id_session'];

        $usuario = $_SESSION['lista_usuarios'.$id_session][$cont];
        // MODAL DE ALTERAÇÃO DE USUARIO
        ?>
            <div class="modal-header">
                <h5 class="modal-title">Informações do Usuario</h5>
                <button type="button" class="button-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="nomeAlteraUsuario">Nome Usuario:</label>
                        <label class="label-input col-12">
                            <input type="text" id="nomeAlteraUsuario" value="<?= $usuario['nomeUsuario'] ?>" class="input-form force-check">
                        </label>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="emailAlteraUsuario">Email Usuario:</label>
                        <label class="label-input col-12">
                            <input type="text" id="emailAlteraUsuario" value="<?= $usuario['emailUsuario'] ?>" class="input-form force-check">
                        </label>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-8">
                        <label for="cpfUsuario">CPF Usuario:</label>
                        <label class="label-input col-12">
                            <input type="text" id="cpfUsuario" value="<?= $usuario['cpfUsuario'] ?>" class="input-form force-check">
                        </label>
                    </div>
                    <div class="col-md-4">
                        <?php if($usuario['statusUsuario'] == 1) {
                                $select['ativo'] = 'selected=""';
                            } else {
                                $select['inativo'] = 'selected=""';
                            }?>
                        <label for="statusUsuario">Status Usuario:</label>
                        <label class="label-input col-12">
                            <select id="statusUsuario" class="input-form force-check">
                                <option value=""></option>
                                <option value="1" <?= $select['ativo'] ?>>Ativo</option>
                                <option value="2" <?= $select['inativo'] ?>>Inativo</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="ultimoAcesso">Ultimo Acesso:</label>
                        <label class="label-input col-12">
                            <input disabled="" value="<?= $usuario['ultimoAcesso']?>" type="text" id="ultimoAcesso" class="input-form selectReadonly">
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label for="dataCadastro">Data de Cadastro:</label>
                        <label class="label-input col-12">
                            <input disabled="" value="<?= $usuario['dataCriacao']?>" type="text" id="dataCadastro" class="input-form selectReadonly">
                        </label>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12 d-flex justify-content-center">
                        <form action="../album/?<?= $usuario['nomeUsuario'] ?>" method="post">
                            <input type="hidden" name="idSessionModal" id="idSessionModal" value="<?= $id_session ?>">
                            <input type="hidden" name="cont" id="cont" value="<?= $cont ?>">
                            <button type="submit" class="button-modal col-12">Ver Album <i class="fas fa-chevron-right"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="button-modal" id="btnCancelarAlt" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="button-modal" id="btnAlterarInfoUsuario">Salvar Alterações</button>
            </div>
        <?php
        break;
}