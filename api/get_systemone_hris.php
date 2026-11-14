<?php

$records = array();

$conn_sc = new mysqli('192.168.3.240', 'rapidx', 'Ne0nFutur3*', 'db_hris');
if ($conn_sc->connect_error) {
    die("Connection failed: " . $conn_sc->connect_error);
}

$sql = "SELECT * FROM `tbl_EmployeeInfo` WHERE EmpStatus = 1";
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