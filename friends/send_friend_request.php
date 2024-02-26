<?php
include '../config.php';
session_start();

$redirect = $_SERVER['HTTP_REFERER'];
$from = $_SESSION['user_id'];
$to = $_GET['uid'];

$sql = "INSERT INTO friend_requests (fr_from, fr_to)
VALUES ('$from', '$to')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['requestsent'] = "success";
    header("location: $redirect");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>