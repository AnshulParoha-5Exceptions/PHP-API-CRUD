<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'db_connection.php';

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query) or die("SQL QUERY FAILED..");

if (mysqli_num_rows($result) > 0) {
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($output);
}else {
    echo json_encode(array('message'=> 'No Record Found', 'status'=> false));
}
