<?php
include 'conn.php';

//$data = json_decode(file_get_contents('php://input'));

//make sql query
$sql = 'SELECT * FROM user';

//prepare and execute sql query
if($stmt = $conn->prepare($sql)){
    $stmt->execute();
    //get result
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);

    //message for success
    $message_arr = array(
        "status" => true,
        "users" => $users
    );
}else{
    //message for failed
    $message_arr = array(
        "status" => false,
        "message" => "user(s) cannot be fetched"
    );
}

print_r(json_encode($message_arr));