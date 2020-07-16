<?php

namespace Source\Controllers;

use Source\Models\Validations;
use Source\Models\UserPhone;

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

        if (!Validations::validationInteger($data->idCliente)) {
            array_push($errors, "id");
        }

        if (count($errors) > 0) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Há campos inválidos no formulário!", "fields" => $errors));
            exit;
        }

        $userPhone = new UserPhone();
        $userPhone->numFoneCliente = $data->numFoneCliente;
        $userPhone->idCliente = $data->idCliente;
        $userPhone->save();

        if ($userPhone->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $userPhone->fail()->getMessage()));
        }
        echo json_encode(array("response" => " cadastrado com sucesso!"));
        break;

    case "GET":
        header("HTTP/1.1 200 OK");
        $phone = new UserPhone();

        $idCliente =  filter_input(INPUT_GET, "idCliente");

        if ($phone->find()->count() > 0) {
            $return = array();
            foreach ($phone->find("idCliente = :idCliente", "idCliente=" . $idCliente)->fetch(true) as $phone) {
                array_push($return, $phone->data());
            }
            echo json_encode(array("response" => $return));
        } else {
            echo json_encode(array("response" => "Nenhum telefone encontrado"));
        }
        break;

    case "PUT":

        $userPhoneID = filter_input(INPUT_GET, "idFoneCliente");

        if (!Validations::validationInteger($userPhoneID)) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "ID informado é inválido, não é um valor numérico"));
            exit;
        }

        if (!$userPhoneID) {
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

        if (count($errors) > 0) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Há campos inválidos no formulário!", "fields" => $errors));
            exit;
        }

        $userPhone = (new UserPhone())->findById($userPhoneID);

        if (!$userPhone) {
            header("HTTP/1.1 200 OK");
            echo json_encode(array("response" => "Login de usuário não encontrado!"));
            exit;
        }

        $userPhone->numFoneCliente = $data->numFoneCliente;
        $userPhone->save();

        if ($userPhone->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $userPhone->fail()->getMessage()));
            exit;
        }

        header("HTTP/1.1 201 Created");
        echo json_encode(array("response" => "Login de usuário atualizado com sucesso!"));
        break;

        /*case "DELETE":
            $userPhoneID = filter_input(INPUT_GET, "idLoginCliente");

            if(!Validations::validationInteger($userPhoneID)){
                header("HTTP/1.1 400 Bad Request");
                echo json_encode(array("response"=> "ID informado é inválido, não é um valor numérico"));
                exit;
            }
            
            if(!$userPhoneID){
                header("HTTP/1.1 400 Bad Request");
                echo json_encode(array("response" => "id não informado"));
                exit;
            }

            $userPhone = (new UserLogin())->findById($userPhoneID);
            if(!$userPhone){
                header("HTTP/1.1 200 OK");
                echo json_encode(array("response" => "Usuário não encontrado!"));
                exit;
            }

            $userPhone->destroy();

            if($userPhone->fail()){
                header("HTTP/1.1 500 Internal Server Error");
                echo json_encode(array("response" =>$userPhone->fail()->getMessage()));
                exit;
            }

            header("HTTP/1.1 200 OK");
            echo json_encode(array("response" => "Usuário removido com sucesso!"));
        
        break;*/

    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("response" => "Método não previsto na API"));
        break;
}
