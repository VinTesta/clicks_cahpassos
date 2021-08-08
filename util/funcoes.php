<?php
function trataCampo($campo, $tipo) {

    switch ($tipo) {
        case 1://string - IRÁ SE TORNAR O CASE DE MAIUSCULO
            $campoT = mb_strtoupper(trim(filter_var($campo, FILTER_SANITIZE_STRING)), 'UTF-8');
            break;
        case 2://int
            $campoT = filter_var($campo, FILTER_SANITIZE_NUMBER_INT);
            break;
        case 3://email
            $campoT = trim(filter_var($campo, FILTER_SANITIZE_EMAIL));
            break;
        case 4://text-area
            $campoT = trim(filter_var($campo, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            break;
        case 5://float/double
            $campoT = filter_var($campo, FILTER_SANITIZE_NUMBER_FLOAT);
            break;
        case 6://string
            $campoT = trim(filter_var($campo, FILTER_SANITIZE_STRING));
            break;
        default :
            $campoT = NULL;
            break;
    }

    return $campoT;
}

function geraCodigo() {//função para gerar um código a partir do sha1 da hora atual  
    $cod = sha1(microtime());
    return $cod;
}

function limpaSpecialChars($string) {
    return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($string));
}