<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include 'db_connection.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$name = $data->name;
$email = $data->email;
$contact = $data->contact;
$address = $data->address;

// Check if connection was unsuccessful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert the form data into a table
$query = "UPDATE users SET name =  '${name}', email = '${email}', contact = '${contact}', address = '${address}' where id = {$id}";

if (mysqli_query($conn, $query)) {
    echo json_encode(array('message' => 'Record Updated', 'status' => true));
}else {
    echo json_encode(array('message' => 'Record not Updated', 'status' => false));
}