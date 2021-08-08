<?php
require_once('../layout/cabecalho-admin.php');
?>

<div class="container">
    <div class="row mt-4 mb-4">
        <div class="col-md-12 shadow p-3 mb-5 bg-body rounded">
            <div class="d-flex justify-content-center">
                <div class="h2">
                    ALBUM DE IMAGENS PRINCIPAL
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-md-12" id="divTabelaMainGrid">
        
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-end">
            <button id="btnAdicionarImagemGrid" class="button-modal">Adicionar imagem</button>
        </div>
    </div>
</div>


<div class="modal" id="modalGrid" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" id="divModalGridPrincipal">
        </div>
    </div>
</div>

<div class="modal" id="modalAddImgGrid" tabindex="-1">
    <input type="hidden" id="contSelectImgAdd">
    <div class="modal-dialog">
        <div class="modal-content" id="divModalAddImgGrid">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Imagem ao Grid</h5>
                <button type="button" id="btnCancelaAdicao" class="button-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div id="divSelectsImagemAdd">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label for="addImagemGrid1">Selecione uma imagem para adicionar:</label>
                            <label class="label-input col-12">
                                <select id="addImagemGrid1" class="force-check input-form col-12">
                                    <option value="" selected></option>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12 justify-content-end d-flex">
                        <button class="button-modal col-12" id="btnAddSelectImagemGrid"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="footerAddImg">
                <button type="button" class="button-modal" id="btnCancelaAdicao" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="button-modal" id="btnFinalizaAdicaoImagemGrid">Salvar Alteração</button>
            </div>
        </div>
    </div>
</div>
<?php
require_once('../layout/rodape-admin.php');