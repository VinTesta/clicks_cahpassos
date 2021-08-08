<?php


require_once('../layout/cabecalho-admin.php');

verificaUsuarioAdmin();

?>

<div class="container">
    <div class="row mt-4 mb-4">
        <div class="col-md-12 shadow p-3 mb-5 bg-body rounded">
            <div class="d-flex justify-content-center">
                <div class="h2">
                    TABELA DE IMAGENS
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="formPesquisaImagens">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <label for="nomeImagem">Nome da imagem: </label>
                    <label class="label-input col-12">
                        <input type="text" name="nomeImagem" id="nomeImagem" class="input-form">
                    </label>
                </div>
                <div class="col-md-4 mb-4">
                    <label for="nomeUsuario">Nome cliente: </label>
                    <label class="label-input col-12">
                        <input type="text" name="nomeUsuario" id="nomeUsuario" class="input-form">
                    </label>
                </div>
                <div class="col-md-4 mb-4">
                    <label for="curtidas">Quantidade de curtidas: </label>
                    <label class="label-input col-12">
                        <input type="text" name="curtidas" id="curtidas" class="input-form">
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <button class="button-modal" id="btnPesquisaImagem">Pesquisar</button>
                </div>    
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4 mb-4">
        <div class="col-md-12" id="divTabelaImagens">

        </div>
    </div>
</div>


<div class="modal" id="modalTabelaImagens" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" id="divModalAdicionarImagens">
        </div>
    </div>
</div>

<?php
require_once('../layout/rodape-admin.php');
