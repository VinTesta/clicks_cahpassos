<?php
require_once('../layout/cabecalho-admin.php');
?>
<div class="container">
    <div class="row mt-4 mb-4">
        <div class="col-md-12 shadow p-3 mb-5 bg-body rounded">
            <div class="d-flex justify-content-center">
                <div class="h2">
                    TABELA DE USUARIOS
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="formPesquisaUsuario">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <label for="nomeUsuario">Nome usuario: </label>
                    <label class="label-input col-12">
                        <input type="text" name="nomeUsuario" id="nomeUsuario" class="input-form">
                    </label>
                </div>
                <div class="col-md-4 mb-4">
                    <label for="emailUsuario">E-mail usuario: </label>
                    <label class="label-input col-12">
                        <input type="text" name="emailUsuario" id="emailUsuario" class="input-form">
                    </label>
                </div>
                <div class="col-md-2 mb-1">
                    <label for="dataPesquisaInicio">Data cadastro: </label>
                    <label class="label-input col-12">
                        <input type="text" placeholder="Inicio" name="dataPesquisaInicio" id="dataPesquisaInicio" class="mask-date input-form">
                    </label>
                </div>
                <div class="col-md-2 mb-4 mt-3">
                    <label class="label-input mt-2 col-12">
                        <input type="text" placeholder="Fim" name="dataPesquisaFim" id="dataPesquisaFim" class="mask-date input-form">
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <button class="button-modal" id="btnPesquisaUsuario">Pesquisar</button>
                </div>    
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4 mb-4">
        <div class="col-md-12" id="divTabelaUsuario">

        </div>
    </div>
</div>


<div class="modal" id="modalTabelaUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" id="divModalUsuario">
        </div>
    </div>
</div>
<?php
require_once('../layout/rodape-admin.php');