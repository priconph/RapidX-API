<?php
// required headers
header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Origin: http://rapidx', true);
header("Content-Type: application/json; charset=UTF-8");

define('TIMEZONE', 'Asia/Manila');
date_default_timezone_set(TIMEZONE);

// $search = isset($_GET['search'])?$_GET['search']:'';


$id = isset($_GET['id']) ? (int)$_GET['id']:'';
$barcode = isset($_GET['barcode']) ? (string)$_GET['barcode']:'';
$name = isset($_GET['name']) ? (string)$_GET['name']:'';
$boxing = isset($_GET['boxing']) ? (int)$_GET['boxing']:'';
$ship_boxing = isset($_GET['ship_boxing']) ? (int)$_GET['ship_boxing']:'';
$process = isset($_GET['process']) ? (int)$_GET['process']:'';
$type = isset($_GET['type']) ? (int)$_GET['type']:'';
$status = 1;
$last_updated_by = isset($_GET['last_updated_by']) ? (int)$_GET['last_updated_by']:'';
$updated_at = date('Y-m-d H:i:s');


// echo json_encode($device_name);
// return;
// exit(0);

$connection = new mysqli('localhost', 'rapidx', 'Ne0nFutur3*', 'db_pats_ts_ppts');
// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}else{
    echo "Connection Established";
    echo "\r\n";
}

$update_device = "UPDATE devices SET `name` = '$name', `process` = $process, `boxing` = $boxing, `ship_boxing` = $ship_boxing, `type` = $type, `status` = $status, `barcode` = '$barcode',  `last_updated_by` = $last_updated_by, `updated_at` = '$updated_at' WHERE `id` = $id";

if ($connection->query($update_device) === TRUE) {
    echo "Update successfully";
} else {
    echo " Error: " . $update_device . "\r\n" . $connection->error;
}
$connection->close();

?>
