<?php

namespace Source\Controllers;

use Source\Models\Validations;
use Source\Models\EnderecoCliente;

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

        if (!Validations::validationString($data->logCliente)) {
            array_push($errors, "logCliente");
        }

        if (!Validations::validationNumLog($data->numLogCliente)) {
            array_push($errors, "numLogCliente");
        }

        if (!Validations::validationString($data->complementoLogCliente)) {
            array_push($errors, "complementoLogCliente");
        }

        if (!Validations::validationString($data->bairroLogCliente)) {
            array_push($errors, "bairroLogCliente");
        }

        if (!Validations::validationString($data->cidadeLogCliente)) {
            array_push($errors, "cidadeLogCliente");
        }

        if (!Validations::validationUF($data->ufLogCliente)) {
            array_push($errors, "ufLogCliente");
        }

        if (!Validations::validationInteger($data->idCliente)) {
            array_push($errors, "idCliente");
        }

        if (count($errors) > 0) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Há campos inválidos no formulário!", "fields" => $errors));
            exit;
        }

        $endereco = new EnderecoCliente();
        $endereco->logCliente = $data->logCliente;
        $endereco->numLogCliente = $data->numLogCliente;
        $endereco->complementoLogCliente = $data->complementoLogCliente;
        $endereco->bairroLogCliente = $data->bairroLogCliente;
        $endereco->cidadeLogCliente = $data->cidadeLogCliente;
        $endereco->cepLogCliente = $data->cepLogCliente;
        $endereco->ufLogCliente = $data->ufLogCliente;
        $endereco->idCliente = $data->idCliente;
        $endereco->idLocal = $data->idLocal;
        $endereco->save();

        if ($endereco->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $endereco->fail()->getMessage()));
        }

        echo json_encode(array("response" => "Endereço cadastrado com sucesso!"));
        break;

    case "GET":
        header("HTTP/1.1 200 OK");
        $endereco = new EnderecoCliente();
        $idCliente =  filter_input(INPUT_GET, "idCliente");
        $log =  filter_input(INPUT_GET, "idEnderecoCliente");

        if (!$endereco) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "id não informado"));
            exit;
        }

        if ($idCliente != null) {
            if ($endereco->find()->count() > 0) {
                $return = array();

                foreach ($endereco->find("idCliente = :idCliente", "idCliente=" . $idCliente)->fetch(true) as $endereco) {
                    array_push($return, $endereco->data());
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Nenhum usuário encontrado"));
            }
        } else if ($log != 0) {
            if ($endereco->find()->count() > 0) {
                $return = array();
                foreach ($endereco->find("idEnderecoCliente = :idEnderecoCliente", "idEnderecoCliente=" . $log)->fetch(true) as $endereco) {
                    array_push($return, $endereco->data());
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Nenhum usuário encontrado"));
            }
        }
        break;

    case "PUT":
        $userID = filter_input(INPUT_GET, "idEnderecoCliente");

        if (!Validations::validationInteger($userID)) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "ID informado é inválido, não é um valor numérico"));
            exit;
        }

        if (!$userID) {
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

        if (!Validations::validationString($data->logCliente)) {
            array_push($errors, "logCliente");
        }

        if (!Validations::validationNumLog($data->numLogCliente)) {
            array_push($errors, "numLogCliente");
        }

        if (!Validations::validationString($data->complementoLogCliente)) {
            array_push($errors, "complementoLogCliente");
        }

        if (!Validations::validationString($data->bairroLogCliente)) {
            array_push($errors, "bairroLogCliente");
        }

        if (!Validations::validationString($data->cidadeLogCliente)) {
            array_push($errors, "cidadeLogCliente");
        }

        if (!Validations::validationUF($data->ufLogCliente)) {
            array_push($errors, "ufLogCliente");
        }

        if (!Validations::validationInteger($data->idCliente)) {
            array_push($errors, "idCliente");
        }

        if (count($errors) > 0) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Há campos inválidos no formulário!", "fields" => $errors));
            exit;
        }

        $endereco = (new EnderecoCliente())->findById($userID);

        if (!$endereco) {
            header("HTTP/1.1 200 OK");
            echo json_encode(array("response" => "Usuário não encontrado!"));
            exit;
        }

        $endereco->logCliente = $data->logCliente;
        $endereco->numLogCliente = $data->numLogCliente;
        $endereco->complementoLogCliente = $data->complementoLogCliente;
        $endereco->bairroLogCliente = $data->bairroLogCliente;
        $endereco->cidadeLogCliente = $data->cidadeLogCliente;
        $endereco->cepLogCliente = $data->cepLogCliente;
        $endereco->ufLogCliente = $data->ufLogCliente;
        $endereco->idCliente = $data->idCliente;
        $endereco->idLocal = $data->idLocal;
        $endereco->save();

        if ($endereco->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $endereco->fail()->getMessage()));
            exit;
        }

        header("HTTP/1.1 201 Created");
        echo json_encode(array("response" => "Endereço atualizado com sucesso!"));

        break;

    case "DELETE":
        $userID = filter_input(INPUT_GET, "idEnderecoCliente");

        if (!$userID) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Id não informado"));
            exit;
        }

        if (!Validations::validationInteger($userID)) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "ID informado é inválido, não é um valor numérico"));
            exit;
        }

        $endereco = (new EnderecoCliente())->findById($userID);
        if (!$endereco) {
            header("HTTP/1.1 200 OK");
            echo json_encode(array("response" => "Endereço não encontrado!"));
            exit;
        }

        $endereco->destroy();

        if ($endereco->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $endereco->fail()->getMessage()));
            exit;
        }

        header("HTTP/1.1 200 OK");
        echo json_encode(array("response" => "Endereço removido com sucesso!"));

        break;

    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("response" => "Método não previsto na API"));
        break;
}
