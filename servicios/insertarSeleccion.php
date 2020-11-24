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
$nombre = $datosEntrada["nombre"];
$codigoCatalogo = $datosEntrada["codigoCatalogo"];
$idUsuario = $datosEntrada["idUsuario"];
$idProyecto = $datosEntrada["idProyecto"];
$instalacion = $datosEntrada["instalacion"];


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{       
    $input = $_POST;
    //$date= date_format($date,"Y/m/d H:i:s");
    $sql = "INSERT INTO seleccion
          (nombre, codigoCatalogo, idUsuario, idProyecto, fechainsercion, instalacion)
          VALUES
          ('".$nombre."', '".$codigoCatalogo."', '".$idUsuario."','".$idProyecto."', NOW(),'".$instalacion."')";

    //echo $sql;
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $postId = $dbConn->lastInsertId();

    //Verifica si se puedo insertar la seleccion con exito
    if(!empty($postId))
    {
        header("HTTP/1.1 200 OK");
        $array["codigo"]="100";
        $array["respuesta"]=$input;
        echo json_encode($array);
        exit();
    }
    else {
        header("HTTP/1.1 200 OK");
        $array["codigo"]="0";
        $array["respuesta"]="No se pudo insertar la seleccion";
        echo json_encode($array);
        exit();
    }   

}

?>