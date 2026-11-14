<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$connection = new mysqli('localhost', 'rapidx', 'Ne0nFutur3*', 'db_rapidx'); // change this connection for deployment
$pattern = isset($_GET['pattern'])?$_GET['pattern']:'';

$query = "SELECT * FROM modules
WHERE `module_name` LIKE '%".$pattern."%' AND module_stat = 1";

$result = $connection->query($query);

if (!$result) {
    die("Query failed: " . $connection->error); // 🔍 show exact reason
}

$data = [];
while ($row = $result->fetch_assoc()) {
    // print_r($row); // or whatever processing you need
    $data[] = $row;
}

echo json_encode($data);

?>