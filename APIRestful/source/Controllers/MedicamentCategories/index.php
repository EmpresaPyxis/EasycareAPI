<?php

namespace Source\Controllers;

use Source\Models\Validations;
use Source\Models\MedicamentCategories;
use PDO;

require "../../../vendor/autoload.php";
require "../../config.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        header("HTTP/1.1 200 OK");
        $med = new MedicamentCategories();
        $idEstabelecimento = filter_input(INPUT_GET, "idEstabelecimento");

        $db = new PDO(
            "mysql:host=localhost;
                dbname=bdeasycare2",
            "root",
            ""
        );
        if ($idEstabelecimento != "") {
            if ($med->find()->count() > 0) {
                $return = array();
                $sql = "SELECT DISTINCT c.nomeCategoria from tbmedicamento m
                    inner join tbcategoriamed c on m.idCategoriaMed = c.idCategoriaMed
                    where m.idEstabelecimento='$idEstabelecimento'";
                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();



                foreach ($lista as $med) {
                    array_push($return, $med);
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Nenhum login de usuário encontrado"));
            }

            //var_dump($return);
        }


        break;

    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("response" => "Método não previsto na API"));
        break;
}

    /*
    SELECT DISTINCT c.nomeCategoria from tbmedicamento m
    inner join tbcategoriamed c on m.idCategoriaMed = c.idCategoriaMed
    where m.idEstabelecimento= '$idEstabelecimento'
    */
