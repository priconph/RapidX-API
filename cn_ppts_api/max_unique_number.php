<?php
define('TIMEZONE', 'Asia/Manila');
date_default_timezone_set(TIMEZONE);

$records = array();
//---
$conn_sc = new mysqli('localhost', 'rapidx', 'Ne0nFutur3*', 'db_cn_ppts');
if ($conn_sc->connect_error) {
    die("Connection failed: " . $conn_sc->connect_error);
}
//---
$sql = "SELECT MAX(`unique_no`) AS unique_no FROM `d_label_histories` WHERE DATE(`created_at`) = '".date('Y-m-d')."'";
//---
// echo $sql;
$result = $conn_sc->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	array_push($records, $row);
    }
}
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
echo json_encode( $records );
?>