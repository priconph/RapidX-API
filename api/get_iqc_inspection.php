<?php

$lot_no = isset($_GET['lot_no'])?$_GET['lot_no']:'';
$records = array();

$conn_sc = new mysqli('localhost', 'rapidx', 'Ne0nFutur3*', 'db_pats_cn_ppd');
if ($conn_sc->connect_error) {
    die("Connection failed: " . $conn_sc->connect_error);
}

$sql = "SELECT * FROM `iqc_inspections` WHERE judgement = 1 AND lot_no = '".$lot_no."' ";
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