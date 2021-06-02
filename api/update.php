<?php
require 'database-admin.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
  if(trim($request->date) === '' || trim($request->description) === '' || trim($request->img) === '' )
  {
    return http_response_code(400);
  }

  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->id);
  $date = mysqli_real_escape_string($con, trim($request->date));
  $description = mysqli_real_escape_string($con, trim($request->description));
  $img = mysqli_real_escape_string($con, trim($request->img));

  // Update.
  $sql = "UPDATE `data` SET `description`='$description',`date`='$date', `img`='$img', `imageName`='$imageLink' WHERE `id` = '{$id}' LIMIT 1";

  if(mysqli_query($con, $sql))
  {
    http_response_code(204);
  }
  else
  {
    return http_response_code(422);
  }  
}