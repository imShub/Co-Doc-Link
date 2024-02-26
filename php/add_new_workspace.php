<?php
include '../config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the folder name from the form
    $workspaceName = $_POST["workspace"];
    $user = $_SESSION['user_id'];
$redirect = $_SERVER['HTTP_REFERER'];

    // Define the directory where you want to create the folder
    $directory = "../workspace_list/"; // Replace with the actual path

    // Check if the folder already exists
    if (!file_exists($directory . $workspaceName)) {
        // Create the new folder
        if (mkdir($directory . $workspaceName, 0777, true)){
            // Folder created successfully, now insert into the database

            // Insert folder name into the database
            $sql = "INSERT INTO workplace (workplace_host_id, workplace_name) VALUES ('$user', '$workspaceName')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['workspace'] = "success";
                    header("location: $redirect");
            } else {
                echo "Error creating workspace " . $conn->error;
            }

            // Close the database connection
            $conn->close();
        } else {
            echo "Error creating workspace.";
        }
    } else {
        $_SESSION['workspace_exists'] = "success";
                    header("location: $redirect");
    }
}
?>