<?php
include '../config.php';
session_start();

$fid = $_GET['fid'];
$redirect = $_SERVER['HTTP_REFERER'];

$sql1 = "SELECT * from folders where folder_id = $fid";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
  // output data of each row
  while($row1 = $result1->fetch_assoc()) {
    $foldername = $row1['folder_name'];
// After fetching folder name check folder is exist or not 

    // Get the folder name to delete from the form
    $folderNameToDelete = $foldername;

    // Define the directory where the folder is located
    $directory = "../folders_list/"; // Replace with the actual path

    // Check if the folder exists in the directory
    if (file_exists($directory . $folderNameToDelete)) {
        // Delete the folder from the file system
        if (rmdir($directory . $folderNameToDelete)) {
            // Folder deleted from the file system, now delete from the database 

            // Delete folder details from the database
            $sql = "DELETE FROM folders WHERE folder_id = $fid";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['folder_deleted'] = "success";
                header("location: $redirect");
            } else {
                echo "Error deleting folder from the file system or database: " . $conn->error;
            }

            // Close the database connection
            $conn->close();
        } else {
            $_SESSION['error_delete_folder'] = "success";
            header("location: $redirect");
        }
    } else {
        echo "Folder not found in the file system.";
    }
  }
} else {
  echo "Error in fecthing folder name from database ";
}

?>