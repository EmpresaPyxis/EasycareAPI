<?php

namespace Source\Controllers;

use Source\Models\Validations;
use Source\Models\EstablishmentPhone;

require "../../../vendor/autoload.php";
require "../../config.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        header("HTTP/1.1 200 OK");
        $phone = new EstablishmentPhone();
        $idEstabelecimento = filter_input(INPUT_GET, "idEstabelecimento");

        if ($phone->find()->count() > 0) {
            $return = array();
            foreach ($phone->find("idEstabelecimento = :idEstabelecimento", "idEstabelecimento=" . $idEstabelecimento)->fetch(true) as $phone) {
                //tratamento dos dados vindos do banco
                array_push($return, $phone->data());
            }
            echo json_encode(array("response" => $return));
        } else {
            echo json_encode(array("response" => "Nenhum telefone encontrado"));
        }
        break;


    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("response" => "Método não previsto na API"));
        break;
}
