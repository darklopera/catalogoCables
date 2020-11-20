<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $input = $_POST;
    $sql="SELECT * 
    FROM material
    WHERE (idEstado=1)";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result=$statement->fetchAll();

    //Lista si existes materiales activos.
    if(!empty($result))
    {
        header("HTTP/1.1 200 OK");
        $array["codigo"]="100";
        $array["respuesta"]=$result;
        echo json_encode($array);
        exit();
    }
    else {
        header("HTTP/1.1 400 ERROR");
        echo "0";
        $array["codigo"]="0";
        $array["respuesta"]="No se encontraron materiales activos";
        echo json_encode($array);
        exit();
    }            
}

?>