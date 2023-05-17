<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


include 'db_connection.php';

$data = json_decode(file_get_contents("php://input"));

if ($data === null) {
    die("Error: request body is empty or not valid JSON");
  }
  
  if (!isset($data->name) || !isset($data->email) || !isset($data->contact) || !isset($data->address)) {
    die("Error: request body does not contain expected fields");
  }
  

$name = $data->name;
$email = $data->email;
$contact = $data->contact;
$address = $data->address;

// Check if connection was unsuccessful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert the form data into a table
$query = "INSERT INTO users (name, email, contact, address) VALUES ('$name', '$email', '$contact', '$address')";

if (mysqli_query($conn, $query)) {
  echo json_encode(array("status" => true, "message" => "User added successfully"));

} else {
  echo json_encode(array("status" => false, "message" => "Error adding user"));
}
