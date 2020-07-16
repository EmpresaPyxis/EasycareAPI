<?php

namespace Source\Controllers;

use Source\Models\Validations;
use Source\Models\Venda;
use PDO;

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

        /*if(!Validations::validationString($data->dataVenda)){
            array_push($errors, "dataVenda");
        }

        if(!Validations::validationInteger($data->horaVenda)){
            array_push($errors, "horaVenda");
        }*/

        if (count($errors) > 0) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Há campos inválidos no formulário!", "fields" => $errors));
            exit;
        }

        $venda = new Venda();
        $venda->dataVenda = $data->dataVenda;
        $venda->horaVenda = $data->horaVenda;
        $venda->subTotalVenda = $data->subTotalVenda;
        $venda->totalVenda = $data->totalVenda;
        $venda->observacaoVenda = $data->observacaoVenda;
        $venda->idCliente = $data->idCliente;
        $venda->idEnderecoCliente = $data->idEnderecoCliente;
        $venda->idCupom = $data->idCupom;
        $venda->taxaEntrega = $data->taxaEntrega;
        $venda->idProduto = $data->idProduto;
        $venda->idMedicamento = $data->idMedicamento;
        $venda->idEstabelecimento = $data->idEstabelecimento;
        $venda->idStatusVenda = $data->idStatusVenda;
        $venda->idFormaPagamento = $data->idFormaPagamento;
        $venda->qtdProduto = $data->qtdProduto;
        $venda->save();

        if ($venda->fail()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("response" => $venda->fail()->getMessage()));
        }
        echo json_encode(array("response" => "Compra realizada com sucesso!"));
        break;

    case "GET":
        header("HTTP/1.1 200 OK");
        $venda = new Venda();
        $idCliente =  filter_input(INPUT_GET, "idCliente");

        $db = new PDO(
            "mysql:host=localhost;
            dbname=bdeasycare2",
            "root",
            ""
        );

        if ($venda->find()->count() > 0) {
            $return = array();
            $sql = "SELECT idVenda, dataVenda, horaVenda, subTotalVenda, totalVenda, observacaoVenda, idCliente, idEnderecoCliente, idCupom, taxaEntrega, idEstabelecimento, idFormaPagamento, s.descStatusVenda, idMedicamento, idProduto, qtdProduto from tbVenda v
                        inner join tbstatusvenda s on v.idStatusVenda = s.idStatusvenda
                        where v.idCliente like '$idCliente'";

            $aux = $db->prepare($sql);
            $aux->execute();
            $lista = $aux->fetchAll();

            foreach ($lista as $venda) {
                array_push($return, $venda);
            }
            echo json_encode(array("response" => $return));
        } else {
            echo json_encode(array("response" => ""));
        }
        break;
}
