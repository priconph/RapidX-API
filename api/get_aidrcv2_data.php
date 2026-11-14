<?php
// required headers
// header("Access-Control-Allow-Origin: *");
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: http://rapid', true);
header("Content-Type: application/json; charset=UTF-8");

define('TIMEZONE', 'Asia/Manila');
date_default_timezone_set(TIMEZONE);

$connection = new mysqli('localhost', 'rapidx', 'Ne0nFutur3*', 'db_aidrc_v2'); // change this connection for deployment

// Check connection
if ($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}
// Query to fetch data from applications table where status is '9'
$query = "SELECT DISTINCT `applications`.`id` AS `application_id`,
                `applications`.`status`,
                `applications`.`aidrc_control_number` AS `control_no`,
                `applications`.`document_name` AS `doc_no`,
                `applications`.`document_revision_number` AS `rev`,
                `applications`.`aidrc_filename`,
                `original_filename` AS `orig_filename`
            FROM `applications`
            LEFT JOIN `patch_data_pdfs` ON `applications`.`id` = `patch_data_pdfs`.`application_id`
            WHERE `applications`.`status` = '8'
            AND `applications`.`logdel` = '0'
            ORDER BY `applications`.`id` DESC";

$result = $connection->query($query);

if (!$result) {
    die("Query failed: " . $connection->error); // 🔍 show exact reason
}

$data = [];
while ($row = $result->fetch_assoc()) {
    // print_r($row); // or whatever processing you need
    $data[] = $row;
}

function utf8ize($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } elseif (is_string($mixed)) {
        return mb_convert_encoding($mixed, 'UTF-8', 'UTF-8');
    }
    return $mixed;
}

$data = utf8ize($data);

// Return JSON response (for your AJAX DataTable)
header('Content-Type: application/json');
// echo json_encode([ "data" => $data ]);

$json = json_encode(["data" => $data]);

if ($json === false) {
    die("JSON Error: " . json_last_error_msg());
}

echo $json;

$connection->close();

?>