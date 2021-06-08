<?php


require 'database-admin.php';

// Récupère les données de la page de contact
$postcontact = file_get_contents("php://input");

if(isset($postcontact) && !empty($postcontact))
{

// Extrait les données
$request = json_decode($postcontact);

// Validation de celles-ci
  if(trim($request->name) === '' || ($request->email) === '' || ($request->messages) === '')
  {
    return http_response_code(400);
  }

  $name = mysqli_real_escape_string($con, trim($request->name));
  $email = mysqli_real_escape_string($con, trim($request->email));
  $message = mysqli_real_escape_string($con, trim($request->messages));   
    
// Regex qui vérifie l'adresse e-mail, afin de vérifier qu'elle soit bien valide, sinon cela renvoie une erreur 400    
    
     $regex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
       
if (preg_match($regex, $email)){  
    
  // Les informations entrées par l'utilisateur dans le formulaire son ajoutées à la Db "message"
    
  $sql = "INSERT INTO `message`(`id`,`name`,`email`,`message`) VALUES (null,'{$name}','{$email}','{$message}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $contact = [
      'name' => $name,
      'email' => $email,
      'mesage' => $message,
      'id' => mysqli_insert_id($con)
    ];
    echo json_encode($contact);
  }
  else
  {
    http_response_code(422);
  }
}
else{    
    echo "L'adresse E-mail n'est pas valide." ;  
    http_response_code(400);
    }
}
  