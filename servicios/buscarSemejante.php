<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $input = $_POST;

    $sql="SELECT ca.*,  ma.nombre as nombreMaterial
    FROM catalogo as ca
    INNER JOIN material as ma
    ON ca.idmaterial=ma.id
    WHERE (ca.ampacidad=:ampacidad) AND (ca.idmaterial=:idmaterial)";


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
        echo json_encode($result);
        exit();
    
        }

        else {
                header("HTTP/1.1 400 ERROR");
                echo "No se encontró una combinación de cable para los datos ingresados";
                exit();
        }
                
}

?>
