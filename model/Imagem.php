<?php

Class Imagem {

    private $idimagem;
    private $descricaoImagem;
    private $curtidas;
    private $urlImagem;
    private $dataCriacao;
    private $dataAtualizacao;

    function __construct($idimagem, $descricaoImagem, $curtidas, $urlImagem, $dataCriacao, $dataAtualizacao) {
        $this->idimagem = $idimagem;
        $this->$descricaoImagem = $descricaoImagem;
        $this->curtidas = $curtidas;
        $this->urlImagem = $urlImagem;
        $this->dataCriacao = $dataCriacao;
        $this->dataAtualizacao = $dataAtualizacao;
    }

    function getIdImagem() {
        return $this->idimagem;
    }

    function getDescricaoImagem() {
        return $this->descricaoImagme;
    }

    function getDataCriacaoImagem() {
        return $this->dataCriacao;
    }

    function getDataAtualizacaoImagem() {
        return $this->dataAtualizacao;
    }

    function getCurtidasImagem() {
        return $this->curtidas;
    }

    function getUrlImagem() {
        return $this->urlImagem;
    }

    function setIdImagem($idimagem) {
        $this->idimagem = $idimagem;
    }

    function setDescricaoImagem($descricaoImagem) {
        $this->descricaoImagme = $descricaoImagem;
    }

    function setDataCriacaoImagem($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }

    function setDataAtualizacaoImagem($dataAtualizacao) {
        $this->dataAtualizacao = $dataAtualizacao;
    }

    function setCurtidasImagem($curtidas) {
        $this->dataCriacao = $curtidas;
    }

    function setUrlImagem($urlImagem) {
        $this->dataCriacao = $urlImagem;
    }
}