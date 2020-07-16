<?php

namespace Source\Controllers;

use PDO;
use Source\Models\Validations;
use Source\Models\Medicament;

require "../../../vendor/autoload.php";
require "../../config.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        header("HTTP/1.1 200 OK");
        $medicaments = new Medicament();
        $idEstabelecimento = filter_input(INPUT_GET, "idEstabelecimento");
        $idLaboratorio = filter_input(INPUT_GET, "idLaboratorio");
        $idTipoDosagem = filter_input(INPUT_GET, "idTipoDosagem");
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
            if ($medicaments->find()->count() > 0) {
                $return = array();
                $sql = "SELECT idMedicamento, descMed, precoMed, m.idEstabelecimento, descDosagem, tp.tipoDosagem, composicaoMed, l.nomeLaboratorio, c.nomeCategoria, e.nomeEstabelecimento, t.descTarja from tbmedicamento m
                    inner join tbtipodosagem tp on m.idtipodosagem = tp.idtipodosagem
                    inner join tblaboratorio l on m.idLaboratorio = l.idLaboratorio
                    inner join tbcategoriamed c on m.idCategoriaMed = c.idCategoriaMed
                    inner join tbestabelecimento e on m.idEstabelecimento = e.idEstabelecimento
                    inner join tbtarja t on m.idTarja = t.idTarja
                    where m.idEstabelecimento='$idEstabelecimento'";

                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();

                foreach ($lista as $medicaments) {
                    array_push($return, $medicaments);
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Nenhum medicamento encontrado"));
            }
        } else
            if ($nomeCategoria != null && $idEstabelecimento != null) {
            if ($medicaments->find()->count() > 0) {
                $return = array();
                $sql = "SELECT idMedicamento, descMed, precoMed, m.idEstabelecimento, descDosagem, tp.tipoDosagem, composicaoMed, l.nomeLaboratorio, c.nomeCategoria, e.nomeEstabelecimento, t.descTarja from tbmedicamento m
                    inner join tbtipodosagem tp on m.idtipodosagem = tp.idtipodosagem
                    inner join tblaboratorio l on m.idLaboratorio = l.idLaboratorio
                    inner join tbcategoriamed c on m.idCategoriaMed = c.idCategoriaMed
                    inner join tbestabelecimento e on m.idEstabelecimento = e.idEstabelecimento
                    inner join tbtarja t on m.idTarja = t.idTarja
                    where c.nomeCategoria ='$nomeCategoria' and m.idEstabelecimento='$idEstabelecimento'";

                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();

                foreach ($lista as $medicaments) {
                    array_push($return, $medicaments);
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Nenhum medicamento encontrado"));
            }
        } else
            if ($promocoesGeral == true) {
            if ($medicaments->find()->count() > 0) {
                $return = array();
                $sql = "SELECT idMedicamento, descMed, precoMed, m.idEstabelecimento, descDosagem, tp.tipoDosagem, composicaoMed, l.nomeLaboratorio, c.nomeCategoria, e.nomeEstabelecimento, t.descTarja from tbmedicamento m
                    inner join tbtipodosagem tp on m.idtipodosagem = tp.idtipodosagem
                    inner join tblaboratorio l on m.idLaboratorio = l.idLaboratorio
                    inner join tbcategoriamed c on m.idCategoriaMed = c.idCategoriaMed
                    inner join tbestabelecimento e on m.idEstabelecimento = e.idEstabelecimento
                    inner join tbtarja t on m.idTarja = t.idTarja
                    where statusPromocional = 1";

                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();

                foreach ($lista as $medicaments) {
                    array_push($return, $medicaments);
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => ""));
            }
        } else 
            if ($promocoesEstabelecimento && $idEstabelecimento != null) {
            if ($medicaments->find()->count() > 0) {
                $return = array();
                $sql = "SELECT idMedicamento, descMed, precoMed, m.idEstabelecimento, descDosagem, tp.tipoDosagem, composicaoMed, l.nomeLaboratorio, c.nomeCategoria, e.nomeEstabelecimento, t.descTarja from tbmedicamento m
                    inner join tbtipodosagem tp on m.idtipodosagem = tp.idtipodosagem
                    inner join tblaboratorio l on m.idLaboratorio = l.idLaboratorio
                    inner join tbcategoriamed c on m.idCategoriaMed = c.idCategoriaMed
                    inner join tbestabelecimento e on m.idEstabelecimento = e.idEstabelecimento
                    inner join tbtarja t on m.idTarja = t.idTarja
                    where statusPromocional = 1 and m.idEstabelecimento='$idEstabelecimento'";

                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();

                foreach ($lista as $medicaments) {
                    array_push($return, $medicaments);
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => ""));
            }
        } else {
            if ($medicaments->find()->count() > 0) {
                $return = array();
                $sql = "SELECT idMedicamento, descMed, precoMed, m.idEstabelecimento, descDosagem, tp.tipoDosagem, composicaoMed, l.nomeLaboratorio, c.nomeCategoria, e.nomeEstabelecimento, t.descTarja from tbmedicamento m
                inner join tbtipodosagem tp on m.idtipodosagem = tp.idtipodosagem
                inner join tblaboratorio l on m.idLaboratorio = l.idLaboratorio
                inner join tbcategoriamed c on m.idCategoriaMed = c.idCategoriaMed
                inner join tbestabelecimento e on m.idEstabelecimento = e.idEstabelecimento
                inner join tbtarja t on m.idTarja = t.idTarja";

                $aux = $db->prepare($sql);
                $aux->execute();
                $lista = $aux->fetchAll();

                foreach ($lista as $medicaments) {
                    array_push($return, $medicaments);
                }
                echo json_encode(array("response" => $return));
            } else {
                echo json_encode(array("response" => "Nenhum medicamento encontrado"));
            }
        }
        break;
    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("response" => "Método não previsto na API"));
        break;
}
