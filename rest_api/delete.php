<?php
include 'conn.php';

//get body content
$data = json_decode(file_get_contents('php://input'));

$name = $data->name;

//delete existing picture if exists
$directory = 'uploads/' . $name . '/profile.png';

if(file_exists($directory)){
    unlink($directory);
}

//delete user directory
$directory = 'uploads/' . $name;
rmdir($directory);

//make sql query
$sql = "DELETE FROM user WHERE name=?";

//prepare and execute sql query
if($stmt = $conn->prepare($sql)){
    $stmt->bind_param('s', $name);
    $stmt->execute();

    //message for success
    $message_arr = array(
        "Status"=>true,
        "Message"=>"User deleted"
    );
}else{
    //message for fail
    $message_arr = array(
        "Status"=>false,
        "Message"=>"Cannot delete user"
    );
}

//print message
print_r(json_encode($message_arr));