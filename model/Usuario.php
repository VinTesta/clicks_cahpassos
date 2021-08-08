<?php

Class Usuario {
    private $idusuario;
    private $nomeUsuario;
    private $emailUsuario;
    private $cpfUsuario;
    private $senhaUsuario;
    private $ultimoAcesso;
    private $dataCriacao;

    function __construct($idusuario, $nomeUsuario, $emailUsuario, $cpfUsuario, $senhaUsuario, $ultimoAcesso, $dataCriacao) {
        $this->idusuario = $idusuario;
        $this->nomeUsuario = $nomeUsuario;
        $this->emailUsuario = $emailUsuario;
        $this->cpfUsuario = $cpfUsuario;
        $this->ultimoAcesso = $ultimoAcesso;
        $this->dataCriacao = $dataCriacao;
        $this->senhaUsuario = $senhaUsuario;
    }

    function getIdUsuario() {
        return $this->idusuario;
    }
    
    function getNomeUsuario() {
        return $this->nomeUsuario;
    }

    function getEmailUsuario() {
        return $this->emailUsuario;
    }

    function getCpfUsuario() {
        return $this->cpfUsuario;
    }

    function getSenhaUsuario() {
        return $this->senhaUsuario;
    }

    function getUltimoAcesso() {
        return $this->ultimoAcesso;
    }

    function getDataCriacao() {
        return $this->dataCriacao;
    }

    function setIdUsuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    function setNomeUsuario($nomeUsuario) {
        $this->nomeUsuario = $nomeUsuario;
    }

    function setEmailUsuario($emailUsuario) {
        $this->emailUsuario = $emailUsuario;
    }

    function setCpfUsuario($cpfUsuario) {
        $this->cpfUsuario = $cpfUsuario;
    }

    function setDataCriacao($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }

    function setUltimoAcesso($ultimoAcesso) {
        $this->ultimoAcesso = $ultimoAcesso;
    }

    function setSenhaUsuario($senhaUsuario) {
        $this->senhaUsuario = $senhaUsuario;
    }
}