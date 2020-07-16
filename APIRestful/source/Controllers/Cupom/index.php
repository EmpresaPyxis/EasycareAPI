<?php

namespace Source\Controllers;

use Source\Models\Validations;
use Source\Models\Cupom;

require "../../../vendor/autoload.php";
require "../../config.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":
        $data = json_decode(file_get_contents("php://input", false));

        if (!$data) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Nenhum dado enviado"));
            exit;
        }

        $errors = array();

        if (!Validations::validationString($data->cupom)) {
            array_push($errors, "cupom");
        }

        if (!Validations::validationInteger($data->valorCupom)) {
            array_push($errors, "valorCupom");
        }

        if (count($errors) > 0) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Há campos inválidos no formulário!", "fields" => $errors));
            exit;
        }

        $cupom = new Cupom();
        $cupom->cupom = $data->cupom;
        $cupom->valorCupom = $data->valorCupom;
        $cupom->save();

        if ($cupom->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $cupom->fail()->getMessage()));
        }
        echo json_encode(array("response" => " cadastrado com sucesso!"));
        break;

    case "GET":
        header("HTTP/1.1 200 OK");
        $cupoms = new Cupom();
        $cupom =  filter_input(INPUT_GET, "cupom");

        if ($cupoms->find("cupom = :cupom", "cupom=" . $cupom)->count() > 0) {
            $return = array();
            foreach ($cupoms->find("cupom = :cupom", "cupom=" . $cupom)->fetch(true) as $cupom) {
                array_push($return, $cupom->data());
            }
            echo json_encode(array("response" => $return));
        } else {
            echo json_encode(array("response" => "Cupom não encontrado"));
        }

        break;

    case "PUT":
        $cupomID = filter_input(INPUT_GET, "idCupom");

        if (!Validations::validationInteger($cupomID)) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "ID informado é inválido, não é um valor numérico"));
            exit;
        }

        if (!$cupomID) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "id não informado"));
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), false);

        if (!$data) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Nenhum dado enviado"));
            exit;
        }

        $errors = array();

        if (!Validations::validationString($data->cupom)) {
            array_push($errors, "Cupom");
        }

        if (!Validations::validationInteger($data->valorCupom)) {
            array_push($errors, "valorCupom");
        }


        if (count($errors) > 0) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Há campos inválidos no formulário!", "fields" => $errors));
            exit;
        }

        $cupom = (new Cupom())->findById($cupomID);

        if (!$cupom) {
            header("HTTP/1.1 200 OK");
            echo json_encode(array("response" => "Usuário não encontrado!"));
            exit;
        }

        $cupom->cupom = $data->cupom;
        $cupom->valorCupom = $data->valorCupom;
        $cupom->save();

        if ($cupom->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $cupom->fail()->getMessage()));
            exit;
        }

        header("HTTP/1.1 201 Created");
        echo json_encode(array("response" => "Usuário atualizado com sucesso!"));
        break;

    case "DELETE":
        $cupomID = filter_input(INPUT_GET, "idCupom");

        if (!$cupomID) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Id não informado"));
            exit;
        }

        if (!Validations::validationInteger($cupomID)) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "ID informado é inválido, não é um valor numérico"));
            exit;
        }

        $cupom = (new Cupom())->findById($cupomID);
        if (!$cupom) {
            header("HTTP/1.1 200 OK");
            echo json_encode(array("response" => "Usuário não encontrado!"));
            exit;
        }

        $cupom->destroy();

        if ($cupom->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $cupom->fail()->getMessage()));
            exit;
        }

        header("HTTP/1.1 200 OK");
        echo json_encode(array("response" => "Usuário removido com sucesso!"));

        break;

    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("response" => "Método não previsto na API"));
        break;
}
