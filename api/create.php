<?php

require 'database-admin.php';

// Récupère les données de création postées dans l'admin
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extrait les données 
  $request = json_decode($postdata);


  // Validation des données
  if(trim($request->date) === '' || trim($request->presentation) === '' || trim($request->img) === '' )
  {
    return http_response_code(400);
  }

  $date = mysqli_real_escape_string($con, trim($request->date));
  $presentation = mysqli_real_escape_string($con, trim($request->presentation));
  $img = mysqli_real_escape_string($con, trim($request->img));


  // Ajout des données dans la DB "data"
    
  $sql = "INSERT INTO `data`(`id`,`date`,`presentation`,`img`) VALUES (null,'{$date}','{$presentation}','{$img}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $data = [
      'date' => $date,
      'presentation' => $presentation,
      'img' => $img,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode($data);
  }
  else
  {
    http_response_code(422);
  }
}

/*
Travail en cours pour récupérer l'image

$imageLink = './uploads/'.uniqid().substr($contactForm['imageName'], strrpos($contactForm['imageName'], '\\')+1);
    $splited = explode(',', $contactForm['image']);
    $binary = base64_decode($splited[1]);
    file_put_contents($imageLink, $binary);
*/