<?php
// $po = isset($_GET['po'])?$_GET['po']:'';

// if(strlen($po)>10){
// 	$po = substr($po, 0, -5);
// }
$barcode = 1;

$sql_servername = "192.168.3.247";
$sql_username = "sa";
$sql_password = "Pr1c0N";
$sql_dbname = "bu2_v4";

MSSQL_CONNECT($sql_servername,$sql_username,$sql_password) or DIE("DATABASE FAILED TO RESPOND.");
mssql_select_db($sql_dbname) or DIE("Database unavailable");

// echo $sql_query = "
// 	SELECT VHEAD.NAME,VITEM.DRAWING_NUM,VITEM.VENDOR FROM VHEAD LEFT JOIN VITEM ON VHEAD.CODE = VITEM.CODE WHERE VHEAD.CODE='".$barcode."' ;
// ";
$sql_query = "
	SELECT VHEAD.NAME,VITEM.DRAWING_NUM,VITEM.VENDOR FROM VHEAD LEFT JOIN VITEM ON VHEAD.CODE = VITEM.CODE WHERE VHEAD.CODE='109244801';
";


$sql_result = mssql_query( $sql_query );
while($row=mssql_fetch_array($sql_result)){
	echo json_encode( $row );

}
/*



*/

?>