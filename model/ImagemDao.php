<?php

Class ImagemDao {

    private $conexao;

    function __construct($conexao) {
        $this->conexao = $conexao;
    }

    function buscaImagemGrid($campos_busca, $info_usuario) {
        $types = '';
        $params = [];
        $where = '';

        if($info_usuario['tipoUsuario'] != 2) {
            $types .= 'i';
            $params[] = 1;
            $where .= ' AND i.statusImagem = ?'; 
        }

        if($campos_busca['codOrdem'] != '') {
            $types .= 'ii';
            $params[] = ($campos_busca['codOrdem'] - 1) * 12;
            $params[] = $campos_busca['codOrdem'] * 12;
            $where .= ' AND igw.codOrdemGrid > ? AND igw.codOrdemGrid <= ?'; 
        }

        $query = "SELECT * FROM 
                                imagem i,
                                imagemgridwelcome igw
                            WHERE
                                1 = 1
                                AND i.idimagem = igw.imagem_idimagem
                                $where
                                ORDER BY igw.codOrdemGrid ASC";

        $stmt = mysqli_prepare($this->conexao, $query);
        if($types != '') {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $resposta = $stmt->get_result();
        $stmt->close();

        foreach($resposta as $res) {
            $imagens_grid[] = $res;
        }

        return $imagens_grid;
    }

    function buscaImagem($campos_busca) {

        $types = '';
        $params = [];
        $where = '';
        $tables = '';

        if(isset($campos_busca['nomeUsuario']) && $campos_busca['nomeUsuario'] != '') {
            $tables .= ', imagemusuario iu, usuario u';
            $types .= 's';
            $params[] = '%'.$campos_busca['nomeUsuario'].'%';
            $where .= ' AND u.idusuario = iu.usuario_idusuario AND i.idimagem = iu.imagem_idimagem AND u.nomeUsuario LIKE ?';
        }

        if(isset($campos_busca['nomeImagem']) && $campos_busca['nomeImagem'] != '') {
            $types .= 's';
            $params[] = '%'.$campos_busca['nomeImagem'].'%';
            $where .= ' AND i.nomeImagem LIKE ?';
        }

        if(isset($campos_busca['qtdCurtidas']) && $campos_busca['qtdCurtidas'] != '') {
            $types .= 'i';
            $params[] = $campos_busca['qtdCurtidas'];
            $where .= ' AND i.curtidas = ?';
        }

        $query = "SELECT * FROM 
                                imagem i 
                                $tables
                            WHERE
                                1 = 1
                                $where
                                ORDER BY nomeImagem ASC";

        $stmt = mysqli_prepare($this->conexao, $query);
        if($types != '') {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $resposta = $stmt->get_result();
        $stmt->close();

        foreach($resposta as $res) {

            switch($res['statusImagem']) {
                case '1':
                    $res['statusImagemTxt'] = 'Publico';
                    break;
                case '2':
                    $res['statusImagemTxt'] = 'Privado';
                    break;
            }
            $imagens_grid[] = $res;
        }

        return $imagens_grid;
    }

    function alteraImagemGrid($idimagem, $ordemGrid) {
        $query = "UPDATE imagemgridwelcome SET imagem_idimagem = ? WHERE codOrdemGrid = ?";

        $stmt = mysqli_prepare($this->conexao, $query);
        $stmt->bind_param('ii', $idimagem, $ordemGrid);
        $stmt->execute();
        $resposta = $stmt->affected_rows;
        $stmt->close();

        return $resposta;
    }

    function insereImagemGrid($codOrdem, $idimagem) {
        $query = "INSERT INTO imagemgridwelcome (codOrdemGrid, imagem_idimagem) 
                        VALUES
                                (?,?)";

        $stmt = mysqli_prepare($this->conexao, $query);
        $stmt->bind_param('ii', $codOrdem, $idimagem);
        $stmt->execute();
        $resultado = $stmt->insert_id;
        $stmt->close();

        return $resultado;
    }

    function removeImagemGrid($infoImg) {
        $query = "DELETE FROM imagemgridwelcome WHERE idImagemGrid = ?";

        $stmt = mysqli_prepare($this->conexao, $query);
        $stmt->bind_param('i', $infoImg['idImagemGrid']);
        $stmt->execute();
        $resposta = $stmt->affected_rows;
        $stmt->close();

        return $resposta;
    }

    function corrigePosicaoImagem($infoImg) {
        $newCod = $infoImg['codOrdemGrid'] - 1;

        $query = "UPDATE imagemgridwelcome SET codOrdemGrid = ? WHERE idImagemGrid = ?";

        $stmt = mysqli_prepare($this->conexao, $query);
        $stmt->bind_param('ii', $newCod, $infoImg['idImagemGrid']);
        $stmt->execute();
        $resposta = $stmt->affected_rows;
        $stmt->close();

        return $resposta;
    }

    function insereImagem($infoImg, $urlImg) {
        $resposta = [];

        $curtidas = 0;

        $query = "INSERT INTO imagem (nomeImagem, descricao, urlImage, curtidas, statusImagem)
                        VALUES (?,?,?,?,?)";
        
        $stmt = mysqli_prepare($this->conexao, $query);
        $stmt->bind_param('sssii', $infoImg['nomeImagem'], $infoImg['descImg'], $urlImg, $curtidas, $infoImg['statusImg']);
        $stmt->execute();
        $resposta['idimagem'] = $stmt->insert_id;
        $stmt->close();

        if(!empty($infoImg['idusuario']) && $resposta != '0') {
            $query = "INSERT INTO imagemusuario (imagem_idimagem, usuario_idusuario)
                        VALUES (?,?)";
        
            $stmt = mysqli_prepare($this->conexao, $query);
            $stmt->bind_param('ii', $resposta['idimagem'], $infoImg['idusuario']);
            $stmt->execute();
            $resposta['idImagemUsuario'] = $stmt->insert_id;
            $stmt->close();
        }

        return $resposta;

    }

    function alteraImagem($infoImg, $nomeImg, $descImg, $statusImg) {
        $query = "UPDATE imagem SET nomeImagem = ?, descricao = ?, statusImagem = ? WHERE idimagem = ?";

        $stmt = mysqli_prepare($this->conexao, $query);
        $stmt->bind_param('ssii', $nomeImg, $descImg, $statusImg, $infoImg['idimagem']);
        $stmt->execute();
        $resposta = $stmt->affected_rows;
        $stmt->close();

        return $resposta;
    }
}