<?php
include 'conn.php';

//get body content
$data = json_decode(file_get_contents('php://input'));

$name = $data->name;
$email = $data->email;
$password = $data->password;
$about_me = $data->about_me;

//create new folder (for profile picture)
$directory = 'uploads/' . $name;

if(!file_exists($directory)){
    mkdir($directory);
}

//make sql query
$sql = "INSERT INTO user SET name=?, email=?, password=?, about_me=?";

//prepare and execute sql query
if($stmt = $conn->prepare($sql)){
    $stmt->bind_param('ssss', $name, $email, $password, $about_me);
    $stmt->execute();

    //message for success
    $message_arr = array(
        "Status"=>true,
        "Message"=>"User created"
    );
}else{
    //message for fail
    $message_arr = array(
        "Status"=>false,
        "Message"=>"User cannot be created"
    );
}

//print message
print_r(json_encode($message_arr));