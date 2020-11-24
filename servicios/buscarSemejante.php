<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

include "config.php";
include "utils.php";

$dbConn =  connect($db);

$postdata = file_get_contents("php://input");
$datosEntrada = json_decode($postdata,true);

//datos de entrada

// echo json_encode($datosEntrada);

$ampacidad = $datosEntrada["ampacidad"];
$material = $datosEntrada["material"];
// $idMaterial = $datosEntrada["idMaterial"];

 // echo json_decode($datosEntrada);
 // echo "ampacidad arriva";

// echo " Lopera y alejo viendo";

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $input = $_POST;

    $sql="SELECT ca.*,  ma.nombre as nombreMaterial
    FROM catalogo as ca
    INNER JOIN material as ma
    ON ca.idMaterial=ma.id
    WHERE (ca.ampacidad='".$ampacidad."') AND (ma.nombre='".$material."')";

    // echo $sql;
//WHERE (ca.ampacidad='1.26') AND (ca.idMaterial='1')";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result=$statement->fetchAll();
    // echo json_encode($result);

    //Verifica que exista la combinación cables para los parámetros ingresados
    if(!empty($result))
    {
            
        header("HTTP/1.1 200 OK");
        $array["codigo"]="100";
        $array["respuesta"]=$result;
        echo json_encode($array);
        exit();
    
        }

        else {
                header("HTTP/1.1 200 OK");
                $array["codigo"]="0";
                $array["respuesta"]="No se encontró una combinación de cable para los datos ingresados";
                echo json_encode($array);
                exit();
        }
                
}

?>
