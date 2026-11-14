<?php

$barcode = isset($_GET['barcode'])?$_GET['barcode']:'';
$name = isset($_GET['name'])?$_GET['name']:'';
$records = array();

$conn_sc = new mysqli('localhost', 'rapidx', 'Ne0nFutur3*', 'db_cn_ppts');
if ($conn_sc->connect_error) {
    die("Connection failed: " . $conn_sc->connect_error);
}

$sql = "SELECT * FROM `devices` WHERE status = 1";
if($barcode){
	$sql.=" AND `barcode` = '".$barcode."' ";
}
if($name){
	$sql.=" AND `name` = '".$name."' ";
}

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