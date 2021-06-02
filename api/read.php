<?php
/**
 * Returns the list of Data.
 */
require 'database-admin.php';

$data = [];
$sql = "SELECT id, description, date, img FROM data";

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