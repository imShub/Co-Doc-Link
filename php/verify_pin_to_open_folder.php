<?php
include '../config.php';
session_start();

$user = $_SESSION['user_id'];
$redirect = $_SERVER['HTTP_REFERER'];
$pin = $_POST['pin'];
$folderid = $_POST['folderid'];

// get userpin from database 
$sql = "SELECT * from users where user_id = $user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   $hashed = $row['user_pin'];
//    check pin is matched or not 
if (password_verify($pin, $hashed)) {
    // if pin verified redirect to folder location 
    header("location: ../documents_lists_byfolder.php?fid=$folderid");
}
// if pin not verified show notification 
else {
    $_SESSION['wrongpin'] = "success";
    header("location: $redirect");
}
  }
} else {
  echo "0 results";
}

?>