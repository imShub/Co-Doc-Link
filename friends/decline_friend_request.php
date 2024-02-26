<?php
include '../config.php';
session_start();

$redirect = $_SERVER['HTTP_REFERER'];
$fid = $_GET['fid'];

$sql = "DELETE FROM friend_requests WHERE fr_id=$fid";

if ($conn->query($sql) === TRUE) {
    $_SESSION['decline'] = "success";
    header("location: $redirect");
} else {
  echo "Error updating record: " . $conn->error;
}

?>