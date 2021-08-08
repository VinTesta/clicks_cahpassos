<?php

Class UsuarioFactory {
    public function criaUsuario($params) {
        $idusuario = !isset($params['idusuario']) ? NULL : $params['idusuario'];
        $nomeUsuario = !isset($params['nomeUsuario']) ? NULL : $params['nomeUsuario'];
        $emailUsuario = !isset($params['emailUsuario']) ? NULL : $params['emailUsuario'];
        $cpfUsuario = !isset($params['cpfUsuario']) ? NULL : $params['cpfUsuario'];
        $senhaUsuario = !isset($params['senhaUsuario']) ? NULL : $params['senhaUsuario'];
        $ultimoAcesso = !isset($params['ultimoAcesso']) ? NULL : $params['ultimoAcesso'];
        $dataCriacao = !isset($params['dataCriacao']) ? NULL : $params['dataCriacao'];

        return new Usuario($idusuario, $nomeUsuario, $emailUsuario, $cpfUsuario, $senhaUsuario, $ultimoAcesso, $dataCriacao);
    }
}