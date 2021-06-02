<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");

require 'database-admin.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Sanitize.
  $date = mysqli_real_escape_string($con, trim($request->date));
  $description = mysqli_real_escape_string($con, trim($request->description));

    var_dump($request);
    $imageLink = '../assets/img/'.uniqid().substr($request['imageName'], strrpos($request['imageName'], '\\')+1);
    $splited = explode(',',$request['img']);
    $binary = base64_decode($splited[1]);
    file_put_contents($imageLink,$binary);

  // Create.
  $sql = "INSERT INTO `data`(`id`,`description`,`date`,`img`,`imageName`) VALUES (null,'{$description}','{$date}','{$img}','{$imageLink}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $data = [
      'description' => $description,
      'date' => $date,
      'img' => $img,
      'imageName' => $imageLink,
      'id' => mysqli_insert_id($con)
    ];
    echo json_encode($data);
  }
  else
  {
    http_response_code(422);
  }
  }
