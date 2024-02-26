<?php
include '../config.php';
session_start();

$redirect = $_SERVER['HTTP_REFERER'];
$fid = $_GET['fid'];

// find friend userid  
$finduser = "SELECT * FROM friend_requests where fr_id= $fid";
$findresult = $conn->query($finduser);

if ($findresult->num_rows > 0) {
  // output data of each row
  while($find = $findresult->fetch_assoc()) {
    $to = $find['fr_to'];
    $from = $find['fr_from'];
    //insert statements in friends database 
    // make both to and from friends 
    $fromfriend = "INSERT INTO friends (frd_user, frd_friend) values ($from , $to);";
    $fromfriend .= "INSERT INTO friends (frd_user, frd_friend) values ($to, $from);";
    if ($conn->multi_query($fromfriend) === TRUE) {
        // after inserting both statements successfully update the friend request status 
        mysqli_next_result($conn); // Move to the next query result

        $status = "DELETE FROM friend_requests WHERE fr_id=$fid";

        if ($conn->query($status) === TRUE) {
            $_SESSION['approve'] = "success";
            header("location: $redirect");
        } else {
            echo "Error updating record: " . $conn->error;
        }
      } else {
        echo "Error: " . $fromfriend . "<br>" . $conn->error;
      }
  }
} else {
  echo "0 results";
}
?>