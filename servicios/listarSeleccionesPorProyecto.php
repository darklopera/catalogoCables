<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $input = $_POST;
    
    $sql="SELECT  sel.id, sel.nombre, cat.corrienteCorregida, cat.tensionCorregida, 
    cat.ampacidad, cat.corrienteCorregida, usu.nombre, pro.nombre, sel.fechaInsercion
    FROM seleccion as sel
    INNER JOIN catalogo as cat
    ON sel.codigoCatalogo = cat.codigo
    INNER JOIN usuario as usu
    ON sel.idUsuario = usu.id
    INNER JOIN proyecto as pro
    ON sel.idProyecto = pro.id
    WHERE sel.idUsuario =:idUsuario";

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
        header("HTTP/1.1 400 ERROR");
        $array["codigo"]="0";
        $array["respuesta"]="No se encontraron selecciones para el usuario";
        echo json_encode($array);
        exit();
    }            
}

?>