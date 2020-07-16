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
        $idEstabelecimento = filter_input(INPUT_GET, "idEstabelecimento");

        $db = new PDO(
            "mysql:host=localhost;
                dbname=bdeasycare2",
            "root",
            ""
        );

        if ($venda->find()->count() > 0) {
            $return = array();
            $sql = "SELECT v.idProduto, p.nomeProduto, p.descProduto, p.qtdMl, p.fotoProduto, p.precoProduto, c.nomeCategoria, f.nomeFabricante, p.idEstabelecimento, t.tipoDosagem from tbVenda v
                    inner join tbproduto p on v.idProduto = p.idProduto
                    inner join tbcategoria c on p.idCategoria = c.idCategoria
                    inner join tbfabricante f on p.idFabricante = f.idFabricante
                    inner join tbtipodosagem t on p.idTipoDosagem = t.idTipoDosagem
                    where v.idEstabelecimento like '$idEstabelecimento' and v.idProduto != 0 
                    group by v.idProduto
                    order by sum(qtdProduto) desc";

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
