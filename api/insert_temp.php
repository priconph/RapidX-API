<?php
// required headers
header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Origin: http://rapid', true);
header("Content-Type: application/json; charset=UTF-8");

define('TIMEZONE', 'Asia/Manila');
date_default_timezone_set(TIMEZONE);

// $date_today = date(NOW);

$hum = isset($_GET['hum'])?$_GET['hum']:'';
$temp = isset($_GET['temp'])?$_GET['temp']:'';
$counter = isset($_GET['counter'])?$_GET['counter']:'';
$addtemp = isset($_GET['add_temp'])?$_GET['add_temp']:'';
$addhum = isset($_GET['add_hum'])?$_GET['add_hum']:'';


$temp_round = round($temp,2);
$hum_round = round($hum,2);
$addtemp_round = round($addtemp,2);
$addhum_round = round($addhum,2);

$temperature = $temp_round + $addtemp_round;
$humidity = $hum_round + $addhum_round;


$min_temp = 18;
$max_temp = 35;
// $temp = '36.2'; 
header('Location: http://192.168.3.188/RT_RH/get_temp_from_raspi/'.$temp.'/'.$hum);
// header('Location: http://192.168.3.188/RT_RH/get_data_from_raspi/'.$temp.'/'.$hum);
// $date_time = NOW();

    $date_time = date("i:s");

    if($counter == 1 || $counter == '1'){
        $connection = new mysqli('localhost', 'rapidx', 'Ne0nFutur3*', 'db_temp'); // change this connection for deployment
        // Check connection
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        // $query = "INSERT INTO c3_label_huaweis(device, datetime,temp,hum)VALUES('1','2','3','4')";

        if($temperature <= $max_temp && $temperature >= $min_temp){
            $query = "INSERT INTO temp_data(device,temperature,humidity,datetime)VALUES('1',$temperature,$humidity,NOW())";
        
            if ($connection->query($query) === TRUE) {
            //    echo "meron na";
            } else {
                echo "<br>";
                echo " Error: " . $query . "<br>" . $connection->error;
            }
            $connection->close();
        }

    }

    


// $temp_second = isset($_GET['temp'])?$_GET['temp']:'';
// $today = isset($_GET['date_today'])?$_GET['date_today']:'';
// $item_code = isset($_GET['txt_item_code'])?$_GET['txt_item_code']:'';
// $pn = isset($_GET['txt_pn'])?$_GET['txt_pn']:'';
// $mpn = isset($_GET['txt_mpn'])?$_GET['txt_mpn']:'';
// $qty = isset($_GET['txt_qty'])?$_GET['txt_qty']:'';
// $date = isset($_GET['txt_date'])?$_GET['txt_date']:'';
// $lotno = isset($_GET['txt_lot_no'])?$_GET['txt_lot_no']:'';
// $lotno_extension = isset($_GET['txt_lot_no_count'])?$_GET['txt_lot_no_count']:'';
// $print_lot = isset($_GET['print_lots'])?$_GET['print_lots']:'';
// $print_lot_quantity = isset($_GET['print_lot_quantities'])?$_GET['print_lot_quantities']:'';
// $unique_number = isset($_GET['txt_unique'])?$_GET['txt_unique']:'';
// $max_row = isset($_GET['txt_max_row'])?$_GET['txt_max_row']:'';
// $date_encoded = date('Y-m-d h:i:s');
// $username = isset($_GET['username'])?$_GET['username']:'';
// $txt_employee_number_scanner = isset($_GET['txt_employee_number_scanner'])?$_GET['txt_employee_number_scanner']:'';
// $partial = isset($_GET['partial'])?$_GET['partial']:'';
// $po_num = isset($_GET['txt_hidden_po_number'])?$_GET['txt_hidden_po_number']:'';

/*
    For testing purposes only to get the passed data that came from ajax request of C3 Label Huawei in Rapid system
*/
// $records = array();
// $get1 = $_GET['print_lots'];
// $get2 = $_GET['print_lot_quantities'];
// $get3 = $_GET['txt_employee_number_scanner'];

// array_push($records, $get1);
// array_push($records, $get2);
// array_push($records, $get3);




// Insert in to c3_label_huaweis(table) in RapidX pats->cn->db_pats_cn_new
// $lot_number_for_c3_history = $lotno."-".$lotno_extension;

// $query = "INSERT INTO c3_label_huaweis(item_code, pn, mpn, qty, `date`, lotno, lotno_extension, print_lot, print_lot_quantity, unique_number, max_row, date_encoded, username, emp_number, po_no)
// VALUES ('$item_code', '$pn', '$mpn', '$qty', '$date', '$lotno', '$lotno_extension', '$print_lot', '$print_lot_quantity', '$unique_number', '$max_row', '$date_encoded', '$username', '". strtoupper($txt_employee_number_scanner) ."', '$po_num')";

// if ($connection->query($query) === TRUE) {
//     $c3_label_huawei_id = $connection->insert_id;
//     // $insert_to_c3_label_history = "INSERT INTO c3_label_history(created_at,is_huawei, c3_label_huawei_id)
//     // VALUES ('$date_encoded', '1', '$c3_label_huawei_id')";
//     $insert_to_c3_label_history = "INSERT INTO c3_label_history(lot_number,created_at,is_huawei, c3_label_huawei_id)
//     VALUES ('$lot_number_for_c3_history','$date_encoded', '1', '$c3_label_huawei_id')";
//     if ($connection->query($insert_to_c3_label_history) === TRUE) {
//         // $connection->query($insert_to_c3_label_history);
//         echo "New record created successfully. C3 Label ID after insert: $c3_label_huawei_id";
//     }else{
//         echo "Not inserted in insert_to_c3_label_history. Need to change the data structure in the database and set to null as default";
//     }

// } else {
//     echo "<br>";
//     echo " Error: " . $query . "<br>" . $connection->error;
// }
// $connection->close();

// echo json_encode( $records );
?>