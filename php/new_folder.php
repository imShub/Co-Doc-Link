<?php
include '../config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the folder name from the form
    $folderName = $_POST["folder"];
    $user = $_SESSION['user_id'];
$redirect = $_SERVER['HTTP_REFERER'];

    // Define the directory where you want to create the folder
    $directory = "../folders_list/"; // Replace with the actual path

    // Check if the folder already exists
    if (!file_exists($directory . $folderName)) {
        // Create the new folder
        if (mkdir($directory . $folderName, 0777, true)) {
            // Folder created successfully, now insert into the database

            // Insert folder name into the database
            $sql = "INSERT INTO folders (folder_user, folder_name) VALUES ('$user', '$folderName')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['new_folder_created'] = "success";
                    header("location: $redirect");
            } else {
                echo "Error creating folder or inserting into the database: " . $conn->error;
            }

            // Close the database connection
            $conn->close();
        } else {
            echo "Error creating folder.";
        }
    } else {
        $_SESSION['folder_exists'] = "success";
                    header("location: $redirect");
    }
}
?>