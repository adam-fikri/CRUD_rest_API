<?php
include 'conn.php';

//get body content
$data = json_decode(file_get_contents('php://input'));

$name = $data->name;
$profile_picture = $data->profile_picture;

//delete existing picture if exists
$directory = 'uploads/' . $name . '/profile.png';

if(file_exists($directory)){
    unlink($directory);
}

//decode the picture
$decoded_img = base64_decode($profile_picture);

//add picture to directory
file_put_contents($directory, $decoded_img);

//make sql query
$sql = "UPDATE user SET profile_picture=? WHERE name=?";

//prepare and execute sql query
if($stmt = $conn->prepare($sql)){
    $stmt->bind_param('ss', $directory, $name);
    $stmt->execute();

    //message for success
    $message_arr = array(
        "Status"=>true,
        "Message"=>"Profile picture update"
    );
}else{
    //message for fail
    $message_arr = array(
        "Status"=>false,
        "Message"=>"Cannot update profile picture"
    );
}

//print message
print_r(json_encode($message_arr));