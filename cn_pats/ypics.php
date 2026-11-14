<?php

$po = isset($_GET['po'])?$_GET['po']:'';

if(strlen($po)>10){
	$po = substr($po, 0, -5);
}

$po_details = array();
//---
$sql_servername = "192.168.3.247";
$sql_username = "sa";
$sql_password = "Pr1c0N";
$sql_dbname = "cn_v4";


MSSQL_CONNECT($sql_servername,$sql_username,$sql_password) or DIE("DATABASE FAILED TO RESPOND.");
mssql_select_db($sql_dbname) or DIE("Database unavailable");

$sql_query = "
	SELECT TOP 1 
	XRECE.CODE AS prodcode,
	XRECE.SORDER AS ponum,
	XRECE.BUYERS_CODE AS buyerscode,
	XHEAD.NAME AS prodname, 
	XRECE.KVOL AS orderqty,
	XITEM.DRAWING_NUM AS drawing_num
	FROM XHEAD
	INNER JOIN XRECE ON XHEAD.CODE = XRECE.CODE
	INNER JOIN XITEM ON XHEAD.CODE = XITEM.CODE
";
	// WHERE XRECE.SORDER like '%".$po."%'


$po_start = str_split($po);
$with_dot = 0;

if($po_start[0] == 'E'){ //if PO starts on E
	$sql_query = $sql_query . " where XRECE.SORDER = '".$po."'";
} else if (strpos($po, '4501927162') !== false || strpos($po, '4501885018') !== false) {
	$sql_query = $sql_query . " where XRECE.SORDER = '".$po."00011'";
} else{
	if($with_dot == 1){
		$sql_query .= " where XRECE.SORDER='".$po."00010.' OR XRECE.SORDER='".$po."00010A' OR XRECE.SORDER='".$po."00010B' OR XRECE.SORDER='".$po."00010C' OR XRECE.SORDER='".$po."00011'";
	}else{
		$sql_query = $sql_query . " where XRECE.SORDER='".$po."00010'";
	}
}	



$sql_result = mssql_query( $sql_query );
if($row=mssql_fetch_array($sql_result)){
	$po_details = $row;
}
//---


// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 


// header('Content-Type: application/json');
// header("Set-Cookie", "HttpOnly;Secure;SameSite=Strict");
// print_r( $po_details );
echo json_encode( $po_details );

?>