<?php

Class UsuarioDao {

    private $conexao;

    function __construct($conexao) {
        $this->conexao = $conexao;
    }

    function insereUsuario($params) {
        $dataAtual = date('Y-m-d');

        $nomeUsuario = trataCampo($params['nomeUsuario'], 1);
        $emailUsuario = trataCampo($params['emailUsuario'], 3);
        $senhaUsuario = password_hash($params['senhaUsuario'], PASSWORD_DEFAULT);
        $tipoUsuario = $params['tipoUsuario'];

        $query = "INSERT INTO 
                            usuario (nomeUsuario, emailUsuario, senhaUsuario, dataCriacao, tipoUsuario)
                        VALUES
                            (?,?,?,?,?)";

        $stmt = mysqli_prepare($this->conexao, $query);
        $stmt->bind_param('ssssi', $nomeUsuario, $emailUsuario, $senhaUsuario, $dataAtual, $tipoUsuario);
        $stmt->execute();
        $resposta = $stmt->insert_id;
        $stmt->close();

        return $resposta;
    }

    function alteraSenhaUsuario($infoUsuario, $novaSenha) {
        
        $senhaUsuario = password_hash($novaSenha, PASSWORD_DEFAULT);

        $query = "UPDATE usuario SET senhaUsuario = ? WHERE idusuario = ?";

        $stmt = mysqli_prepare($this->conexao, $query);
        $stmt->bind_param('si', $senhaUsuario, $infoUsuario['idusuario']);
        $stmt->execute();
        $resultado = $stmt->affected_rows;
        $stmt->close();

        return $resultado;
    }

    function verificaValidadeEmail($campos_busca) {
        $params = [];
        $types = '';
        $where = '';

        if($campos_busca['emailUsuario'] != '') {
            $types .= 's';
            $params[] = $campos_busca['emailUsuario'];
            $where .= ' AND u.emailUsuario = ?';
        }

        $query = "SELECT * FROM 
                                usuario u
                            WHERE
                                1 = 1
                                AND u.statusUsuario = 1
                                $where";
        
        $stmt = mysqli_prepare($this->conexao, $query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $resultado = mysqli_fetch_assoc($stmt->get_result());
        $stmt->close();

        return $resultado;
    }

    function logarUsuario($params) {
        $dataAtual = date('Y-m-d');
        $query = "UPDATE usuario SET ultimoAcesso = ? WHERE idusuario = ?";

        $stmt = mysqli_prepare($this->conexao, $query);
        $stmt->bind_param('si', $dataAtual, $params['idusuario']);
        $stmt->execute();
        $resposta = $stmt->affected_rows;
        $stmt->close();

        return $resposta;
    }

    function buscaUsuario($campos_busca) {
        $imagemDao = new ImagemDao($this->conexao);

        $params = [];
        $types = '';
        $where = '';
        $tables = '';

        if($campos_busca['nomeUsuario'] != "") {
            $params[] = '%'.$campos_busca['nomeUsuario'].'%';
            $types .= 's';
            $where .= ' AND u.nomeUsuario LIKE ?';
        }

        if($campos_busca['emailUsuario'] != "") {
            $params[] = '%'.$campos_busca['emailUsuario'].'%';
            $types .= 's';
            $where .= ' AND u.emailUsuario LIKE ?';
        }

        if($campos_busca['dataCadastroInicio'] != "" && $campos_busca['dataCadastroFim'] != "") {

            $params[] = $campos_busca['dataCadastroInicio'];
            $params[] = $campos_busca['dataCadastroFim'];
            $types .= 'ss';
            $where .= ' AND u.dataCriacao BETWEEN ? AND ?';

        } else if($campos_busca['dataCadastroInicio'] != "") {

            $params[] = $campos_busca['dataCadastroInicio'];
            $types .= 's';
            $where .= ' AND u.dataCriacao = ?';

        } else if($campos_busca['dataCadastroFim'] != "") {

            $params[] = $campos_busca['dataCadastroFim'];
            $types .= 's';
            $where .= ' AND u.dataCriacao = ?';
        }

        $query = "SELECT * FROM 
                                usuario u
                            WHERE 
                                1 = 1".$where;

        $stmt = mysqli_prepare($this->conexao, $query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();

        foreach($resultado as $res) {

            $campos_busca['idusuario'] = $res['idusuario'];

            $imagens = $imagemDao->buscaImagem($campos_busca);
            
            $usuarios[] = $res;
        }

        return $usuarios;
    }

    function alteraUsuario($infoUsuario, $params) {
        $query = "UPDATE usuario SET nomeUsuario = ?, statusUsuario = ?, emailUsuario = ?, cpfUsuario = ? WHERE idusuario = ?";

        $stmt = mysqli_prepare($this->conexao, $query);
        $stmt->bind_param('siss', $params['nomeUsuario'], $params['statusUsuario'], $params['emailUsuario'], $params['cpfUsuario']);
        $stmt->execute();
        $resultado = $stmt->affected_rows;
        $stmt->close();

        return $resultado;
    }
}