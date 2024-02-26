<?php
include '../config.php';
session_start();
$redirect = $_SERVER['HTTP_REFERER'];

$user = $_SESSION['user_id'];
$foldername = $_POST['foldername'];

$sql = "INSERT INTO sharefolder (sf_user, sf_name)
VALUES ('$user',' $foldername')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['sf_created'] = "success";
    header("location: $redirect");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>