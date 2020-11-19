<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $input = $_POST;
//     $sql = "SELECT id, nombre, correo, idEstado FROM usuario 
//             WHERE (usuario=:usuario) AND (contrasena=:contrasena)";

$sql="SELECT us.id, us.nombre, us.correo, us.idEstado, es.nombre as nombreEstado 
FROM usuario as us
INNER JOIN estado as es
ON us.idEstado=es.id
WHERE (usuario=:usuario) AND (contrasena=:contrasena)";


// SELECT column_name(s)
// FROM table1
// INNER JOIN table2
// ON table1.column_name = table2.column_name;

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result=$statement->fetchAll();

    if(!empty($result))
    {
            if($result[0]['idEstado']==1)
            {
                    header("HTTP/1.1 200 OK");
                    echo json_encode($result);
                    exit();
                }
                else {
                        header("HTTP/1.1 200 OK");
                        echo "El usuario ingresado no se encuentra activo";
                        exit();
                }
        }

        else {
                header("HTTP/1.1 400 ERROR");
                echo "Favor verificar la informacion ingresada";
                exit();
        }
                
}

?>

