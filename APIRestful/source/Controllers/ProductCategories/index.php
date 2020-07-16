<?php

namespace Source\Controllers;

use Source\Models\Validations;
use PDO;
use Source\Models\ProductCategories;

require "../../../vendor/autoload.php";
require "../../config.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        header("HTTP/1.1 200 OK");
        $prod = new ProductCategories();
        $idEstabelecimento = filter_input(INPUT_GET, "idEstabelecimento");
        $db = new PDO(
            "mysql:host=localhost;
                dbname=bdeasycare2",
            "root",
            ""
        );
        if ($prod->find()->count() > 0) {
            $return = array();
            $sql = "SELECT DISTINCT c.nomeCategoria from tbproduto p
                inner join tbcategoria c on p.idCategoria = c.idCategoria
                where p.idEstabelecimento='$idEstabelecimento'";
            $aux = $db->prepare($sql);
            $aux->execute();
            $lista = $aux->fetchAll();

            foreach ($lista as $prod) {
                array_push($return, $prod);
            }
            echo json_encode(array("response" => $return));
        } else {
            echo json_encode(array("response" => "Nenhuma categoria encontrada"));
        }
        break;

    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("response" => "Método não previsto na API"));
        break;
}
