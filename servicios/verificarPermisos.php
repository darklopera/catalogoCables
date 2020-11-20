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
        $array["codigo"]="100";
        $array["respuesta"]=1;
        echo json_encode($array);
        exit();
    }
    else {
        header("HTTP/1.1 400 ERROR");
        echo "0";
        $array["codigo"]="0";
        $array["respuesta"]=0;
        echo json_encode($array);
        exit();
    }            
}

?>