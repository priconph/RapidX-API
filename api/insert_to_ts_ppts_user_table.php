<?php
// required headers
header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Origin: http://rapidx', true);
header("Content-Type: application/json; charset=UTF-8");

define('TIMEZONE', 'Asia/Manila');
date_default_timezone_set(TIMEZONE);

$name = isset($_GET['name']) ? (string)$_GET['name']:'';
$username = isset($_GET['username']) ? (string)$_GET['username']:'';
$email = isset($_GET['email']) ? (string)$_GET['email']:'NULL'; // optional
$employee_id = isset($_GET['employee_id']) ? (string)$_GET['employee_id']:'';
$fvi_no = isset($_GET['fvi_no']) ? (int)$_GET['fvi_no']:'NULL'; // optional
$oqc_stamp = isset($_GET['oqc_stamp']) ? (string)$_GET['oqc_stamp']:'NULL'; // optional
$password = isset($_GET['password']) ? (string)$_GET['password']:'';
$position = isset($_GET['position']) ? (int)$_GET['position']:0;
// $is_password_changed = 0; // Commented by JD 12-02-2022
$is_password_changed = 1;
$status = 1;
$user_level_id = isset($_GET['user_level_id']) ? (int)$_GET['user_level_id']:'';
$created_by = isset($_GET['created_by']) ? (int)$_GET['created_by']:'';
$last_updated_by = isset($_GET['created_by']) ? (int)$_GET['created_by']:'';
$created_at = date('Y-m-d H:i:s');
$update_version = 1;

// echo $fvi_no;
// echo json_encode($fvi_no);
// echo $oqc_stamp;
// echo json_encode($oqc_stamp);
// return;
// exit(0);


$connection = new mysqli('localhost', 'rapidx', 'Ne0nFutur3*', 'db_pats_ts_ppts');
// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if($oqc_stamp != 'null'){
    $email_null= $email;
    if($email == 'null'){
        
    }
    $query = "INSERT INTO users(`name`, `username`, `email`, `employee_id`, `fvi_no`, `password`, `position`, `is_password_changed`, `status`, `update_version`, `user_level_id`, `created_by`, `last_updated_by`, `created_at`)
    VALUES ('$name', '$username', '$email_null', '$employee_id', $fvi_no, '$password', $position, $is_password_changed, $status, $update_version, $user_level_id, $created_by, $last_updated_by, '$created_at')";

    if ($connection->query($query) === TRUE) {
        // Insert in oqc_stamps(table)
        $user_id = $connection->insert_id;
        $query_for_oqc_stamp = "INSERT INTO oqc_stamps(`oqc_stamp`, `status`, `update_version`, `user_id`, `created_by`, `created_at`, `last_updated_by`)
        VALUES ('$oqc_stamp', $status, $update_version, $user_id, $created_by, '$created_at', $last_updated_by)";

        if ($connection->query($query_for_oqc_stamp) === TRUE) {
            echo "New record created successfully, last inserted id: $user_id";
        }else{
            echo "   :   ";
            echo " Error: " . $query_for_oqc_stamp . "<br>" . $connection->error;
            echo "   :   ";
            echo "Not inserted in users_table.";
        }
    }else {
        echo "<br>";
        echo " Error: " . $query . "<br>" . $connection->error;
        echo "<br>";
    }
    $connection->close();
}else{
    $query = "INSERT INTO users(`name`, `username`, `email`, `employee_id`, `fvi_no`, `password`, `position`, `is_password_changed`, `status`, `user_level_id`, `created_by`, `last_updated_by`, `created_at`)
    VALUES ('$name', '$username', '$email', '$employee_id', $fvi_no, '$password', $position, $is_password_changed, $status, $user_level_id, $created_by, $last_updated_by, '$created_at')";
    
    if ($connection->query($query) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "<br>";
        echo " Error: " . $query . "<br>" . $connection->error;
        echo "<br>";
        echo "Not inserted in users_table.";
    }
    $connection->close();
}






?>
