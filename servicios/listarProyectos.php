<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

include "config.php";
include "utils.php";

$dbConn =  connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $input = $_POST;
    $sql="SELECT * 
    FROM proyecto
    WHERE (idEstado=1)";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result=$statement->fetchAll();

    //Lista si existes proyectos activos.
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
        echo "0";
        $array["codigo"]="0";
        $array["respuesta"]="No se encontraron proyectos activos";
        echo json_encode($array);
        exit();
    }            
}

?>