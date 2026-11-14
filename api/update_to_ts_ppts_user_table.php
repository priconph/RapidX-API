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
// $password = isset($_GET['password']) ? (string)$_GET['password']:'';
$position = isset($_GET['position']) ? (int)$_GET['position']:0;
$is_password_changed = 1;
$status = 1;
$user_level_id = isset($_GET['user_level_id']) ? (int)$_GET['user_level_id']:'';
$created_by = isset($_GET['created_by']) ? (int)$_GET['created_by']:'';
$last_updated_by = isset($_GET['last_updated_by']) ? (int)$_GET['last_updated_by']:'';
$created_at = date('Y-m-d H:i:s');
$updated_at = date('Y-m-d H:i:s');
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
else{
    echo "Connection Established";
    echo "\r\n";
}

/**
 * Update users(table)
 */
$update_user = "UPDATE users SET `name` = '$name', `username` = '$username', `email` = '$email', `employee_id` = '$employee_id', `fvi_no` = $fvi_no, `position` = $position, `is_password_changed` = $is_password_changed, `status` = $status, `update_version` = $update_version, `user_level_id` = $user_level_id, `last_updated_by` = $last_updated_by, `created_at` = '$created_at' WHERE `employee_id` = '$employee_id' AND `status` = 1";

if ($connection->query($update_user) === TRUE) {
    // echo "Success query for update_user";
} else {
    echo " Error: " . $update_user . "\r\n" . $connection->error;
    echo "\r\n";
    echo "Failed query for update_user";
}

if($oqc_stamp != 'null'){
    // Search based on employee_id and get id to be used in oqc_stamps(table) to query
    $get_user_id_by_employee_id = "SELECT * FROM users WHERE `employee_id` = '$employee_id'";
    $get_user_id_by_employee_id_result = $connection->query($get_user_id_by_employee_id);
    $user_id;
    if ($get_user_id_by_employee_id_result->num_rows > 0) {
        $row = $get_user_id_by_employee_id_result->fetch_assoc();
        $user_id = $row["id"];
    }

    /**
     * Get user if has oqc stamp then perform the below code else insert in oqc_stamps(table)
     */
    $get_user_oqc_stamp = "SELECT * FROM oqc_stamps WHERE `user_id` = $user_id ORDER BY `id` DESC LIMIT 1";
    $get_user_oqc_stamp_result = $connection->query($get_user_oqc_stamp);

    if ($get_user_oqc_stamp_result->num_rows > 0) {
        $row = $get_user_oqc_stamp_result->fetch_assoc();
        $oqc_stamp_based_on_query = $row["oqc_stamp"];
        $current_update_version = $row["update_version"] + 1;

        /**
         * If the requested $oqc_stamp(var) is not equal to $oqc_stamp_based_on_query(var) then perform the below code
         */
        if($oqc_stamp != $oqc_stamp_based_on_query){
            /**
             * Update the previous oqc stamp to a new one in oqc_stamps(table)
             */
            $update_previous_oqc_stamp_status = "UPDATE oqc_stamps SET `update_version` = $current_update_version, `status` = 2, `last_updated_by` = $last_updated_by, `updated_at` = '$updated_at' WHERE `user_id` = $user_id";

            if ($connection->query($update_previous_oqc_stamp_status) === TRUE) {
                /**
                 * Insert in oqc_stamps(table)
                 */
                echo "Success query for update_previous_oqc_stamp_status current_update_version: $current_update_version";
                
                // After updating previous oqc stamp status to 2-inactive then Insert new oqc stamp
                $insert_another_for_oqc_stamp = "INSERT INTO oqc_stamps(`oqc_stamp`, `status`, `update_version`, `user_id`, `created_by`,  `last_updated_by`, `created_at`, `updated_at`)
                VALUES ('$oqc_stamp', 1, $update_version, $user_id, $created_by, $last_updated_by, '$created_at', '$updated_at')";
                if ($connection->query($insert_another_for_oqc_stamp) === TRUE) {
                    echo "\r\n";
                    echo "Inserted successfully for another oqc_stamp";
                }else{
                    echo "\r\n";
                    echo "Error: $insert_another_for_oqc_stamp";
                    echo "\r\n";
                    echo "SQL Error: " . $connection->error;
                }
            }else{
                echo "\r\n";
                echo "SQL Error: " . $connection->error;
                echo "\r\n";
                echo "Not updated previous update_previous_oqc_stamp_status in oqc_stamps(table).";
            }
        }else{
            echo "Error: $oqc_stamp_based_on_query is equal to $oqc_stamp";
            echo "\r\n";
            echo "Do nothing";
        }
    }else{
        /**
         * With existed user but no oqc stamp
         */
        // Search based on employee_id and get id to be used in oqc_stamps(table) to insert
        $get_user_by_employee_id = "SELECT * FROM users WHERE `employee_id` = '$employee_id'";
        $get_user_by_employee_id_result = $connection->query($get_user_by_employee_id);
        
        if ($get_user_by_employee_id_result->num_rows > 0) {
            $row = $get_user_by_employee_id_result->fetch_assoc();
            $user_id = $row["id"];
            
            /**
             * Insert in oqc_stamps(table)
             */
            $insert_oqc_stamp = "INSERT INTO oqc_stamps(`oqc_stamp`, `status`, `update_version`, `user_id`, `created_by`,  `last_updated_by`, `created_at`)
            VALUES ('$oqc_stamp', 1, $update_version, $user_id, $created_by, $last_updated_by, '$created_at')";
    
    
            if ($connection->query($insert_oqc_stamp) === TRUE) {
                echo "Success query for insert_oqc_stamp";
            }else{
                echo "   :   ";
                echo " Error: " . $insert_oqc_stamp . "   :   SQL Error: " . $connection->error;
            }
        }else{
            echo "Success query for get_user_by_employee_id_result but no results";
        }
    }
}
else{
    echo "Not set the oqc_stamp: $oqc_stamp";
}

?>
