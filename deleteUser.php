<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
include 'db_connection.php';

$data = json_decode(file_get_contents('php://input'));

$id = $data->id;


$query = "DELETE FROM users WHERE id = {$id}";

if (mysqli_query($conn, $query)) {
    echo json_encode(array('message' => "User deleted successfully", 'status' => true));
} else {
    echo json_encode(array('message' => "Something went wrong", 'status' => false));
}
