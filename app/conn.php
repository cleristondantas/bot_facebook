<?php
// define o timezone
date_default_timezone_set("America/Sao_Paulo");

//===========================================================================================================
//Conectando com o Banco de Dados

$def_con_localhost = 'localhost';
$def_con_user = 'user';
$def_con_pass = 'pass';
$def_con_bd = 'fretebot';

$conexao = mysql_connect ($def_con_localhost, $def_con_user, base64_decode($def_con_pass));

if (!$conexao) {
   die;
}

if (!mysql_select_db($def_con_bd)) {
    die;
}
