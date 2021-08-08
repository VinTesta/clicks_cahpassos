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

        $imagem = $_SESSION['lista_Main_Grid'.$id_session][$cont];
        // MODAL DE ALTERAÇÃO DE IMAGEM DO GRID PRINCIPAL
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
                        <label for="urlImagem">URL da Imagem:</label>
                        <label class="label-input col-12">
                            <input type="text" id="urlImagem" class="input-form selectReadonly force-check">
                        </label>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-9">
                        <label for="nomeImagem">Nome da Imagem:</label>
                        <label class="label-input col-12">
                            <input type="text" id="nomeImagem" class="input-form selectReadonly force-check">
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label for="statusImg">Status:</label>
                        <label class="label-input col-12">
                            <select id="statusImg" class="input-form force-check">
                                <option value=""></option>
                                <option value="1">Publico</option>
                                <option value="2">Privado</option>
                            </select>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label for="curtidasImagem">Curtidas:</label>
                        <label class="label-input col-12">
                            <input type="text" id="curtidasImagem" class="input-form selectReadonly">
                        </label>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="descricaoImagem">Descrição:</label>
                        <label class="label-input col-12">
                            <textarea class="input-form" id="descricaoImagem" cols="30" rows="10"></textarea>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="button-modal" data-bs-dismiss="modal">Cancelar</button>
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
                        <label for="urlImagem">Imagem:</label>
                        <label class="label-input col-12">
                            <input type="file" class="input-form force-check"> 
                        </label>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-9">
                        <label for="nomeImagem">Nome da Imagem:</label>
                        <label class="label-input col-12">
                            <input type="text" id="nomeImagem" class="input-form selectReadonly force-check">
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label for="statusImg">Status:</label>
                        <label class="label-input col-12">
                            <select id="statusImg" class="input-form force-check">
                                <option value=""></option>
                                <option value="1">Publico</option>
                                <option value="2">Privado</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="descricaoImagem">Descrição:</label>
                        <label class="label-input col-12">
                            <textarea class="input-form" id="descricaoImagem" cols="30" rows="10"></textarea>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="button-modal" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="button-modal" id="btnAdicionarNovaImagem">Adicionar Imagem</button>
            </div>
        <?php
        break;
}