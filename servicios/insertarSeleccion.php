<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{       
    $input = $_POST;
    //$date= date_format($date,"Y/m/d H:i:s");
    $sql = "INSERT INTO seleccion
          (nombre, codigoCatalogo, idUsuario, idProyecto, fechainsercion, instalacion)
          VALUES
          (:nombre, :codigoCatalogo, :idUsuario, :idProyecto, NOW(), :instalacion)";

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
        header("HTTP/1.1 400 ERROR");
        $array["codigo"]="0";
        $array["respuesta"]="No se pudo insertar la seleccion";
        echo json_encode($array);
        exit();
    }   

}

?>