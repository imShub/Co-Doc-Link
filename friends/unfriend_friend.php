<?php
include '../config.php';
session_start();

$redirect = $_SERVER['HTTP_REFERER'];

$userid = $_SESSION['user_id'];
$frdid = $_GET['frd_id'];

// Find friend userid 
$sql = "SELECT * FROM friends where frd_id = $frdid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    // Friend ID
    $friendid = $row['frd_friend'];

    // Delete the first record
    $delete1 = "DELETE FROM friends where frd_user = $userid AND frd_friend = $friendid";
    if ($conn->query($delete1) === TRUE) {
        // Delete the second record
        $delete2 = "DELETE FROM friends where frd_user = $friendid AND frd_friend = $userid";
        if ($conn->query($delete2) === TRUE) {
            $_SESSION['unfriend'] = "success";
            header("location: $redirect");
        } else {
            echo "Error deleting second record: " . $conn->error;
        }
    } else {
        echo "Error deleting first record: " . $conn->error;
    }
  }
} else {
  echo "Friend ID not Found!";
}
?>