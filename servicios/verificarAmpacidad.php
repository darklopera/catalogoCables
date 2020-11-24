<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

include "config.php";
include "utils.php";

$dbConn =  connect($db);

$postdata = file_get_contents("php://input");
$datosEntrada = json_decode($postdata,true);

//datos de entrada

$ampacidad = $datosEntrada["ampacidad"];
// echo $ampacidad;
//     echo "Amapcidad arriba";

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    // $input = is_float($ampacidad)
    // echo $ampacidad;
    // echo "Amapcidad arriba";
    
    //Se identifica la ampacidad corregida con la que se debe trabajar
    if($ampacidad<40)
    {
        header("HTTP/1.1 200 OK");
        echo "1.26";
        exit(); 
    }
    else {
        header("HTTP/1.1 200 OK");
        echo "2.5";
        exit();
    }           
}

?>