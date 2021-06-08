<?php

require 'database.php';

// Récupère les données postées sur la page "Register"

$postdata = file_get_contents("php://input");
    
// S'il y a bien des données, elles sont extraites

if(isset($postdata) && !empty($postdata)){
$request = json_decode($postdata);
    
$name = trim($request->name);
$password = mysqli_real_escape_string($mysqli, trim($request->password)); 
$email = mysqli_real_escape_string($mysqli, trim($request->email));   

// Une regex vérifie que l'adresse e-mail soit valide, si elle ne l'est pas, elle renvoie une erreur 400
       
 $regex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
       
 if(preg_match($regex, $email)){
     
// Les données sont ajoutées à la DB Users
  
$sql = "INSERT INTO users(name,password,email) VALUES ('$name','$password','$email')";

    if ($mysqli->query($sql) === TRUE) {
    $authdata = [
    'name' => $name,
    'password' => $password,
    'email' => $email,
    'Id' => mysqli_insert_id($mysqli)
    ];
    echo json_encode($authdata);
    }
        }else{
              echo "L'adresse E-mail n'est pas valide." ;
              http_response_code(400);
             }
}
