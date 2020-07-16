<?php

namespace Source\Controllers;

use Source\Models\Validations;
use Source\Models\FormaPagamento;

require "../../../vendor/autoload.php";
require "../../config.php";

switch ($_SERVER['REQUEST_METHOD']) {

    case "GET":
        header("HTTP/1.1 200 OK");
        $pagamento = new FormaPagamento();

        if ($pagamento->find()->count() > 0) {
            $return = array();
            foreach ($pagamento->find()->fetch(true) as $pagamento) {
                array_push($return, $pagamento->data());
            }
            echo json_encode(array("response" => $return));
        } else {
            echo json_encode(array("response" => "Cupom não encontrado"));
        }

        break;

    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("response" => "Método não previsto na API"));
        break;
}
