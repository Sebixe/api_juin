<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");

echo file_get_contents($_REQUEST['f']."quotes.json");