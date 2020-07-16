<?php

namespace Source\Controllers;

use PDO;
use Source\Models\Validations;
use Source\Models\Venda;

require "../../../vendor/autoload.php";
require "../../config.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        header("HTTP/1.1 200 OK");
        $venda = new Venda();
        $idCliente = filter_input(INPUT_GET, "idCliente");

        $db = new PDO(
            "mysql:host=localhost;
                dbname=bdeasycare2",
            "root",
            ""
        );

        if ($venda->find()->count() > 0) {
            $return = array();
            $sql = "SELECT DISTINCT idCliente, m.idMedicamento, m.composicaoMed, m.descMed, m.descDosagem, tp.tipoDosagem, m.precoMed, l.nomeLaboratorio, c.nomeCategoria, e.idEstabelecimento, t.descTarja from tbVenda v
                    inner join tbmedicamento m on v.idMedicamento = m.idmedicamento
                    inner join tbtipodosagem tp on m.idtipodosagem = tp.idtipodosagem
                    inner join tblaboratorio l on m.idLaboratorio = l.idLaboratorio
                    inner join tbcategoriamed c on m.idCategoriaMed = c.idCategoriaMed
                    inner join tbestabelecimento e on m.idEstabelecimento = e.idEstabelecimento
                    inner join tbtarja t on m.idTarja = t.idTarja
                    where v.idCliente='$idCliente'";

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

    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("response" => "Método não previsto na API"));
        break;
}
