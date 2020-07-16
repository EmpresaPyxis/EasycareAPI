<?php

    namespace Source\Controllers;
    use PDO;
    use Source\Models\Validation;
    use Source\Models\Medicament;

    require "../../../vendor/autoload.php";
    require "../../config.php";

    switch($_SERVER['REQUEST_METHOD']){
        case "GET":
            header("HTTP/1.1 200 OK");

            $medicament = new Medicament();
            $nameMedicament = filter_input(INPUT_GET, "nomeMedicamento");
            $idEstabelecimento = filter_input(INPUT_GET, "idEstabelecimento");

            $db = new PDO(
                "mysql:host=localhost;
                dbname=bdeasycare2", 
                "root", 
                ""
            );
            
            if($nameMedicament != null && $idEstabelecimento != null){
                if($medicament->find()->count()>0){
                    $return = array();
                    $sql = "SELECT m.idMedicamento, descMed, precoMed, m.idEstabelecimento, descDosagem, tp.tipoDosagem, composicaoMed, l.nomeLaboratorio, c.nomeCategoria, e.nomeEstabelecimento, t.descTarja from tbmedicamento m
                                inner join tbtipodosagem tp on m.idtipodosagem = tp.idtipodosagem
                                inner join tblaboratorio l on m.idLaboratorio = l.idLaboratorio
                                inner join tbcategoriamed c on m.idCategoriaMed = c.idCategoriaMed
                                inner join tbestabelecimento e on m.idEstabelecimento = e.idEstabelecimento
                                inner join tbtarja t on m.idTarja = t.idTarja
                                WHERE descMed like '$nameMedicament%' and m.idEstabelecimento = '$idEstabelecimento'";
                    
                    $aux = $db->prepare($sql);
                    $aux->execute();
                    $lista = $aux->fetchAll();   

                    foreach($lista as $medicaments){
                        array_push($return, $medicaments);
                    }             
                    echo json_encode(array("response" => $return));
                }else{
                    echo json_encode(array("response" => "Nenhum medicamento encontrado"));
                }
            }
        
        break;
        default:
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Método não previsto na API"));
        break;   
    }
