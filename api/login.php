<?php

require 'database.php';

// Récupère les données postées sur la pahe de Login et les extrait

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Si les données sont bien reçues, les vérifie, les compare avec celles de la DB "Users" et renvoie la confirmation nécessaire à la connexion si celles-ci sont justes

if(isset($postdata) && !empty($postdata)){
    $password = mysqli_real_escape_string($mysqli, trim($request->password));
    $email = mysqli_real_escape_string($mysqli, trim($request->username));
    $sql = "SELECT * FROM users where email='$email' and password='$password'";
        if($result = mysqli_query($mysqli,$sql)){
            $rows = array();
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        echo json_encode($rows);
    }else{
         http_response_code(404);
        }
}