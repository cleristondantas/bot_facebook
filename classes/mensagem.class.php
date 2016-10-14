<?php

class Mensagens {

    public function msgPrepara($sender_id, $tipo, $especifica = null)
    {

        // verifica se tem registro
        $sql = "SELECT * FROM usuarios WHERE sender_id = ". $sender_id;
        $x = mysql_query($sql);


        $nome = '';
        $placa = '';
        $cod_veiculo = '';

        $mensagens = array();
        // tem registro
        if (mysql_num_rows($x) > 0) {
            while ($res = mysql_fetch_array($x)) {
                $nome = $res['nome'];
                $placa = $res['placa'];
                $cod_veiculo = $res['cod_veiculo'];
            }

        } else {
            // cadastra usuario
            mysql_query("INSERT INTO usuarios (sender_id) VALUE ('" . $sender_id . "')");
        }

        $esp = '';
        if ($especifica != null) {
            $esp = ' && id = ' . $especifica;
        }

        $sql = "SELECT saida, variavel FROM dialogos_base WHERE tipo = " . $tipo . $esp;

        $x = mysql_query($sql);

        while ($res = mysql_fetch_array($x)) {
            $mensagem[] = $res['saida'];
        }

        // if ($nome != '' || !is_null($nome)) {
        //     $mensagemFinal = str_replace('#', $nome, $mensagem[rand(0, (count($mensagem) - 1))]);
        // } else {
        //     $mensagemFinal = str_replace('#', $nome, $mensagem[rand(0, (count($mensagem) - 1))]);
        // }

        $mensagemFinal = str_replace('#', $nome, $mensagem[rand(0, (count($mensagem) - 1))]);

        return $mensagemFinal;

    }

    public function respondeNome($sender_id, $text) {

        // vê ultima mensagem

        $sql = "SELECT * FROM interacoes WHERE sender_id = " . $sender_id . " order by id desc LIMIT 1";

        $x = mysql_query($sql);

        if (mysql_num_rows($x) > 0) {

            while ($res = mysql_fetch_array($x)) {
                $tipoUltima = $res['tipo'];
                $hora = $res['data_hora'];
            }

            if ($tipoUltima == 22 && $this->tempoAtras($hora)) {
                $sql = "UPDATE usuarios set nome = '" . $text . "' WHERE sender_id = " . $sender_id;
                mysql_query($sql);
            }

        }

        return $sql;

    }

    public function descobreTipoMensagem($sender_id, $texto)
    {

        $texto = $this->sanitizeString($texto);

        $explode = explode('_', $texto);

        $A = 0;
        $I = 0;
        $D = 0;

        $R = 0;

        $O = 0;
        $N = 0;
        // chuta o tipo de mensagem
        // 1 Apresentação
        // 2 Informativa
        // 3 Aleatória
        // 4 Despedida

        foreach ($explode as $key => $value) {


            $sql = "SELECT count(tipo) as qtd, tipo FROM dialogos_base WHERE entrada like '%" . $value . "%' group by tipo";
            $x = mysql_query($sql);

            $sqlNome = "SELECT id FROM usuarios WHERE nome like '%" . $value . "%'";
            $xNome = mysql_query($sqlNome);

            if (mysql_num_rows($xNome) > 0) {
                $N += 14;
            }
            // Se maior que 1... mensagem com muitas opcoes
            if (mysql_num_rows($x) > 1) {
                // computa as maiores

                while ($res = mysql_fetch_array($x)) {

                    switch ($res['tipo']) {
                        case '1':
                            $A += $res['qtd'];
                            break;
                        case '2':
                            $I += $res['qtd'];
                            break;
                        case '3':
                            $R += $res['qtd'];
                            break;
                        case '4':
                            $D += $res['qtd'];
                            break;
                        case '6':
                            $N += $res['qtd'];
                            break;
                        default:
                            $O++;
                            break;
                    }

                }
            }

            // muito provavel ser de um so tipo de assunto
            if (mysql_num_rows($x) == 1) {

                while ($res = mysql_fetch_array($x)) {

                    if ($res['qtd'] == 1){

                        $unico = "SELECT id, tipo FROM dialogos_base WHERE entrada like '%" . $value . "%'";
                        $xUnico = mysql_query($unico);

                        while ($resUnico = mysql_fetch_array($xUnico)) {
                            return array('tipos' => array($resUnico['tipo'] => 10000), 'unico' => $resUnico['id']);
                        }

                    } else  {

                        switch ($res['tipo']) {
                            case '1':
                                $A += $res['qtd'] + 10;
                                break;
                            case '2':
                                $I += $res['qtd'] + 10;
                                break;
                            case '3':
                                $R += $res['qtd'] + 10;
                                break;
                            case '4':
                                $D += $res['qtd'] + 10;
                                break;
                            case '6':
                                $N += $res['qtd'] + 10;
                                break;
                            default:
                                $O++;
                                break;
                        }
                    }
                }
            }

            // sem assunto na base
            if (mysql_num_rows($x) == 0) {
                $O++;
            }

        }



        return array('tipos' => array('1' => $A,
                             '2' => $I,
                             '3' => $D,
                             '4' => $R,
                             '5' => $O,
                             '6' => $N), 'unico' => '');
    }

    function sanitizeString($str)
    {
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);
        // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
        $str = preg_replace('/[^a-z0-9]/i', '_', $str);
        // $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
        return $str;
    }

    function oMelhor($tipo)
    {
        $maior = 0;
        $quem = '';

        foreach ($tipo as $key => $value) {
            if ($value > $maior) {
                $maior = $value;
                $quem = $key;
            }
        }

        return $quem;
    }

    public function tempoAtras($time) {
        ini_set('date.timezone','America/Sao_Paulo');

        $time = strtotime($time);

        $diff = time() - $time;
        $seconds = $diff;
        $minutes = round($diff / 60);

        if ($minutes <= 3) return true;
        else return false;
    }


}
