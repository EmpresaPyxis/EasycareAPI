<?php

namespace Source\Controllers;

use PDO;
use Exception;
use Source\Models\Validations;
use Source\Models\CuponsCliente;

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

        if (count($errors) > 0) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Há campos inválidos no formulário!", "fields" => $errors));
            exit;
        }

        $cupom = new CuponsCliente();
        $cupom->idcupom = $data->idcupom;
        $cupom->idcliente = $data->idcliente;
        $cupom->save();

        if ($cupom->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $cupom->fail()->getMessage()));
        }
        echo json_encode(array("response" => "Cupom utilizado"));
        break;

    case "GET":
        header("HTTP/1.1 200 OK");
        $cupoms = new CuponsCliente();
        $idCupom = filter_input(INPUT_GET, "idCupom");
        $idCliente = filter_input(INPUT_GET, "idCliente");

        $db = new PDO(
            "mysql:host=localhost;
            dbname=bdeasycare2",
            "root",
            ""
        );

        if ($idCliente != null && $idCupom != null) {
            if ($cupoms->find()->count() > 0) {
                $return = array();
                $sql = "SELECT * from tbcuponscliente where idCupom='$idCupom' and idCliente=$idCliente";
                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();

                foreach ($lista as $cupoms) {
                    array_push($return, $cupoms);
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Erro de parametros: BAD REQUEST"));
            }
        } else {
            if ($cupoms->find()->count() > 0) {
                $return = array();
                $sql = "SELECT idcuponscliente, c.cupom, c.valorCupom from tbcuponscliente cc
                    INNER JOIN tbcupom c on cc.idCupom = c.idCupom
                    where cc.idCliente=$idCliente";
                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();

                foreach ($lista as $cupoms) {
                    array_push($return, $cupoms);
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Erro de parametros: BAD REQUEST"));
            }
        }
        break;

    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("response" => "Método não previsto na API"));
        break;
}
