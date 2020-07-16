<?php

namespace Source\Controllers;

use PDO;
use Source\Models\Validations;
use Source\Models\UserLogin;

require "../../../vendor/autoload.php";
require "../../config.php";
require "../../../conexao.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":
        $data = json_decode(file_get_contents("php://input", false));

        if (!$data) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Nenhum dado enviado"));
            exit;
        }

        $errors = array();

        if (!Validations::validationEmail($data->emailCliente)) {
            array_push($errors, "email");
        }

        if (!Validations::validationString($data->senhaCliente)) {
            array_push($errors, "senha");
        }


        if (!Validations::validationInteger($data->idCliente)) {
            array_push($errors, "id");
        }


        if (count($errors) > 0) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Há campos inválidos no formulário!", "fields" => $errors));
            exit;
        }

        $userLogin = new UserLogin();
        $userLogin->emailCliente = $data->emailCliente;
        $userLogin->senhaCliente = $data->senhaCliente;
        $userLogin->idCliente = $data->idCliente;
        $userLogin->save();

        if ($userLogin->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $userLogin->fail()->getMessage()));
        }
        echo json_encode(array("response" => " cadastrado com sucesso!"));
        break;

    case "GET":
        header("HTTP/1.1 200 OK");
        $user = new UserLogin();

        $idCliente =  filter_input(INPUT_GET, "idCliente");
        $emailCliente = filter_input(INPUT_GET, "emailCliente");
        $senhaCliente = filter_input(INPUT_GET, "senhaCliente");

        $db = new PDO(
            "mysql:host=localhost;
            dbname=bdeasycare2",
            "root",
            ""
        );

        if ($idCliente != null) {
            if ($user->find()->count() > 0) {
                $return = array();
                foreach ($user->find("idCliente = :idCliente", "idCliente=" . $idCliente)->fetch(true) as $user) {
                    array_push($return, $user->data());
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Nenhum login de usuário encontrado"));
            }
        }

        if ($emailCliente != "" and $senhaCliente != "") {
            if ($user->find()->count() > 0) {
                $return = array();


                $sql = "SELECT * from tblogincliente where senhaCliente='$senhaCliente' and emailCliente='$emailCliente'";
                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();



                foreach ($lista as $user) {
                    array_push($return, $user);
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Nenhum login de usuário encontrado"));
            }

            //var_dump($return);
        }






        break;

    case "PUT":
        $userLoginID = filter_input(INPUT_GET, "idLoginCliente");

        if (!Validations::validationInteger($userLoginID)) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "ID informado é inválido, não é um valor numérico"));
            exit;
        }

        if (!$userLoginID) {
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

        if (!Validations::validationEmail($data->emailCliente)) {
            array_push($errors, "emailCliente");
        }

        if (!Validations::validationString($data->senhaCliente)) {
            array_push($errors, "senhaCliente");
        }


        /* if(!Validations::validationInteger($data->idCliente)){
            array_push($errors, "idCliente");
        } */


        if (count($errors) > 0) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Há campos inválidos no formulário!", "fields" => $errors));
            exit;
        }

        $userLogin = (new UserLogin())->findById($userLoginID);

        if (!$userLogin) {
            header("HTTP/1.1 200 OK");
            echo json_encode(array("response" => "Login de usuário não encontrado!"));
            exit;
        }

        $userLogin->emailCliente = $data->emailCliente;
        $userLogin->senhaCliente = $data->senhaCliente;


        //$userLogin->idCliente = $data-> idCliente;
        $userLogin->save();

        if ($userLogin->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $userLogin->fail()->getMessage()));
            exit;
        }

        header("HTTP/1.1 201 Created");
        echo json_encode(array("response" => "Login de usuário atualizado com sucesso!"));
        break;

    case "DELETE":
        $userLoginID = filter_input(INPUT_GET, "idLoginCliente");

        if (!Validations::validationInteger($userLoginID)) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "ID informado é inválido, não é um valor numérico"));
            exit;
        }

        if (!$userLoginID) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "id não informado"));
            exit;
        }

        $userLogin = (new UserLogin())->findById($userLoginID);
        if (!$userLogin) {
            header("HTTP/1.1 200 OK");
            echo json_encode(array("response" => "Usuário não encontrado!"));
            exit;
        }

        $userLogin->destroy();

        if ($userLogin->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $userLogin->fail()->getMessage()));
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
