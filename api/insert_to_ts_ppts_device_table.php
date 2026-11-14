<?php
// required headers
header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Origin: http://rapidx', true);
header("Content-Type: application/json; charset=UTF-8");

define('TIMEZONE', 'Asia/Manila');
date_default_timezone_set(TIMEZONE);

// $search = isset($_GET['search'])?$_GET['search']:'';


$barcode = isset($_GET['barcode']) ? (string)$_GET['barcode']:'';
$name = isset($_GET['name']) ? (string)$_GET['name']:'';
$boxing = isset($_GET['boxing']) ? (int)$_GET['boxing']:'';
$ship_boxing = isset($_GET['ship_boxing']) ? (int)$_GET['ship_boxing']:'';
$process = isset($_GET['process']) ? (int)$_GET['process']:'';
$type = isset($_GET['type']) ? (int)$_GET['type']:'';
$status = 1;
$created_by = isset($_GET['created_by']) ? (int)$_GET['created_by']:'';
$created_at = date('Y-m-d H:i:s');


$connection = new mysqli('localhost', 'rapidx', 'Ne0nFutur3*', 'db_pats_ts_ppts');
// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}else{
    echo "Connection Established";
    echo "\r\n";
}

$query = "INSERT INTO devices(`name`, `process`, `boxing`, `ship_boxing`, `type`, `status`, `barcode`,  `created_by`, `created_at`)
VALUES ('$name', $process, $boxing, $ship_boxing, $type, $status, '$barcode', $created_by, '$created_at')";

if ($connection->query($query) === TRUE) {
    echo "New record created successfully";
}else {
    echo "\r\n";
    echo " Error: " . $query . "<br>" . $connection->error;
    echo "\r\n";
    echo $connection->error;
}
$connection->close();
?>
