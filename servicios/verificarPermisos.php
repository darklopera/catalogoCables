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
$idUsuario = $datosEntrada["idUsuario"];
$proyecto = $datosEntrada["proyecto"];

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $input = $_POST;
    $sql="SELECT * 
    FROM proyecto_x_usuario as pxu
    INNER JOIN proyecto as pro
    WHERE (pxu.idUsuario='".$idUsuario."') AND (pro.nombre='".$proyecto."'AND pxu.idProyecto= pro.idTipoProyecto)";

    // $sql="SELECT ca.*,  ma.nombre as nombreMaterial
    // FROM catalogo as ca
    // INNER JOIN material as ma
    // ON ca.idMaterial=ma.id
    // WHERE (ca.ampacidad='".$ampacidad."') AND (ca.idmaterial='".$idmaterial."')";

    //echo $sql;

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result=$statement->fetchAll();

    //Verifica si el usuario y el proyecto estan relacionados
    if(!empty($result))
    {
        header("HTTP/1.1 200 OK");
        $array["codigo"]="100";
        $array["respuesta"]=1;
        echo json_encode($array);
        exit();
    }
    else {
        header("HTTP/1.1 200 OK");
        // echo "0";
        $array["codigo"]="0";
        $array["respuesta"]="Ustes no tiene permisos para solicitar Cable pare este proyecto.";
        echo json_encode($array);
        exit();
    }            
}

?>