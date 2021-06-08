<?php

require 'database-admin.php';

$data = [];
$sql = "SELECT id, description, date, img FROM data";

// Dans le cas où les données sont appelées sur la page d'admin ou sur la page portfolio, cette commande est appelée
// Les informations du portfolio sont récupérés dans la Db, et envoyé en Json

if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $data[$i]['id']    = $row['id'];
    $data[$i]['description'] = $row['description'];
    $data[$i]['date'] = $row['date'];
    $data[$i]['img'] = $row['img'];
    $i++;
  }
  echo json_encode($data);
}
else
{
  http_response_code(404);
}