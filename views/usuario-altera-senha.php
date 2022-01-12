<?php

require_once('../layout/cabecalho.php');

//Load Composer's autoloader
require '../vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if($_POST['emailForg'] != '') {

    $usuarioDao = new UsuarioDao($conexao);

    $emailUser['emailUsuario'] = $_POST['emailForg'];

    $resultado = $usuarioDao->verificaValidadeEmail($emailUser);

    for($i = 0; $i < 6; $i++){
        $codRec[] = rand(0, 9);
    }

    foreach($codRec as $cod) {
        $hash .= $cod;
    }
    
    if($resultado != '') {
        
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        // var_dump($mail);

        try {
            //Server settings
            $mail->IsSMTP();
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'suporte.clickscarolpassos@gmail.com';                     //SMTP username
            $mail->Password   = '63K*@LaM';                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = 587; 

            //Recipients
            $mail->setFrom('suporte.clickscarolpassos@gmail.com', 'Equipe Carol Passos');
            $mail->addAddress($emailUser['emailUsuario'], 'Honrado Usuario');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Alterar senha da conta';
            $mail->Body    = '<!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Alteração de senha</title>
                <style>
                    .container {
                        width: 100%; 
                        display: flex; 
                        justify-content: center; 
                        align-itens: center; 
                        padding: 50px
                    }
            
                    .row {
                        width: 100%; 
                        display: flex; 
                        justify-content: center; 
                        align-itens: center
                    }
            
                    .form-email {
                        width: 100%; 
                        display: flex; 
                        justify-content: center; 
                        align-itens: center
                    }
            
                    .col-12 {
                        width: 100%;
                    }
            
                    .btn-form {
                        color: white;
                        background-color: black;
                        border: 1px solid black;
                        padding: 7px;
                        transition: .5s;
                        cursor: pointer;
                    }
            
                    .btn-form:hover {
                        background-color: transparent;
                        color: black;
                        transition: .5s;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            Para alterar a senha de sua conta basta clicar no botão de alterar senha<br><br>
                                <form class="form-email" action="localhost/clicks_cahpassos/criar-senha/" method="post">
                                    <input type="hidden" name="idUsuario" value="'.$resultado['idusuario'].'">
                                    <input type="hidden" name="emailUser" value="'.$emailUser['emailUsuario'].'">
                                    <button class="btn-form" name="btnFormAlteraSenha" type="submit">
                                        Alterar Senha
                                    </button>
                            </form>
                        </div>
                    </div>
                </div>
            </body>
            </html>';

            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // var_dump($mail);

            if($mail->send()) {
                ?>

                <script type="text/javascript">
                    localStorage.setItem('alerta', 'Uma mensagem foi enviada para a caixa de e-mail do usuario, acesse a mensagem e altere a senha!')
                    location = '../login/'
                </script>
                <?php
            }
        } catch (Exception $e) {
            var_dump($e);
            ?>
            <script type="text/javascript">
                // localStorage.setItem('alerta', 'Houve um erro para alterar a senha')
                // location = '../login/'
            </script>
            <?php
        }
    } else {
        ?>
        <script type="text/javascript">
            localStorage.setItem('alerta', 'Houve um erro para alterar a senha (10007)')
            location = '../login/'
        </script>
        <?php
    }
}