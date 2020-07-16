<?php

  namespace Source\Controllers;
  use PDO;
  use Source\Models\Validation;
  use Source\Models\Establishment;

  require "../../../vendor/autoload.php";
  require "../../config.php";

  switch($_SERVER['REQUEST_METHOD']){
        case "GET":
            header("HTTP/1.1 200 OK");
            $establishment = new Establishment();

            $nomeEstabelecimento = filter_input(INPUT_GET, "nomeEstabelecimento");

            $db = new PDO(
                "mysql:host=localhost;
                dbname=bdeasycare2", 
                "root", 
                ""
            );

            if($nomeEstabelecimento != null){
                if($establishment->find()->count()>0){
                    $return = array();
                    //$sql = "SELECT * FROM tbestabelecimento where nomeEstabelecimento='$nomeEstabelecimento'";
                    $sql = "SELECT nomeEstabelecimento, cnpjEstabelecimento, logEstabelecimento, numLogEstabelecimento, cepLogEstabelecimento, bairroLogEstabelecimento, ufLogEstabelecimento FROM tbestabelecimento
                            WHERE nomeEstabelecimento like '$nomeEstabelecimento%'";
                    
                    $aux = $db->prepare($sql);
                    $aux->execute();
                    $lista = $aux->fetchAll();

                    foreach($lista as $establishment) {
                        array_push($return, $establishment);
                    }
                    echo json_encode(array("response" => $return));
                }else {
                    echo json_encode(array("response" => "Nenhum produto encontrado"));
                }
            }
        break;
        default:
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("response" => "Método não previsto na API"));
        break;
    }
