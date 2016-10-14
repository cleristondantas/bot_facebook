<?php
include 'app/config.php';
include 'app/conn.php';
include 'classes/funcoes.class.php';
include 'classes/mensagem.class.php';


// BOT
$hub_verify_token = null;


if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
}

if ($hub_verify_token === VERIFY_TOKEN) {
    echo $challenge;
}

$update_response = file_get_contents("php://input");

$update = json_decode($update_response, true);

if (isset($update['entry'][0]['messaging'][0])) {
    processMessage($update['entry'][0]['messaging'][0]);
}

function processMessage($message) {

    $sender = $message['sender']['id'];//id do emissor
    $text = $message['message']['text'];//texto recebido na mensagem

    // verifica mensagem anterior

    $mens = new Mensagens();

    if (isset($text)) {

        $name = $mens->respondeNome($sender, $text);

        $tipo = $mens->descobreTipoMensagem($sender, $text);
        $melhor = $mens->oMelhor($tipo['tipos']);
        $mensagem = $mens->msgPrepara($sender, $melhor, $tipo['unico']);

        if (preg_match('[pedrosa|meu fii|meu fi]', strtolower($text))) {
            $mensagem = 'pedrosa é ele..';

            $arrFinal = array('recipient' => array('id' => $sender),
                      'message' => array(
                            "attachment" => array('type'=>'image', 'payload' => array('url' => '<URL de uma imagem>'))
                            ),
                      );

            sendMessage($arrFinal, $sender, $text, $mensagem, json_encode($message), $melhor);

        } elseif (preg_match('[ruiter|ruitão|ruitao|777|chmod]', strtolower($text))) {

             $arrFinal = array('recipient' => array('id' => $sender),
                      'message' => array(
                            "attachment" => array('type'=>'audio',
                                            'payload' => array( "url" => "<URL_DE_AUDIO_MP3>"))
                            ),
                      );
            sendMessage($arrFinal, $sender, $text, $mensagem, json_encode($message), $melhor);
            die;

        } elseif (preg_match('[telefone|fone|contato|whatsapp]', strtolower($text))) {

            $arrFinal = array('recipient' => array('id' => $sender),
                      'message' => array(
                            "attachment" => array('type'=>'template',
                                            'payload' => array( "template_type" => "button", "text" => "Entre em contato", 'buttons' => array(
                                                array('type' => 'phone_number', 'title' => 'Telefone', 'payload' => '+556499999999'),
                                                array('type' => 'phone_number', 'title' => 'WhatsApp', 'payload' => '+556488888888'))))
                            ),
                      );
            sendMessage($arrFinal, $sender, $text, $mensagem, json_encode($message), $melhor);
            die;
        } elseif (preg_match('[thiask|asdsad|ohh]', strtolower($text))) {
            $mensagem = 'Menino Thiask';

            $arrFinal = array('recipient' => array('id' => $sender),
                      'message' => array(
                            "attachment" => array('type'=>'image', 'payload' => array('url' => 'URL_IMAGEM'))
                            ),
                      );

            sendMessage($arrFinal, $sender, $text, $mensagem, json_encode($message), $melhor);

        } elseif ($mensagem == '' || $melhor == 5) {
            $mensagem = 'meu fiiii!! ainda nao sei dizer nada sobre isso, estou aprendendo ;)';
        }

        $arrFinal = array('recipient' => array('id' => $sender),
                      'message' => array(
                            "text" => $mensagem
                            ),
                      );
        sendMessage($arrFinal, $sender, $text, $mensagem, json_encode($message), $melhor);
    }
}

function sendMessage($parameters, $sender_id, $mensagem, $resposta, $json, $tipo) {
    $func = new Funcoes();
    $func->setIteracao($sender_id, $mensagem, $resposta, $json, $tipo);

    $options = array(
        'http' => array(
            'method'  => 'POST',
            'content' => json_encode($parameters),
            'header'=>  "Content-Type: application/json\r\n" .
            "Accept: application/json\r\n"
            )
        );


    $context  = stream_context_create( $options );
    file_get_contents(API_URL, false, $context );

}


