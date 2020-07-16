<?php

namespace Source\Controllers;

use Source\Models\Validation;
use Source\Models\Establishment;

require "../../../vendor/autoload.php";
require "../../config.php";

switch ($_SERVER['REQUEST_METHOD']) {
  case "GET":
    header("HTTP/1.1 200 OK");
    $establishment = new Establishment();

    $idEstablishment =  filter_input(INPUT_GET, "idEstabelecimento");

    //if($establishment->find()->count()>0) {
    $return = array();
    if ($idEstablishment == '') {

      if ($establishment->find()->count() > 0) {
        foreach ($establishment->find()->fetch(true) as $establishment) {
          //tratamento
          array_push($return, $establishment->data());
        }
        echo json_encode(array("response" => $return));
      } else {
        echo json_encode(array("response" => "Nenhum estabelecimento localizado!!"));
      }
    } else {
      if ($establishment->find()->count() > 0) {
        foreach ($establishment->find("idEstabelecimento = :idEstabelecimento", "idEstabelecimento=" . $idEstablishment)->fetch(true) as $establishment) {
          //tratamento
          array_push($return, $establishment->data());
        }
        echo json_encode(array("response" => $return));
      } else {
        echo json_encode(array("response" => "Nenhum estabelecimento localizado!!"));
      }
    }
    break;

  default:
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(array("response" => "Método não previsto na API"));
    break;
}
