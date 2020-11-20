<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $input = $_POST;
    $sql="SELECT * 
    FROM proyecto_x_usuario
    WHERE (idUsuario=:idUsuario) AND (idProyecto=:idProyecto)";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result=$statement->fetchAll();

    //Verifica si el usuario y el proyecto estan relacionados
    if(!empty($result))
    {
        header("HTTP/1.1 200 OK");
        echo "1";
        exit();
    }
    else {
        header("HTTP/1.1 200 OK");
        echo "0";
        exit();
    }            
}

?>