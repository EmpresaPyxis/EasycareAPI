<?php

namespace Source\Controllers;

use Source\Models\Validations;
use Source\Models\EstablishmentEmail;

require "../../../vendor/autoload.php";
require "../../config.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        header("HTTP/1.1 200 OK");
        $email = new EstablishmentEmail();
        $idEstabelecimento = filter_input(INPUT_GET, "idEstabelecimento");

        if ($email->find()->count() > 0) {
            $return = array();
            foreach ($email->find("idEstabelecimento = :idEstabelecimento", "idEstabelecimento=" . $idEstabelecimento)->fetch(true) as $email) {
                //tratamento dos dados vindos do banco
                array_push($return, $email->data());
            }
            echo json_encode(array("response" => $return));
        } else {
            echo json_encode(array("response" => "Nenhum email encontrado"));
        }
        break;


    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("response" => "Método não previsto na API"));
        break;
}
