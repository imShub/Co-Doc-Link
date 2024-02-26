<?php
include '../config.php';
session_start();

$user = $_SESSION['user_id'];
$pin = $_POST['pin'];
$hashed_pin = password_hash($pin, PASSWORD_DEFAULT); //CREATE PIN HASHED
$password = $_POST['password'];
$redirect = $_SERVER['HTTP_REFERER'];

// fetch password from database 
$pwd = "SELECT password from users where user_id = $user";
$pwdresult = $conn->query($pwd);

if ($pwdresult->num_rows > 0) {
  // output data of each row
  while($pwdrow = $pwdresult->fetch_assoc()) {
    $hashed = $pwdrow['password']; 
    if (password_verify($password, $hashed)) {
        // if password verified change pin 
        $update = "UPDATE users SET user_pin ='{$hashed_pin}' WHERE user_id=$user";

                if ($conn->query($update) === TRUE) {
                    $_SESSION['pinchanged'] = "success";
                    header("location: $redirect");
                } else {
                echo "Error updating record: " . $conn->error;
                }
    }else {
        $_SESSION['wrongpwd'] = "success";
        header("location: $redirect");
    }
  }
} else {
  echo "0 results";
}

?>