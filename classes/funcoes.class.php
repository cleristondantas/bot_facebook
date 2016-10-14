<?php

class Funcoes {

    public function getIteracao($sender_id, $mensagem, $resposta, $json) {

        return $dados;

    }

    public function setIteracao($sender_id, $mensagem, $resposta, $json, $tipo) {

        $res = mysql_query("INSERT INTO interacoes (sender_id, mensagem, resposta, data_hora, json, tipo) VALUE ('" . $sender_id . "', '" . $mensagem . "', '" . $resposta . "', '" . date('Y-m-d H:i:s') . "', '" . $json . "', '" . $tipo . "')");

        return $res;
    }

}
