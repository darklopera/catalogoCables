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
$idMaterial = $datosEntrada["idmaterial"];


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    // $ampacidad = $_POST["ampacidad"];
    // $idMaterial = $_POST["idMaterial"];

    //datos a enviar
    $data = array("ampacidad" => $ampacidad);
    //url contra la que atacamos
    $ch = curl_init("http://localhost/catalogoCables/servicios/verificarAmpacidad.php");
    //a true, obtendremos una respuesta de la url, en otro caso, 
    //true si es correcto, false si no lo es
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //establecemos el verbo http que queremos utilizar para la petición
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //enviamos el array data
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
    //obtenemos la respuesta
    $response = curl_exec($ch);
    // Se cierra el recurso CURL y se liberan los recursos del sistema
    // curl_close($ch);

    echo json_encode($response);
    echo "Lopera esta aqui";

    $data2 = array("ampacidad"=>$response, "idmaterial" => $idMaterial);
     echo json_encode($data2);
    $ch = curl_init("http://localhost/catalogoCables/servicios/buscarSemejante.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data2));
    $response2 = curl_exec($ch);
    curl_close($ch);

     // echo ($response2);
    

    //Verifica si existe un cable para los parametros ingresados
    if(!empty($response2))
    {
        header("HTTP/1.1 200 OK");
        $array["codigo"]="100";
        $array["respuesta"]=$response2;
        echo json_encode($array);
        exit();
    }
    else {
        header("HTTP/1.1 200 OK");
        $array["codigo"]="0";
        $array["respuesta"]="No se encontro un cable para los parametros ingresados";
        echo json_encode($array);
        exit();
    }   

}

?>