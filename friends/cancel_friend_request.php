<?php
include '../config.php';
session_start();

$redirect = $_SERVER['HTTP_REFERER'];
$fid = $_GET['fid'];

$sql = "DELETE FROM friend_requests where fr_id = $fid";

if ($conn->query($sql) === TRUE) {
    $_SESSION['cancelrequest'] = "success";
    header("location: $redirect");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>