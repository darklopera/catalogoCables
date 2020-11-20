<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $ampacidad = $_POST["ampacidad"];
    $idMaterial = $_POST["idMaterial"];

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
    curl_close($ch);

    $data2 = array("ampacidad"=>$response, "idmaterial" => $idMaterial);
    $ch = curl_init("http://localhost/catalogoCables/servicios/buscarSemejante.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data2));
    $response2 = curl_exec($ch);
    curl_close($ch);

    //Busca si existe una combinacion de cable para los parametros ingresados
    // header("HTTP/1.1 200 OK");
    // echo ($response2);
    // exit();

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
        header("HTTP/1.1 400 ERROR");
        $array["codigo"]="0";
        $array["respuesta"]="No se encontro un cable para los parametros ingresados";
        echo json_encode($array);
        exit();
    }   

}

?>