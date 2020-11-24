<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

include "config.php";
include "utils.php";

$dbConn =  connect($db);

$postdata = file_get_contents("php://input");
$datosEntrada = json_decode($postdata,true);

$idUsuario = $datosEntrada["idUsuario"];

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $input = $_POST;
    
    $sql="SELECT  sel.nombre AS nombreSeleccion, sel.`corriente`, cat.`tensionCorregida`, cat.`ampacidad`, cat.`corrienteCorregida`, usu.`nombre` AS nombreUsuario,
    pro.`nombre` AS nombreProyecto, sel.`fechaInsercion`
    FROM seleccion AS sel
    INNER JOIN catalogo AS cat
    ON sel.codigoCatalogo = cat.codigo
    INNER JOIN usuario AS usu
    ON sel.idUsuario = usu.id
    INNER JOIN proyecto AS pro
    ON sel.idProyecto = pro.id
    WHERE sel.idUsuario ='".$idUsuario."'";



    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result=$statement->fetchAll();
    

    //Verifica si existen selecciones creadas para el usuario
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
        $array["respuesta"]="No se encontraron selecciones para el usuario";
        echo json_encode($array);
        exit();
    }            
}

?>