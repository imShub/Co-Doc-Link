<?php
include '../config.php';
session_start();

$user = $_SESSION['user_id'];
$pin = $_POST['pin'];
$folderid = $_POST['folderid'];
$redirect = $_SERVER['HTTP_REFERER'];


$sql = "SELECT * from folders where folder_id = $folderid";
$result = $conn->query($sql);

// first fetch lock status from database and update values based on lock status 
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $folderlock = $row['folder_lock'];
    // if folder is unlocked update value to 1 
    if ($folderlock == 0) {
        $updatelock = "1";
    }
    // if folder is locked update value to 0 means unlock the lock 
    else {
        $updatelock = "0";
    }

    // Verify user PIN from database 
    $pinsql = "SELECT * from users where user_id = $user";
    $verifyresult = $conn->query($pinsql);

        if ($verifyresult->num_rows > 0) {
        // output data of each row
        while($pinrow = $verifyresult->fetch_assoc()) {
            $hashed = $pinrow['user_pin'];
            if (password_verify($pin, $hashed)) {
                // if password matched update lock value in database 
                $updatelockstatus = "UPDATE folders SET folder_lock ='{$updatelock}' WHERE folder_id = $folderid";

                if ($conn->query($updatelockstatus) === TRUE) {
                    $_SESSION['locked'] = "success";
                    header("location: $redirect");
                } else {
                    $_SESSION['error'] = "success";
                    header("location: $redirect");
                } 
            }else {
                $_SESSION['pin_notmatch'] = "success";
                header("location: $redirect");
            }
  }
} else {
  echo "0 results";
}

  }
} else {
  echo "0 results";
}

?>