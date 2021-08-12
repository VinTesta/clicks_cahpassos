<?php
require_once('./dao-loader.php');

$imagemDao = new ImagemDao($conexao);

verificaUsuarioAdmin();

$campos_busca = $_POST;

$imagens = $imagemDao->buscaImagem($campos_busca);

$id_session = geraCodigo();

$tamanho_json = count($imagens);

$_SESSION['lista_images'. $id_session] = $imagens;
$json_final = json_encode($imagens, JSON_PRETTY_PRINT);
$file = fopen('../util/json/resultSearchImagem.json', 'w');
fwrite($file, $json_final);
fclose($file);

// var_dump($_SESSION);

if($tamanho_json > 0) {
    ?>
    <input type="hidden" id="id_session" value="<?= $id_session ?>">
    <table class="table table-striped table-hover" id="tabelaImagem">
        <thead>
            <tr>
                <th scope="col">Nome Imagem</th>
                <th scope="col">Descrição</th>
                <th scope="col">Curtidas</th>
                <th scope="col">URL</th>
                <th scope="col">Status</th>
                <th scope="col">Opções</th>
            </tr>
        </thead>
    </table>
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-end">
            <button id="btnAdicionarImagem" class="button-modal">Adicionar imagem</button>
        </div>
    </div>
<?php
} else {
    ?>
    <script type="text/javascript">
        $(".toast-body").html("Nenhum resultado foi encontrado com os dados passados")
        toastList[0].show()
    </script>
    <?php
}
?>

        <script type="text/javascript">
            var table = $('#tabelaImagem').DataTable({
                ajax: {
                    url: "../util/json/resultSearchImagem.json",
                    dataSrc: ""
                },
                createdRow: function (row, data, dataIndex) {

                },
                order: [[0, 'asc']],
                pageLength: 25,
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
                        data: "nomeImagem",
                        orderable: true,
                        searchable: true
                    },
                    {//coluna 2
                        data: "descricao",
                        orderable: true,
                        searchable: true
                    },
                    {//coluna 2
                        data: "curtidas",
                        orderable: false,
                        searchable: true
                    },
                    {//coluna 2
                        data: "urlImage",
                        orderable: false,
                        searchable: true
                    },
                    {//coluna 2
                        data: "statusImagemTxt",
                        orderable: true,
                        searchable: true
                    },
                    {//coluna 8
                        orderable: false,
                        searchable: false,
                        defaultContent: `<div class="btn-group">
                                                <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Opções
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><button id="btnAlterarItem" class="dropdown-item">Ver dados</button></li>
                                                </ul>
                                        </div>`
                    }
                ]
            });

            $('#tabelaImagem tbody').on('click', '#btnAlterarItem', function () {
                var data = table.row($(this).parents('tr')).index();

                var id_session = $("#id_session").val()
                $.ajax({
                    type: "POST",
                    url: "../util/cria-body-modal.php",
                    data: {data: data, tipo: 2, id_session},
                    success: function (res) {
                        $("#divModalAdicionarImagens").html(res);
                        $('#modalTabelaImagens').modal('show');

                        
                    }
                });
            });
        </script>