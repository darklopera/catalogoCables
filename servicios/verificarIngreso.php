<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $input = $_POST;

$sql="SELECT us.id, us.nombre, us.correo, us.idEstado, es.nombre as nombreEstado 
FROM usuario as us
INNER JOIN estado as es
ON us.idEstado=es.id
WHERE (us.usuario=:usuario) AND (us.contrasena=:contrasena)";


    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result=$statement->fetchAll();

    //Verifica que el usuario exite en la base de datos
    if(!empty($result))
    {
            //Verifica el estado activo del usuario
            if($result[0]['idEstado']==1)
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
                        $array["respuesta"]= "El usuario ingresado no se encuentra activo";
                        echo json_encode($array);
                        exit();
                }
        }
        else {
                header("HTTP/1.1 400 ERROR");
                $array["codigo"]="0";
                $array["respuesta"]= "Favor verificar la informacion ingresada";
                echo json_encode($array);
                exit();
        }
                
}

?>

