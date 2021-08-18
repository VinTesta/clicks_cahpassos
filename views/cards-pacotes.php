<?php
require_once('../layout/cabecalho.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-4 mb-4 d-flex justify-content-center"> 
            <div class="card" style="width: 18rem;">
                <img src="../web/imagens/boy.jpg" class="card-img-top" alt="...">
                <div class="card-body" id="cardBodyPack">
                    <h3 id="title-card">Foto de gestante</h3>
                    <h5>Informações</h5>
                    <p>Valor:</p>
                    <p>R$50,00</p>
                    <button id="btnAgendarSessao" data-type="1" class="button-modal">Agendar agora</button>
                </div>
            </div>         
        </div>
        <div class="col-md-4 mb-4 d-flex justify-content-center"> 
            <div class="card" style="width: 18rem;">
                <img src="../web/imagens/boy.jpg" class="card-img-top" alt="...">
                <div class="card-body" id="cardBodyPack">
                    <h3 id="title-card">Foto de bebe</h3>
                    <h5>Informações</h5>
                    <p>Valor:</p>
                    <p>R$50,00</p>
                    <button id="btnAgendarSessao" data-type="2" class="button-modal">Agendar agora</button>
                </div>
            </div>         
        </div>
        <div class="col-md-4 mb-4 d-flex justify-content-center"> 
            <div class="card" style="width: 18rem;">
                <img src="../web/imagens/boy.jpg" class="card-img-top" alt="...">
                <div class="card-body" id="cardBodyPack">
                    <h3 id="title-card">Foto de familia</h3>
                    <h5>Informações</h5>
                    <p>Valor:</p>
                    <p>R$50,00</p>
                    <button id="btnAgendarSessao" data-type="3" class="button-modal">Agendar agora</button>
                </div>
            </div>         
        </div>
    </div>
</div>

<?php
require_once('../layout/rodape.php');