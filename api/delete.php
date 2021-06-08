<?php

require 'database-admin.php';

//  Extrait l'id récupéré sur la page d'admin 

$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}

// Supprime les informations de la DB "data" pour l'id récupéré

$sql = "DELETE FROM `data` WHERE `id` ='{$id}' LIMIT 1";

if(mysqli_query($con, $sql))
{
  http_response_code(204);
}
else
{
  return http_response_code(422);
}