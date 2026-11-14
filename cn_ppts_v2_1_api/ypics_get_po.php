<?php


$po_number = isset($_GET['po'])?$_GET['po']:'';

$sql_servername = "192.168.3.247";
$sql_username = "sa";
$sql_password = "Pr1c0N";
$sql_dbname = "cn_v4";

MSSQL_CONNECT($sql_servername,$sql_username,$sql_password) or DIE("DATABASE FAILED TO RESPOND.");
mssql_select_db($sql_dbname) or DIE("Database unavailable");

$sql_query = "
SELECT TOP 1 r.CVOL, r.CODE,r.SORDER, h.NAME FROM XRECE  r left join XHEAD h on h.CODE = r.CODE WHERE r.SORDER = '450245507700010'
";


$sql_result = mssql_query( $sql_query );
while($row=mssql_fetch_array($sql_result)){
	print_r($row);
}

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
?>