<?php
require_once('../util/dao-loader.php');

$usuarioDao = new UsuarioDao($conexao);

$expDataInicio = explode('/', $_POST['dataCadastroInicio']);
$expDataFim = explode('/', $_POST['dataCadastroFim']);

if($_POST['dataCadastroInicio'] != '') {
    $_POST['dataCadastroInicio'] = $expDataInicio[2].'-'.$expDataInicio[1].'-'.$expDataInicio[0];
}

if($_POST['dataCadastroFim'] != '') {
    $_POST['dataCadastroFim'] = $expDataFim[2].'-'.$expDataFim[1].'-'.$expDataFim[0];
}

$resultado = $usuarioDao->buscaUsuario($_POST);

$id_session = geraCodigo();

$tamanho_json = count($resultado);

$_SESSION['lista_usuarios'. $id_session] = $resultado;
$json_final = json_encode($resultado, JSON_PRETTY_PRINT);
$file = fopen('../util/json/resultSearchUsuario.json', 'w');
fwrite($file, $json_final);
fclose($file);

// var_dump($_POST);

if($tamanho_json > 0) {
    ?>
    <input type="hidden" id="id_session" value="<?= $id_session ?>">
    <table class="table table-striped table-hover" id="tabelaUsuario">
        <thead>
            <tr>
                <th scope="col">Nome Usuario</th>
                <th scope="col">E-mail usuario</th>
                <th scope="col">CPF usuario</th>
                <th scope="col">Data de cadastro</th>
                <th scope="col">Ultimo acesso</th>
                <th scope="col">Tipo Usuario</th>
                <th scope="col">Opções</th>
            </tr>
        </thead>
    </table>
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-end">
            <button id="btnAdicionarUsuario" class="button-modal">Adicionar Usuario</button>
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
            var table = $('#tabelaUsuario').DataTable({
                ajax: {
                    url: "../util/json/resultSearchUsuario.json",
                    dataSrc: ""
                },
                createdRow: function (row, data, dataIndex) {

                    if(data.ultimoAcesso == '') {
                        data.ultimoAcesso = '---';
                    }
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
                        data: "nomeUsuario",
                        orderable: true,
                        searchable: true
                    },
                    {//coluna 2
                        data: "emailUsuario",
                        orderable: true,
                        searchable: true
                    },
                    {//coluna 2
                        data: "cpfUsuario",
                        orderable: true,
                        searchable: true
                    },
                    {//coluna 2
                        data: "dataCriacao",
                        orderable: false,
                        searchable: true
                    },
                    {//coluna 2
                        data: "ultimoAcesso",
                        orderable: false,
                        searchable: true
                    },
                    {//coluna 2
                        data: "tipoUsuario",
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
                                                    <li><button id="btnInfoUsuario" class="dropdown-item">Ver dados</button></li>
                                                </ul>
                                        </div>`
                    }
                ]
            });

            $('#tabelaUsuario tbody').on('click', '#btnInfoUsuario', function () {
                var data = table.row($(this).parents('tr')).index();

                var id_session = $("#id_session").val()
                $.ajax({
                    type: "POST",
                    url: "../util/cria-body-modal.php",
                    data: {data: data, tipo: 4, id_session},
                    success: function (res) {
                        $("#divModalUsuario").html(res);
                        $('#modalTabelaUsuario').modal('show');                        
                    }
                });
            });
        </script>
