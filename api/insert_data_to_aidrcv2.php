<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

define('TIMEZONE', 'Asia/Manila');
date_default_timezone_set(TIMEZONE);

// $aidrcv2_id = isset($_GET['aidrcv2_id']) ? (string)$_GET['aidrcv2_id']:'';
// $acdcs_doc_no = isset($_GET['acdcs_doc_no'])?$_GET['acdcs_doc_no']:'';

$aidrcv2_id = isset($_POST['aidrcv2_id']) ? $_POST['aidrcv2_id'] : '';
$acdcs_doc_no = isset($_POST['acdcs_doc_no']) ? $_POST['acdcs_doc_no'] : '';
$updated_at = date('Y-m-d H:i:s');

$connection = new mysqli('localhost', 'rapidx', 'Ne0nFutur3*', 'db_aidrc_v2'); // change this connection for deployment

// Check connection
if ($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}else{
    // Connection Successful
    $aidrc_app = "SELECT 'document_type' FROM applications WHERE logdel = '0' AND id = $aidrcv2_id";

    if($aidrc_app == 2){
        // Update with updated_at field
        // $update_aidrcv2_status = "UPDATE applications SET `new_doc_number` = '$acdcs_doc_no', `updated_at` = '$updated_at', `status` = 9 WHERE `id` = $aidrcv2_id";
        $update_aidrcv2_status = "UPDATE applications SET `new_doc_number` = '$acdcs_doc_no', `status` = 9 WHERE `id` = $aidrcv2_id";
    }else{
        // Update with updated_at field
        // $update_aidrcv2_status = "UPDATE applications SET `document_number` = '$acdcs_doc_no', `updated_at` = '$updated_at', `status` = 9 WHERE `id` = $aidrcv2_id";
        $update_aidrcv2_status = "UPDATE applications SET `document_number` = '$acdcs_doc_no', `status` = 9 WHERE `id` = $aidrcv2_id";
    }

    // $update_aidrcv2_status = "UPDATE applications SET `document_number` = '$acdcs_doc_no', `updated_at` = '$updated_at', `status` = 9 WHERE `id` = $aidrcv2_id";

    if ($connection->query($update_aidrcv2_status) === TRUE) {
        echo "AIDRCV2 Status has been updated with document no: $acdcs_doc_no";
    }else{
        echo "Insert Error: ".$update_aidrcv2_status."\r\n" . $connection->error;
    }
}
$connection->close();

?>