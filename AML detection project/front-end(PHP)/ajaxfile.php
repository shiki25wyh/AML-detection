<?php
header('Content-Type: application/json');
$file="./uploads/test.csv";
$csv= file_get_contents($file);
$array = array_map("str_getcsv", explode("\n", $csv));
$json = json_encode($array);


echo $json;


?>