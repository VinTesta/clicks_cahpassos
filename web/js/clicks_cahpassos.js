// WELCOME ------------------------------------------------------------------------
window.onload = () => {
    
    var toastElList = [].slice.call(document.querySelectorAll('.toast'))
    var option = {'animation': true, 'autohide': true, 'delay': 5000}
    var toastList = toastElList.map(function (toastEl) {
    return new bootstrap.Toast(toastEl, option)
    })

    if(localStorage.getItem('alerta') != '') {
        $(".toast-body").html(localStorage.getItem('alerta'))
        toastList[0].show()

        
        localStorage.setItem('alerta', '')
    }

    var arrayLocation = window.location.toString().split('/')

    $("#divTab"+arrayLocation[arrayLocation.length - 2]).css('display', 'block')

    // MASKS
    $('.mask-date').mask('00/00/0000');

    function geraGridImagensWelcome() {
        var order = localStorage.getItem('imageOrder')

        $.ajax({
            type: 'post',
            url: '../util/grid-imagens-welcome.php',
            data: {order},
            success: function(res) {
                $("#gridImagensWelcome").append(res)
            }
        })
    }
    
    if($("#gridImagensWelcome").is(':visible')) {
        localStorage.setItem('imageOrder', 1)
        geraGridImagensWelcome()
    }

    $(document).on('scroll', () => {
        var scrollMax = document.scrollingElement.scrollTopMax
        var scrollAtual = document.scrollingElement.scrollTop
        if(scrollMax == scrollAtual) {
            localStorage.setItem('imageOrder', parseInt(localStorage.getItem('imageOrder')) + 1)
            geraGridImagensWelcome()
        }
    })

    function geraListaImagens(div) {
        $.ajax({
            type: 'POST',
            url: '../util/cria-lista-imagens.php',
            data: {},
            success: (res) => {
                $(div).html(res)
            }
        })
    }

    function validaCamposForm(campos) {

        var flag = [];

        $.each(campos, function (index, campo) {
            var idCampo = campo[0];

            if (idCampo[0] == '.') { // tratamento de classes

                $(idCampo).each(function () {
                    if ($(this).is(':visible') || $(this).hasClass('force-check') && !$(this).hasClass('custom-file')) {
                        if ($(this).val() === '') {
                            $(this).addClass('alerta');
                            flag.push(1);
                        } else {
                            $(this).removeClass('alerta');
                        }
                    }
                });

            } else { // tratamento de id

                var divAlerta = campo[1] ? campo[1] : campo[0];

                var valor = $(idCampo).val();
                if ($(divAlerta).is(':visible') || $(divAlerta).hasClass('force-check')) {

                    if ($(idCampo).hasClass('multiselect') || $(idCampo).attr('multiple') == 'multiple') {
                        if (valor == '') {
                            $(divAlerta).addClass('alerta');
                            flag.push(1);
                        } else {
                            $(divAlerta).removeClass('alerta');
                        }
                    } else if ($(idCampo).hasClass('custom-file-input')) {
                        var formatosAceitos = campo[2];
                        var tamanhoMaximo = campo[3];

                        var placeholder = $(idCampo).next('.custom-file-label').text();

                        if (placeholder != 'Enviar novo Arquivo') { // insere
                            if (!valor) {
                                $(divAlerta).addClass('alerta');
                                flag.push(1);
                            } else {
                                if (verificaFormatoArquivo(valor, formatosAceitos)) {
                                    flag.push(1);
                                    $(divAlerta).addClass('alerta');
                                } else {
                                    var tamanho = $(idCampo)[0].files[0].size;
                                    if (tamanho > tamanhoMaximo) {
                                        flag.push(1);
                                        $(divAlerta).addClass('alerta');
                                    } else {
                                        $(divAlerta).removeClass('alerta');
                                    }
                                }
                            }
                        } else { // altera
                            if (valor) {
                                if (verificaFormatoArquivo(valor, formatosAceitos)) {
                                    flag.push(1);
                                    $(divAlerta).addClass('alerta');
                                } else {
                                    var tamanho = $(idCampo)[0].files[0].size;
                                    if (tamanho > tamanhoMaximo) {
                                        flag.push(1);
                                        $(divAlerta).addClass('alerta');
                                    } else {
                                        $(divAlerta).removeClass('alerta');
                                    }
                                }
                            }
                        }

                    } else {
                        if (!valor) {
                            $(divAlerta).addClass('alerta');
                            flag.push(1);
                        } else {
                            $(divAlerta).removeClass('alerta');
                        }
                    }
                }
            }
        });
        var erro = 0; //verificar se tem erro        
        for (var i = 0; i < flag.length; i++) {
            var achou = flag[i];
            if (achou == 1) {
                erro = 1;
                break;
            }
        }
        return erro;
    }

    $(document).on('click', "#btnCadastrarUsuario", (e) => {
        e.preventDefault()

        var erro = validaCamposForm([['.force-check']])

        var senha = $("#passwordInput").val()
        var confirmaSenha = $("#confirmPasswordInput").val()

        if(erro == 1) {
            
            $(".toast-body").html('Há campos vazis, preencha-os para continuar!')
            toastList[0].show()
            return false;
        } else {
            if(senha != confirmaSenha) {
                $(".toast-body").html('As senhas não condizem!')
                toastList[0].show()
                return false;
            } else {
                $("#formCadastroUsuario").submit()
            }
        }
    })

    $(document).on('click', '#btnLogin', (e) => {
        e.preventDefault()

        var erro = validaCamposForm([['.force-check']])

        if(erro == 1) {
            
            $(".toast-body").html('Há campos vazis, preencha-os para continuar!')
            toastList[0].show()
            return false;
        } else {
            
            $("#formLoginUsuario").submit()
        }
    })

    $(document).on('click', "#esqueciSenha", (e) => {
        e.preventDefault()

        $(".modal-title").html('Esqueci minha senha')
        $(".modal-body").html(`<form action="../alterar-senha/" id="form-altera-senha" method="post"><div class="row">
                                    <div class="text-center col-12">
                                        Digite o e-mail da conta:
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label id="emailForg" class="p-1 label-input col-12">
                                            <i class="fas fa-user"></i>
                                            <input type="email" name="emailForg" class="col-11 force-check input-form-login" placeholder="E-mail">
                                        </label>
                                    </div>
                                </div></form>`)
        $(".modal-footer").html(`<button type="button" class="button-modal" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" id="alterarSenhaDefault" name="alterarSenhaDefault" class="button-modal">Alterar senha</button>`)

        $('.modal').modal('show');
    })

    $(document).on('click', "#alterarSenhaDefault", () => {
        $("#form-altera-senha").submit();
    })
    
    $(document).on('click', "#btnConfirmarSenha", (e) => {
        e.preventDefault();

        var erro = validaCamposForm([['.force-check']]);

        if(erro != 0) {

            $(".toast-body").html('Preencha todos os campos antes de continuar!')
            toastList[0].show()

            return false;
        } else {
            if($("#senha").val() == $("#confirmarSenha").val()) {
                $("#formLoginUsuario").submit()
            } else {
                $(".toast-body").html('As senhas não coincidem!')
                toastList[0].show()
                return false; 
            }
        }
    })

    // LAYOUTS ---------------------------------------------------------------------------

    function geraTabelaMainGrid(div) {
        $.ajax({
            type: 'post',
            url: '../util/tabela-layouts.php',
            data: {opt: 1},
            success: (res) => {
                console.log(res)
                $(div).html(res)
            }
        })
    }

    if($("#divTabelaMainGrid").is(':visible')) {

        $("#divTabelaMainGrid").html(`<div class="d-flex justify-content-center">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>`)

        geraTabelaMainGrid("#divTabelaMainGrid")
    }

    $(document).on('click', "#btnAlterarImagemGrid", () => {

        $(".modal-footer").html(`<div class="spinner-border text-dark" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>`)

        var cont = $("#cont").val()
        var id_session = $("#idSessionModal").val()
        var novaImagem = $("#alterarImagemGrid").val()

        $.ajax({
            type: 'POST',
            url: '../controllers/altera-imagem-grid.php',
            data: {cont, id_session, novaImagem},
            success: (res) => {
                
                var resultado = JSON.parse(res)

                $(".toast-body").html(resultado.resposta)
                toastList[0].show()
                
                if(resultado.resultado > 0) {
                    geraTabelaMainGrid("#divTabelaMainGrid")
                } else {
                    $(".modal-footer").html(`<button type="button" class="button-modal" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="button-modal" id="btnAlterarImagemGrid">Salvar Alteração</button>`)
                }
            } 
        })
    })

    $(document).on('click', '#btnAdicionarImagemGrid', () => {
        $('#modalAddImgGrid').modal('show');
        geraListaImagens("#addImagemGrid1");

        $("#contSelectImgAdd").val(1)
    })

    $(document).on('click', '#btnAddSelectImagemGrid', () => {

        var cont = parseInt($("#contSelectImgAdd").val()) + 1;

        $("#contSelectImgAdd").val(cont)


        $("#divSelectsImagemAdd").append(`<div class="row mb-4" id="newSelect`+cont+`">
                                            <div class="col-md-10">
                                                <label for="addImagemGrid`+cont+`">Selecione uma imagem para adicionar:</label>
                                                <label class="label-input col-12">
                                                    <select id="addImagemGrid`+cont+`" class="force-check input-form col-12">
                                                        <option value="" selected></option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="col-md-2 align-center mt-2">
                                                <button class="button-modal col-md-12 mt-1" data-idremove="`+cont+`" id="btnRemoveSelectImagemGrid"><i id="btnRemoveSelectImagemGrid" data-idremove="`+cont+`" class="far fa-trash-alt"></i></button>
                                            </div>
                                        </div>`)

        geraListaImagens("#addImagemGrid"+cont);
    })

    $(document).on('click', "#btnRemoveSelectImagemGrid", (e) => {
        var idremove = e.target.dataset.idremove

        $("#newSelect"+idremove).remove()
    })

    $(document).on('click', '#btnCancelaAdicao', () => {
        $("#divSelectsImagemAdd").html(`<div class="row mb-4">
                                            <div class="col-md-12">
                                                <label for="addImagemGrid1">Selecione uma imagem para adicionar:</label>
                                                <label class="label-input col-12">
                                                    <select id="addImagemGrid1" class="force-check input-form col-12">
                                                        <option value="" selected></option>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>`)
    })

    $(document).on('click', '#btnFinalizaAdicaoImagemGrid', () => {

        var cont = $("#contSelectImgAdd").val()

        var imagens = []

        for(var i = 1; i <= cont; i++) {
            imagens.push($("#addImagemGrid"+i).val())
            
        }

        $("#footerAddImg").html(`<div class="spinner-border text-dark" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>`)

        $.ajax({
            type: 'POST',
            url: '../controllers/adiciona-imagem-grid.php',
            data: {imagens},
            success: (res) => {
                var resposta = JSON.parse(res)

                $("#btnCancelaAdicao").click()
                
                geraTabelaMainGrid("#divTabelaMainGrid")

                $(".toast-body").html(resposta.resultado)
                toastList[0].show()

                $("#footerAddImg").html(`<button type="button" class="button-modal" id="btnCancelaAdicao" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="button-modal" id="btnFinalizaAdicaoImagemGrid">Salvar Alteração</button>`)
            }
        })
    })
    // LAYOUTS ---------------------------------------------------------------------------
    // IMAGEM-----------------------------------------------------------------------------
    $(document).on('click', '#btnPesquisaImagem', () => {

        $("#divTabelaImagens").html(`<div class="col-md-12 d-flex justify-content-center">
                                        <div class="spinner-border text-dark" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>`)
                            

        var qtdCurtidas = $("#curtidas").val()
        var nomeUsuario = $("#nomeUsuario").val()
        var nomeImagem = $("#nomeImagem").val()
        $.ajax({
            type: 'POST',
            url: '../util/tabela-imagens.php',
            data: {qtdCurtidas, nomeImagem, nomeUsuario},
            success: (res) => {
                $("#divTabelaImagens").html(res)
            }
        })
    })

    function geraListaUsuario(div) {
        $.ajax({
            type: 'POST',
            url: '../util/cria-lista-usuario.php',
            data: {},
            success: (res) => {
                $(div).html(res)
            }
        })
    }

    $(document).on('click', '#btnAdicionarImagem', () => {
        $.ajax({
            type: 'POST',
            url: '../util/cria-body-modal.php',
            data: {tipo: 3},
            success: (res) => {
                $("#divModalAdicionarImagens").html(res)
                $('#modalTabelaImagens').modal('show');

            }
        })
    })

    $(document).on('click', '#btnAlterarInfoImagem', () => {
        var nomeImagem = $("#nomeAlteraImagem").val()
        var descricao = $("#descricaoImagem").val()
        var statusImagem = $("#statusImg").val()
        var id_session = $("#idSessionModal").val()
        var cont = $("#cont").val()
        
        $.ajax({
            type: 'POST',
            url: '../controllers/altera-imagem.php',
            data: {id_session, cont, nomeImagem, descricao, statusImagem},
            success: (res) => {

                var res = JSON.parse(res)

                $(".toast-body").html(res.resposta)
                toastList[0].show()

                if(res.resultado == 1) {
                    $("#btnCancelarAlt").click();
                    $("#btnPesquisaImagem").click();
                }
            }
        })
    })

    $(document).on('click', "#btnAddImgList", () => {
        
        var cont = $("#contImg").val()

        $("#infoImg").append(`<hr>
                    <div class="row mb-5 mt-5">
                        <h3 class="text-center">Imagem `+cont+`</h3>
                        <div class="col-md-12">
                            <img src="../web/imagens/ec147c4c53abfe86df2bc7e70c0181ff.jpg" class="addImgPreSet" id="newImg`+cont+`">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <label for="imagensAdd">Imagem:</label>
                            <label class="label-input col-12">
                                <input type="file" name="imagensAdd`+cont+`" id="imagensAdd`+cont+`" data-id="`+cont+`" class="input-imagens-add input-form force-check"> 
                            </label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-9">
                            <label for="nomeImagem`+cont+`">Nome da Imagem:</label>
                            <label class="label-input col-12">
                                <input type="text" name="nomeImagem`+cont+`" id="nomeImagem`+cont+`" class="input-form selectReadonly force-check">
                            </label>
                        </div>
                        <div class="col-md-3">
                            <label for="statusImg`+cont+`">Status:</label>
                            <label class="label-input col-12">
                                <select id="statusImg`+cont+`" name="statusImg`+cont+`" class="input-form force-check">
                                    <option value=""></option>
                                    <option value="1">Publico</option>
                                    <option value="2">Privado</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label for="idusuario`+cont+`">Usuario da imagem:</label>
                            <label class="label-input col-12">
                                <select class="input-form" name="idusuario`+cont+`" id="idusuario`+cont+`">
                                    <option value=""></option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <input type="hidden" value="" class="force-check" id="verificaImg`+cont+`">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label for="descricaoImagem`+cont+`">Descrição:</label>
                            <label class="label-input col-12">
                                <textarea class="input-form" name="descricaoImagem`+cont+`" id="descricaoImagem`+cont+`" cols="30" rows="10"></textarea>
                            </label>
                        </div>
                    </div>`)

        geraListaUsuario("#idusuario"+cont)
        $("#contImg").val(parseInt(cont) + 1)
        
    })

    $(document).on('click', '#btnAdicionarNovaImagem', (e) => {
        e.preventDefault

        var erro = validaCamposForm([['.force-check']])

        if(erro == 1) {
            $(".toast-body").html('Há campos vazis, preencha-os para finalizar!')
            toastList[0].show()

            return false;
        } else {
            $("#formAddImagem").submit()
        }
    })

    $(document).on('change', '.input-imagens-add', (e) => {

        var cont = e.target.dataset.id
        var file = document.getElementById('imagensAdd'+cont).files[0]

        var reader = new FileReader();

        reader.readAsDataURL(file)

        reader.onload = () => {

            var ext = file.name.toString().split('.')[file.name.toString().split('.').length - 1]
            
            if(ext == 'jpg' || ext == 'jpeg' || ext == 'png') { 
                document.getElementById("newImg"+cont).src = reader.result

                $("#verificaImg"+cont).val(1)
            } else {
                $(".toast-body").html('O arquivo passado deve ser uma imagem! Selecione outra imagem!')
                toastList[0].show()

                document.getElementById("newImg"+cont).src = "../web/imagens/ec147c4c53abfe86df2bc7e70c0181ff.jpg"
                $("#verificaImg"+cont).val("")
            }
        }
    }) 

    $(document).on('click', "#btnAdicionarNovaImagem", () => {
        var descricao = $("#imagensAdd").val()

        $.ajax({
            type: 'POST',
            url: '../controllers/adiciona-imagem.php',
            data: {},
            success: (res) => {
            }
        })
    })
    // IMAGEM-----------------------------------------------------------------------------
    // USUARIO----------------------------------------------------------------------------
    $(document).on('click', '#btnPesquisaUsuario', () => {
        var nomeUsuario = $("#nomeUsuario").val()
        var emailUsuario = $("#emailUsuario").val()
        var dataCadastroInicio = $("#dataPesquisaInicio").val()
        var dataCadastroFim = $("#dataPesquisaFim").val()

        $.ajax({
            type: 'post',
            url: '../util/tabela-usuario.php',
            data: {nomeUsuario, emailUsuario, dataCadastroInicio, dataCadastroFim},
            success: (res) => {
                // console.log(res)
                $("#divTabelaUsuario").html(res)
            }
        })
    })

    $(document).on('click', "#btnAlterarInfoUsuario", () => {
        var nomeUsuario = $("#nomeAlteraUsuario").val()
        var emailUsuario = $("#emailAlteraUsuario").val()
        var statusUsuario = $("#statusUsuario").val()
        var cpfUsuario = $("#cpfUsuario").val()
        var id_session = $("#idSessionModal").val()
        var cont = $("#cont").val()

        $.ajax({
            type: 'post',
            url: '../controllers/altera-usuario.php',
            data: {id_session, cont, cpfUsuario, nomeUsuario, statusUsuario, emailUsuario},
            success: (res) => {
                console.log(res)
                
            }
        })
    })
}