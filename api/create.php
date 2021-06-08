<?php

require 'database-admin.php';

// Récupère les données de création postées dans l'admin
$postnewdata = file_get_contents("php://input");

if(isset($postnewdata) && !empty($postnewdata))
{
  // Extrait les données 
  $request = json_decode($postnewdata);

  $date = mysqli_real_escape_string($con, trim($request->date));
  $description = mysqli_real_escape_string($con, trim($request->description));
  $img = trim($request->img);
  $imageName = trim($request->imageName);

    // L'image est récupérée en Base 64 ainsi que son adresse
    // Celles ci sont traitées avant d'être encodéees dans la DB

  $imageLink = './assets/'.uniqid().substr($imageName, strrpos($imageName, '\\')+1);
  $splited = explode(',', $img);
  $binary = base64_decode($splited[1]);
  file_put_contents($imageLink, $binary);

  // Ajout des données dans la DB "data"
    
  $sql = "INSERT INTO `data`(`id`,`date`,`description`,`img`,`imageName`) VALUES (null,'{$date}','{$description}','{$imageLink}','{$imageName}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $data = [
      'date' => $date,
      'description' => $description,
      'img' => $imageLink,
      'imageName' => $imageName,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode($data);
  }else{
    echo mysqli_error($con);
    http_response_code(422);
  }
}