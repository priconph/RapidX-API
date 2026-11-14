<?php

$sql_servername = "192.168.3.247";
$sql_username = "sa";
$sql_password = "Pr1c0N";
$sql_dbname = "cn_v4";

MSSQL_CONNECT($sql_servername,$sql_username,$sql_password) or DIE("DATABASE FAILED TO RESPOND.");
mssql_select_db($sql_dbname) or DIE("Database unavailable");

$sql_query = "

select TOP 10 r.*,h.NAME,c.CNAME,r.KVOL-r.HVOL as ZAN
from XRECE r left join XHEAD h on h.CODE=r.CODE left join XCUST c on c.CUST=r.CUST
where r.DOSEIBAN<>0 and r.KVOL>r.HVOL AND r.SORDER = '450223211200010'
order by r.NDATE,r.SORDER,r.SEDA
";


$sql_result = mssql_query( $sql_query );
while($row=mssql_fetch_array($sql_result)){
	print_r($row);
}

?>