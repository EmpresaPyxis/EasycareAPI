<?php

namespace Source\Controllers;

use Source\Models\Validations;
use Source\Models\User;

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

        if (!Validations::validationString($data->nomeCliente)) {
            array_push($errors, "Nome");
        }

        if (count($errors) > 0) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Há campos inválidos no formulário!", "fields" => $errors));
            exit;
        }

        $user = new User();
        //$user->idCliente = $data->idCliente;
        $user->nomeCliente = $data->nomeCliente;
        $user->cpfCliente = $data->cpfCliente;
        $user->save();

        if ($user->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $user->fail()->getMessage()));
        }

        echo json_encode(array("response" => "Usuário cadastrado com sucesso!"));
        break;

    case "GET":
        header("HTTP/1.1 200 OK");
        $users = new User();

        $cpfCliente =  filter_input(INPUT_GET, "cpfCliente");
        $idCliente =  filter_input(INPUT_GET, "idCliente");

        if ($idCliente != null) {
            if ($users->find("idCliente = :idCliente", "idCliente=" . $idCliente)->count() > 0) {
                $return = array();
                foreach ($users->find()->fetch(true) as $user) {
                    array_push($return, $user->data());
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Nenhum usuário encontrado"));
            }
        }

        if ($cpfCliente != null) {
            if ($users->find()->count() > 0) {
                $return = array();
                foreach ($users->find("cpfCliente = :cpfCliente", "cpfCliente=" . $cpfCliente)->fetch(true) as $user) {
                    array_push($return, $user->data());
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Nenhum usuário encontrado"));
            }
        }
        break;

    case "PUT":
        $userID = filter_input(INPUT_GET, "idCliente");

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

        if (!Validations::validationString($data->nomeCliente)) {
            array_push($errors, "Nome");
        }

        if (count($errors) > 0) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Há campos inválidos no formulário!", "fields" => $errors));
            exit;
        }

        $user = (new User())->findById($userID);

        if (!$user) {
            header("HTTP/1.1 200 OK");
            echo json_encode(array("response" => "Usuário não encontrado!"));
            exit;
        }

        $user->nomeCliente = $data->nomeCliente;
        $user->cpfCliente = $data->cpfCliente;
        $user->save();

        if ($user->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $user->fail()->getMessage()));
            exit;
        }

        header("HTTP/1.1 201 Created");
        echo json_encode(array("response" => "Usuário atualizado com sucesso!"));

        break;

    case "DELETE":
        /*$userID = filter_input(INPUT_GET, "id");

        if(!$userID){
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Id não informado"));
            exit;
        }
            
        if(!Validations::validationInteger($userID)){
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response"=> "ID informado é inválido, não é um valor numérico"));
            exit;
        }

        $user = (new User())->findById($userID);
        if(!$user){
            header("HTTP/1.1 200 OK");
            echo json_encode(array("response" => "Usuário não encontrado!"));
            exit;
        }

        $user->destroy();

        if($user->fail()){
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" =>$user->fail()->getMessage()));
            exit;
        }

        header("HTTP/1.1 200 OK");
        echo json_encode(array("response" => "Usuário removido com sucesso!"));
        */
        break;

    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("response" => "Método não previsto na API"));
        break;
}
