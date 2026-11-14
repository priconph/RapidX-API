<?php

define('TIMEZONE', 'Asia/Manila');
date_default_timezone_set(TIMEZONE);

$po_no = isset($_GET['po_no'])?$_GET['po_no']:'';
$id = isset($_GET['id'])?$_GET['id']:'';
$active = isset($_GET['active'])?$_GET['active']:'';
$records = array();

$conn_sc = new mysqli('localhost', 'rapidx', 'Ne0nFutur3*', 'db_pats_cn_test123');
if ($conn_sc->connect_error) {
    die("Connection failed: " . $conn_sc->connect_error);
}

$sql = "SELECT * FROM `shipment_confirmation` WHERE deleted_at is null ";

if($po_no){
	$sql.=" AND `po_no` = '".$po_no."' ";
}

if($id){
	$sql.=" AND `id` = '".$id."' ";
}

if($active==1){
	$sql.=" AND `shipment_date` >= '". date('Y-m-d') ."' ";
}

$sql .= "ORDER BY shipment_date DESC, created_at ASC";




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