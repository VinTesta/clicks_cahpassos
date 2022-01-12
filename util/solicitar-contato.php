<?php

require_once('../layout/cabecalho.php');

//Load Composer's autoloader
require '../vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if($_SESSION['emailUsuarioClicks'] != '') {

    $usuarioDao = new UsuarioDao($conexao);

    $emailUser['emailUsuario'] = $_SESSION['emailUsuarioClicks'];

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
            $mail->addAddress('suporte.clickscarolpassos@gmail.com', 'Proprietario');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Solicitacao de contato';
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
                                Um usuario solicitou contato pelo e-mail:
                                <br>Nome: '.$_SESSION['nomeUsuario'].
                                '<br>E-mail: '.$_SESSION['emailUsuarioClicks'].
                                '<br>Data da solicitação: '. date('d/m/Y h:i:s').'
                            </div>
                        </div>
                    </div>
                </body>
                </html>';

            $mail->AltBody = 'Um usuario solicitou contato pelo e-mail:
                                <br>Nome: '.$_SESSION['nomeUsuario'].
                                '<br>E-mail: '.$_SESSION['emailUsuarioClicks'].
                                '<br>Data da solicitação: '. date('d/m/Y h:i:s');

            
            if($mail->send()) {
                ?>

                <script type="text/javascript">
                    localStorage.setItem('alerta', 'Estamos analizando seu contato! Em breve entraremos em contato para conversamos mais! Até logo..!')
                    location = '../pacotes/'
                </script>
                <?php
            }
        } catch (Exception $e) {
            ?>
            <script type="text/javascript">
                localStorage.setItem('alerta', 'Houve um erro ao solicitar contato!')
                location = '../pacotes/'
            </script>
            <?php
        }
    } else {
        ?>
        <script type="text/javascript">
            localStorage.setItem('alerta', 'Houve um erro ao solicitar contato! (10007)')
            location = '../pacotes/'
        </script>
        <?php
    }
}