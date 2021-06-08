<?php
require 'database-admin.php';

 // Récupère les données postées sur la page d'admin
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extraction des données 
  $request = json_decode($postdata);

  // Validation
  if(trim($request->date) === '' || trim($request->description) === '' )
  {
    return http_response_code(400);  // Les informations doivent être récupérées avant d'être mises à jour
  }

  $id    = mysqli_real_escape_string($con, (int)$request->id);
  $date = mysqli_real_escape_string($con, trim($request->date));
  $description = mysqli_real_escape_string($con, trim($request->description));
  $img = trim($request->img);
  $imageName = trim($request->imageName);
    
        // Vérification du format de l'image postée
        
    $infosfichier = pathinfo($imageName);
    $extension_upload = $infosfichier['extension'];
    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
    
if (in_array ($extension_upload, $extensions_autorisees)){   
    
    // L'image est récupérée en Base 64 ainsi que son adresse
    // Celles ci sont traitées avant d'être encodéees dans la DB
    
  $imageLink = '../portfolio/assets/'.uniqid().substr($imageName, strrpos($imageName, '\\')+1);
  $splited = explode(',', $img);
  $binary = base64_decode($splited[1]);
  file_put_contents($imageLink, $binary);
    
  // Mise à jour des données sur la DB
  $sql = "UPDATE `data` SET `description`='$description',`date`='$date', `img`='$imageLink', `imageName`='$imageName' WHERE `id` = '{$id}' LIMIT 1";

  if(mysqli_query($con, $sql))
  {
    http_response_code(204);
  }
  else
  {
    echo mysqli_error($con);
    return http_response_code(422);
  }  
}
}
