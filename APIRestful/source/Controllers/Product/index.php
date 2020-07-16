<?php

namespace Source\Controllers;

use PDO;
use Source\Models\Validations;
use Source\Models\Product;

require "../../../vendor/autoload.php";
require "../../config.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        header("HTTP/1.1 200 OK");
        $products = new Product();
        $idEstabelecimento = filter_input(INPUT_GET, "idEstabelecimento");
        $nomeCategoria = filter_input(INPUT_GET, "nomeCategoria");
        $promocoesGeral = filter_input(INPUT_GET, "promocoesGeral");
        $promocoesEstabelecimento = filter_input(INPUT_GET, "promocoesEstabelecimento");
        $todos = filter_input(INPUT_GET, "todos");

        $db = new PDO(
            "mysql:host=localhost;
                dbname=bdeasycare2",
            "root",
            ""
        );

        if ($idEstabelecimento != null && $todos == true) {
            if ($products->find()->count() > 0) {
                $return = array();
                $sql = "SELECT idProduto, nomeProduto, descProduto, qtdMl, fotoProduto, precoProduto, c.nomeCategoria, f.nomeFabricante, p.idEstabelecimento, t.tipoDosagem from tbproduto p
                    inner join tbcategoria c on p.idCategoria = c.idCategoria
                    inner join tbfabricante f on p.idFabricante = f.idFabricante
                    inner join tbtipodosagem t on p.idTipoDosagem = t.idTipoDosagem
                    where p.idEstabelecimento='$idEstabelecimento'";

                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();

                foreach ($lista as $products) {
                    array_push($return, $products);
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Nenhum produto encontrado"));
            }
        } else 
            if ($nomeCategoria != null && $idEstabelecimento != null) {
            if ($products->find()->count() > 0) {
                $return = array();
                $sql = "SELECT idProduto, nomeProduto, descProduto, qtdMl, fotoProduto, precoProduto, c.nomeCategoria, f.nomeFabricante, p.idEstabelecimento, t.tipoDosagem from tbproduto p
                    inner join tbcategoria c on p.idCategoria = c.idCategoria
                    inner join tbfabricante f on p.idFabricante = f.idFabricante
                    inner join tbtipodosagem t on p.idTipoDosagem = t.idTipoDosagem
                    where c.nomeCategoria ='$nomeCategoria' and p.idEstabelecimento='$idEstabelecimento'";

                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();

                foreach ($lista as $products) {
                    array_push($return, $products);
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Nenhum produto encontrado"));
            }
        } else 
            if ($promocoesGeral == true) {
            if ($products->find()->count() > 0) {
                $return = array();
                $sql = "SELECT idProduto, nomeProduto, descProduto, qtdMl, fotoProduto, precoProduto, c.nomeCategoria, f.nomeFabricante, p.idEstabelecimento, t.tipoDosagem, statusPromocional, porcentagemDesconto from tbproduto p
                    inner join tbcategoria c on p.idCategoria = c.idCategoria
                    inner join tbfabricante f on p.idFabricante = f.idFabricante
                    inner join tbtipodosagem t on p.idTipoDosagem = t.idTipoDosagem
                    where statusPromocional = 1";

                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();

                foreach ($lista as $products) {
                    array_push($return, $products);
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => ""));
            }
        } else
            if ($promocoesEstabelecimento == true && $idEstabelecimento != null) {
            if ($products->find()->count() > 0) {
                $return = array();
                $sql = "SELECT idProduto, nomeProduto, descProduto, qtdMl, fotoProduto, precoProduto, c.nomeCategoria, f.nomeFabricante, p.idEstabelecimento, t.tipoDosagem, statusPromocional, porcentagemDesconto from tbproduto p
                    inner join tbcategoria c on p.idCategoria = c.idCategoria
                    inner join tbfabricante f on p.idFabricante = f.idFabricante
                    inner join tbtipodosagem t on p.idTipoDosagem = t.idTipoDosagem
                    where statusPromocional = 1 and p.idEstabelecimento='$idEstabelecimento'";

                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();

                foreach ($lista as $products) {
                    array_push($return, $products);
                }
                echo json_encode(array("response" => $return));
            }
        } else {
            if ($products->find()->count() > 0) {
                $return = array();
                $sql = "SELECT idProduto, nomeProduto, descProduto, qtdMl, fotoProduto, precoProduto, c.nomeCategoria, f.nomeFabricante, p.idEstabelecimento, t.tipoDosagem from tbproduto p
                inner join tbcategoria c on p.idCategoria = c.idCategoria
                inner join tbfabricante f on p.idFabricante = f.idFabricante
                inner join tbtipodosagem t on p.idTipoDosagem = t.idTipoDosagem";
                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();

                foreach ($lista as $products) {
                    array_push($return, $products);
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Nenhum produto encontrado"));
            }
        }
        break;
    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("response" => "Método não previsto na API"));
        break;
}
