<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    $input = $_POST["ampacidad"];
    
    //Se identifica la ampacidad corregida con la que se debe trabajar
    if($input<40)
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