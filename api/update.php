<?php
require 'database-admin.php';

 // Récupère les données postées sur la page d'admin
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extraction des données 
  $request = json_decode($postdata);

  // Validation
  if(trim($request->date) === '' || trim($request->description) === '' || trim($request->img) === '' )
  {
    return http_response_code(400);  // Les informations doivent être récupérées avant d'être mises à jour
  }

  $id    = mysqli_real_escape_string($con, (int)$request->id);
  $date = mysqli_real_escape_string($con, trim($request->date));
  $description = mysqli_real_escape_string($con, trim($request->description));
  $img = mysqli_real_escape_string($con, trim($request->img));

  // Mise à jour des données sur la DB
  $sql = "UPDATE `data` SET `description`='$description',`date`='$date', `img`='$img' WHERE `id` = '{$id}' LIMIT 1";

  if(mysqli_query($con, $sql))
  {
    http_response_code(204);
  }
  else
  {
    return http_response_code(422);
  }  
}