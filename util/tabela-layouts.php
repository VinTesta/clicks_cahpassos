<?php
require_once('../util/dao-loader.php');

$imagemDao = new ImagemDao($conexao);

$option = '1';
switch($option) {
    case '1':
        // GERA A TABELA DO GRID DA PAGINA PRINCIPAL

        $campos_busca = ['codOrdem' => ''];

        $imagens = $imagemDao->buscaImagemGrid($campos_busca);

        $hashPesquisa = geraCodigo();

        $tamanho_json = count($imagens);

        $_SESSION['lista_Main_Grid'.$hashPesquisa] = $imagens;
        $json_final = json_encode($imagens, JSON_PRETTY_PRINT);
        $file = fopen('../util/json/resultSearchMainGrid.json', 'w');
        fwrite($file, $json_final);
        fclose($file);

        if($tamanho_json > 0) {
            ?>
            <input type="hidden" id="id_session" value="<?= $hashPesquisa ?>">
            <table class="table table-striped table-hover" id="tabelaMainGrid">
                <thead>
                    <tr>
                        <th scope="col">Ordem</th>
                        <th scope="col">Nome</th>
                        <th scope="col">URL</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Curtidas</th>
                        <th scope="col">Opções</th>
                    </tr>
                </thead>
            </table>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="col-md-12">
                    Nenhum resultado encontrado
                </div>
            </div>
            <?php
        }

        ?>

        <script>
            var table = $('#tabelaMainGrid').DataTable({
                ajax: {
                    url: "../util/json/resultSearchMainGrid.json",
                    dataSrc: ""
                },
                createdRow: function (row, data, dataIndex) {
                },
                order: [[0, 'asc']],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    info: "Mostrando página _PAGE_ de _PAGES_.",
                    lengthMenu: "Mostrar _MENU_ registros.",
                    search: "Pesquisar:",
                    infoFiltered: "",
                    emptyTable: "Nenhum registro encontrado",
                    searchPlaceholder: "Nome",
                    paginate: {
                        first: "Primeira Página",
                        last: "Última Página",
                        next: "Próxima",
                        previous: "Anterior"
                    },
                    zeroRecords: "Nenhum registro encontrada!",
                    infoEmpty: "Nenhum resultado.",
                    loadingRecords: "Carregando...",
                    processing: "Processando...",
                    select: {
                        rows: {
                            _: "%d registros selecionados.",
                            0: "Nenhum registro selecionado.",
                            1: "1 registro selecionado."
                        }
                    }
                },
                columns: [
                    {//coluna 2
                        data: "codOrdemGrid",
                        orderable: true,
                        searchable: true
                    },
                    {//coluna 2
                        data: "nomeImagem",
                        orderable: true,
                        searchable: true
                    },
                    {//coluna 2
                        data: "urlImage",
                        orderable: false,
                        searchable: true
                    },
                    {//coluna 2
                        data: "descricao",
                        orderable: false,
                        searchable: true
                    },
                    {//coluna 2
                        data: "curtidas",
                        orderable: true,
                        searchable: true
                    },
                    {//coluna 8
                        orderable: false,
                        searchable: false,
                        defaultContent: `<div class="btn-group">
                                                <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><button  id="btnAlterarItem" class="dropdown-item">Alterar Item</button></li>
                                                    <li><button id="btnExcluirItem" class="dropdown-item">Excluir Item</button></li>
                                                </ul>
                                        </div>`
                    }
                ]
            });

            $('#tabelaMainGrid tbody').on('click', '#btnAlterarItem', function () {
                var data = table.row($(this).parents('tr')).index();

                var id_session = $("#id_session").val()
                $.ajax({
                    type: "POST",
                    url: "../util/cria-body-modal.php",
                    data: {data: data, tipo: 1, id_session},
                    success: function (res) {
                        $("#divModalGridPrincipal").html(res);
                        $('#modalGrid').modal('show');

                        $.ajax({
                            type: 'POST',
                            url: '../util/cria-lista-imagens.php',
                            data: {},
                            success: (res) => {
                                $("#alterarImagemGrid").html(res)
                            }
                        })
                    }
                });
            });

            $('#tabelaMainGrid tbody').on('click', '#btnExcluirItem', function () {
                var data = table.row($(this).parents('tr')).index();

                var id_session = $("#id_session").val()

                if(confirm('Deseja realmente excluir este item?')) {
                    $.ajax({
                        type: "POST",
                        url: "../controllers/remove-imagem-grid.php",
                        data: {data: data, id_session},
                        success: function (res) {
                            
                            var resultado = JSON.parse(res)

                            $(".toast-body").html(resultado.resultado)
                            toastList[0].show()

                            if(resultado.codRes == 1) {
                                geraTabelaMainGrid("#divTabelaMainGrid")
                            }
                        }
                    });
                }
            });
        </script>

        <?php
        break;
}