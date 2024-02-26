<?php
include '../config.php';
session_start();

$redirect = $_SERVER['HTTP_REFERER'];

$sharefolder = $_POST['sharefolder'];
$member = $_POST['member'];

// check if member is already added in share folder
$verify_sql = "SELECT count(member_id) as verified from sharefolder_members where member_sf = $sharefolder AND member_userid = $member";
$verify_result = $conn->query($verify_sql);

if ($verify_result->num_rows > 0) {
  // output data of each row
  while($verify_row = $verify_result->fetch_assoc()) {
    $verified = $verify_row['verified'];
    if ($verified == 0 ) {
       // if user not exits then add member in database 
       $sql = "INSERT INTO sharefolder_members ( member_sf ,member_userid)
       VALUES ('$sharefolder', '$member')";

       if ($conn->query($sql) === TRUE) {
           $_SESSION['memberadded'] = "success";
           header("location: $redirect");
       } else {
       echo "Error: " . $sql . "<br>" . $conn->error;
       }
    }
    else{
        $_SESSION['memberexists'] = "success";
           header("location: $redirect");
    }
  }
} else {
  echo "0 results";
}

?>